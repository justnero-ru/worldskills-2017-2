<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SurveyAnswer
 *
 * @property int $id
 * @property int $survey_id
 * @property int|null $employee_id
 * @property array $answers
 * @property string|null $ip
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Employee|null $employee
 * @property-read \App\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyAnswer whereAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyAnswer whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyAnswer whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyAnswer whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyAnswer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SurveyAnswer extends Model {

	protected $fillable = [
		'survey_id',
		'employee_id',
		'answers',
		'ip',
	];

	protected $casts = [
		'answers' => 'array',
	];

	public function survey() {
		return $this->belongsTo( 'App\Survey' );
	}

	public function employee() {
		return $this->belongsTo( 'App\Employee' );
	}

}
