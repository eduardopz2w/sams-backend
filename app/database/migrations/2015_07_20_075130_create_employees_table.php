<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('identity_card');
			$table->string('mime');
			$table->string('image_url', 200);
			$table->string('first_name');
			$table->string('last_name');
			$table->date('date_birth');
			$table->string('phone');
			$table->string('address', 100);
			$table->char('gender');
			$table->string('degree_instruction');
			$table->string('civil_status');
			$table->string('office');
			$table->boolean('activiti');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employees');
	}

}
