<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEldersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('elders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('identity_card');
			$table->string('full_name');
			$table->string('address');
			$table->char('gender');
			$table->boolean('retired');
			$table->boolean('pensioner');
			$table->string('civil_status');
			$table->date('date_birth')->nullable();
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
		Schema::drop('elders');
	}

}
