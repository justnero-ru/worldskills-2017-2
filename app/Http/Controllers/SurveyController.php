<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Survey;
use App\SurveyAnswer;
use App\SurveyQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SurveyController extends Controller {

	public function index() {
		$surveys = Survey::open()->get();

		return view( 'survey.index', compact( 'surveys' ) );
	}

	public function create() {
		$employees = Employee::with( 'partners' )->get();


		return view( 'survey.create', compact( 'employees' ) );
	}

	public function store( Request $request ) {
		$this->validate( $request, [
			'identification'      => 'required|string|min:3|unique:surveys',
			'password'            => 'required|string|min:8',
			'title'               => 'required|string',
			'description'         => 'string|nullable',
			'type'                => [ 'required', Rule::in( array_keys( Survey::TYPES ) ) ],
			'filter'              => 'required_if:type,' . Survey::TYPE_RESTRICT . '|array',
			'attachment'          => 'image|max:1024|mimes:jpeg,png|nullable',
			'start_at'            => 'required|date',
			'end_at'              => 'required|date|after:start_at',
			'question'            => 'required|array|min:1',
			'question.*'          => 'required|array',
			'question.*.question' => 'required',
			'question.*.type'     => [ 'required', Rule::in( array_keys( SurveyQuestion::TYPES ) ) ],
			'question.*.options'  => 'required_if:question.*.type,' . SurveyQuestion::TYPE_SELECT,
		] );

		if ( $request->hasFile( 'attachment' ) ) {
			$file     = $request->file( 'attachment' );
			$filename = md5( $file->getClientOriginalName() . time() ) . '.' . $file->getClientOriginalExtension();
			$file->storePubliclyAs( 'upload', $filename, [ 'disk' => 'public' ] );
			$data               = $request->all();
			$data['attachment'] = $filename;
			$request->replace( $data );
		}

		$survey = new Survey( $request->except( 'filter', 'question' ) );
		if ( $request->hasFile( 'attachment' ) ) {
			$file     = $request->file( 'attachment' );
			$filename = md5( $file->getClientOriginalName() . time() ) . '.' . $file->getClientOriginalExtension();
			$file->storePubliclyAs( 'survey', $filename, [ 'disk' => 'public' ] );
			$survey->attachment = $filename;
		}
		$survey->save();

		foreach ( $request->get( 'question' ) as $q ) {
			$survey->questions()
			       ->create( $q );
		}
		if ( $survey->type == Survey::TYPE_RESTRICT ) {
			foreach ( $request->get( 'filter' ) as $employee_id => $filter ) {
				$survey->employees()
				       ->attach( $employee_id );
			}
		}

		return redirect()
			->route( 'survey.created', $survey->identification );
	}

	/**
	 * @param Request $request
	 * @param Survey $survey
	 *
	 * @return array
	 */
	public function answer( Request $request, Survey $survey ) {
		$this->validate( $request, [
			'answers'   => 'required|array|min:1',
			'answers.*' => 'required',
		] );

		$answer = new SurveyAnswer( [
			'answers' => $request->get( 'answers' ),
			'ip'      => $request->ip(),
		] );
		if ( $survey->type == Survey::TYPE_RESTRICT ) {
			if ( ! session()->has( 'email' ) ) {
				return [ 'status' => 403, 'redirect' => route( 'survey.login', $survey ) ];
			}
			$employee = Employee::whereEmail( session( 'email' ) )->firstOrFail();
			if ( ! $survey->employees()->whereKey( $employee->id )->exists() ) {
				return [ 'status' => 403, 'redirect' => route( 'survey.login', $survey ) ];
			}
			$answer->employee_id = $employee->id;
		}

		$today = Carbon::now();
		if ( $today->lt( $survey->start_at->copy()->startOfDay() ) || $today->gt( $survey->end_at->copy()->endOfDay() ) ) {
			return [ 'status' => 400, 'message' => 'Survey is not available' ];
		}
		$survey->answers()->save( $answer );

		return [ 'status' => 200, 'message' => 'Answer accepted' ];
	}

	public function created( $survey_slug ) {
		$survey = Survey::whereIdentification( $survey_slug )->firstOrFail();

		return view( 'survey.created', compact( 'survey' ) );
	}

	public function view( Survey $survey ) {
		$survey->load( 'questions', 'employees' );
		if ( $survey->type == Survey::TYPE_RESTRICT ) {
			if ( ! session()->has( 'email' ) ) {
				return redirect()->route( 'survey.login', $survey );
			}
			$employee = Employee::whereEmail( session( 'email' ) )->firstOrFail();
			if ( ! $survey->employees()->whereKey( $employee->id )->exists() ) {
				return redirect()->route( 'survey.login', $survey );
			}
		}

		return view( 'survey.view', compact( 'survey' ) );
	}

	public function login( Survey $survey ) {
		if ( $survey->type == Survey::TYPE_RESTRICT ) {
			if ( session()->has( 'email' ) ) {
				$employee = Employee::whereEmail( session( 'email' ) )->firstOrFail();
				if ( $survey->employees()->whereKey( $employee->id )->exists() ) {
					return redirect()->route( 'survey.view', $survey );
				}
			}

			return view( 'login', compact( 'survey' ) );
		} else {
			return redirect()->route( 'survey.view', $survey );
		}
	}

	public function auth( Request $request, Survey $survey ) {
		if ( ! $request->has( 'email' ) || $request->get( 'email' ) == '' ) {
			return [ 'status' => 403, 'message' => 'ACCESS NOT PERMITTED' ];
		}
		$employee = Employee::whereEmail( $request->get( 'email' ) )->first();
		if ( ! $employee || ! $survey->employees()->whereKey( $employee->id )->exists() ) {
			return [ 'status' => 403, 'message' => 'ACCESS NOT PERMITTED' ];
		}

		session()->put( 'email', $request->get( 'email' ) );

		return [ 'status' => 200, 'redirect' => route( 'survey.view', $survey ) ];
	}

	public function manage_login( $survey_slug ) {
		$survey = Survey::whereIdentification( $survey_slug )->firstOrFail();
		if ( $survey && session()->has( 'password' ) && $survey->checkPassword( session( 'password' ) ) ) {
			return redirect()->route( 'survey.manage', $survey_slug );
		}

		return view( 'manage_login', compact( 'survey_slug' ) );
	}

	public function manage_auth( Request $request, $survey_slug ) {
		$survey = Survey::whereIdentification( $survey_slug )->first();
		if ( ! $survey || ! $request->has( 'password' ) || $request->get( 'password' ) == '' ) {
			return [ 'status' => 403, 'message' => 'ACCESS NOT PERMITTED' ];
		}
		if ( ! $survey->checkPassword( $request->get( 'password' ) ) ) {
			return [ 'status' => 403, 'message' => 'ACCESS NOT PERMITTED' ];
		}

		session()->put( 'password', $request->get( 'password' ) );

		return [ 'status' => 200, 'redirect' => route( 'survey.manage', $survey_slug ) ];
	}

	public function manage( $survey_slug ) {
		$survey = Survey::whereIdentification( $survey_slug )->first();
		if ( ! $survey ) {
			return redirect()->route( 'survey.manage_login', $survey_slug );
		}
		if ( ! session()->has( 'password' ) || ! $survey->checkPassword( session( 'password' ) ) ) {
			return redirect()->route( 'survey.manage_login', $survey_slug );
		}
		$survey->load( 'questions', 'employees', 'answers' );

		return view( 'survey.manage', compact( 'survey' ) );
	}

	public function manage_delete( $survey_slug ) {
		$survey = Survey::whereIdentification( $survey_slug )->first();
		if ( ! $survey ) {
			return redirect()->route( 'survey.manage_login', $survey_slug );
		}
		if ( ! session()->has( 'password' ) || ! $survey->checkPassword( session( 'password' ) ) ) {
			return redirect()->route( 'survey.manage_login', $survey_slug );
		}
		$survey->delete();
		session()->remove( 'password' );

		return redirect()->route( 'home' );
	}

	public function manage_logout( $survey_slug ) {
		session()->remove( 'password' );

		return redirect()->route( 'home' );
	}

	/**
	 * @param Survey $survey
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
	 * @throws \League\Flysystem\FileNotFoundException
	 */
	public function preview( Survey $survey ) {
		$disk = \Storage::disk( 'upload' );

		return response( $disk->get( $survey->attachment ), 200, [ 'content-type' => $disk->getMimetype( $survey->attachment ) ] );
	}

}
