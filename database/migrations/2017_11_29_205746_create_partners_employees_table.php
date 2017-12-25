<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartnersEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('partners_employees', function(Blueprint $table)
		{
			$table->integer('employees_id')->index('employees_id');
			$table->integer('partners_id')->index('partners_id');
			$table->date('start_date');
			$table->date('end_date')->nullable();
			$table->string('role', 50);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('partners_employees');
	}

}
