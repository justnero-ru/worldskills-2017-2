<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyAnswersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'survey_answers', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'survey_id' )
			      ->references( 'id' )
			      ->on( 'surveys' )
			      ->onDelete( 'delete' );
			$table->integer( 'employee_id' )
			      ->nullable()
			      ->references( 'id' )
			      ->on( 'employees' );
			$table->text( 'answers' )
			      ->nullable();
			$table->string( 'ip' )
			      ->nullable();
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'survey_answers' );
	}
}
