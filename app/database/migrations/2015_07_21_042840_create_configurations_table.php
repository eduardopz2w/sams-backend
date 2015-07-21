<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigurationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configurations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name_institution');
			$table->enum('maximum_delay', [0, 5, 10, 15]);
			$table->boolean('control_menu');
			$table->boolean('control_employee');
			$table->integer('max_hours');
			$table->integer('max_permits');

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
		Schema::drop('configurations');
	}

}
