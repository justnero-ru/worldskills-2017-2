<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPartnersEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('partners_employees', function(Blueprint $table)
		{
			$table->foreign('employees_id', 'partners_employees_ibfk_1')->references('id')->on('employees')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('partners_id', 'partners_employees_ibfk_2')->references('id')->on('partners')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('partners_employees', function(Blueprint $table)
		{
			$table->dropForeign('partners_employees_ibfk_1');
			$table->dropForeign('partners_employees_ibfk_2');
		});
	}

}
