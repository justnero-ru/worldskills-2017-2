<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'survey_questions', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'survey_id' )
			      ->references( 'id' )
			      ->on( 'surveys' )
			      ->onDelete( 'delete' );
			$table->string( 'question' );
			$table->smallInteger( 'type' )
			      ->default( 0 );
			$table->string( 'options' )
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
		Schema::dropIfExists( 'survey_questions' );
	}
}
