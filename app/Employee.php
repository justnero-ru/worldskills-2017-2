<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Employee
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $gender
 * @property string $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SurveyAnswer[] $answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Partner[] $partners
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Survey[] $surveys
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereRole($value)
 * @mixin \Eloquent
 */
class Employee extends Model {

	protected $fillable = [
		'name',
		'email',
		'gender',
		'role',
	];

	public function partners() {
		return $this->belongsToMany( 'App\Partner', 'partners_employees', 'employees_id', 'partners_id' )
		            ->withPivot( 'start_date', 'end_date', 'role' );
	}

	public function answers() {
		return $this->hasMany( 'App\SurveyAnswer' );
	}

	public function surveys() {
		return $this->belongsToMany( 'App\Survey' );
	}

}
