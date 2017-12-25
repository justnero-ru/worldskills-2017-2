<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;

/**
 * App\Survey
 *
 * @property int $id
 * @property string $identification
 * @property string $password
 * @property string $title
 * @property string|null $description
 * @property int $type
 * @property string|null $attachment
 * @property \Carbon\Carbon $start_at
 * @property \Carbon\Carbon $end_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SurveyAnswer[] $answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employee[] $employees
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SurveyQuestion[] $questions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey open()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereAttachment( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereEndAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereIdentification( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey wherePassword( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereStartAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereTitle( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereType( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class Survey extends Model {

	const TYPE_PUBLIC = 1;
	const TYPE_RESTRICT = 2;
	const TYPES = [
		self::TYPE_PUBLIC   => 'Public Survey',
		self::TYPE_RESTRICT => 'Restrict Survey',
	];

	protected $fillable = [
		'identification',
		'password',
		'title',
		'description',
		'type',
		'attachment',
		'start_at',
		'end_at',
	];

	protected $dates = [
		'start_at',
		'end_at',
	];

	public function questions() {
		return $this->hasMany( 'App\SurveyQuestion' );
	}

	public function answers() {
		return $this->hasMany( 'App\SurveyAnswer' );
	}

	public function employees() {
		return $this->belongsToMany( 'App\Employee' );
	}

	/**
	 * Scope a query to only include open surveys.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOpen( $query ) {
		return $query->where( 'start_at', '<=', new Expression( 'NOW()' ) )
		             ->where( 'end_at', '>=', new Expression( 'NOW()' ) );
	}

	public function setPasswordAttribute( $value ) {
		$this->attributes['password'] = bcrypt( $value );
	}

	public function checkPassword( $password ) {
		return \Hash::check( $password, $this->password );
	}

}
