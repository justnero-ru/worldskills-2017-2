<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Partner
 *
 * @property int $id
 * @property string $companyName
 * @property string $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employee[] $employees
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereId($value)
 * @mixin \Eloquent
 */
class Partner extends Model {

	protected $fillable = [
		'companyName',
		'country',
	];

	public function employees() {
		return $this->belongsToMany( 'App\Employee', 'partners_employees', 'partners_id', 'employees_id' )
		            ->withPivot( 'start_date', 'end_date', 'role' );
	}

}
