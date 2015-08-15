<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActionScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('action_schedule', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('action_id')->unsigned()->index();
			$table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
			$table->integer('schedule_id')->unsigned()->index();
			$table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
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
		Schema::drop('action_schedule');
	}

}
