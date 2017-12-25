<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SurveyQuestion
 *
 * @property int $id
 * @property int $survey_id
 * @property string $question
 * @property int $type
 * @property string|null $options
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyQuestion whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyQuestion whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyQuestion whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyQuestion whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SurveyQuestion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SurveyQuestion extends Model {

	const TYPE_TEXT = 1;
	const TYPE_SELECT = 2;
	const TYPE_NUMBER = 3;
	const TYPES = [
		self::TYPE_TEXT   => 'Text',
		self::TYPE_SELECT => 'Option',
		self::TYPE_NUMBER => 'Number',
	];

	protected $fillable = [
		'survey_id',
		'question',
		'type',
		'options',
	];

	public function survey() {
		return $this->belongsTo( 'App\Survey' );
	}

}
