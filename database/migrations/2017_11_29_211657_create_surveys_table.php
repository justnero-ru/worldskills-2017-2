<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'surveys', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'identification' )
			      ->unique();
			$table->string( 'password' );
			$table->string( 'title' );
			$table->text( 'description' )
			      ->nullable();
			$table->smallInteger( 'type' );
			$table->string( 'attachment' )
			      ->nullable();
			$table->date( 'start_at' );
			$table->date( 'end_at' );
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'surveys' );
	}
}
