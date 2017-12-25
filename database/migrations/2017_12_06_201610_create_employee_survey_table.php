<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSurveyTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'employee_survey', function ( Blueprint $table ) {
			$table->integer( 'employee_id' )->index( 'employees_id' );
			$table->integer( 'survey_id' )->index( 'survey_id' );

			$table->primary( [ 'employee_id', 'survey_id' ] );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'employee_survey' );
	}
}
