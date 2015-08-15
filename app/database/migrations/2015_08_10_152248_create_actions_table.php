<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->nullable();
			$table->string('description');
			$table->string('type');
			$table->string('responsible')->nullable();
			$table->date('date_day')->nullable();
			$table->time('hour_in')->nullable();
			$table->time('hour_out')->nullable();
			$table->boolean('state');

			$table->foreign('employee_id')->references('id')->on('employees');
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
		Schema::drop('actions');
	}

}
