<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attendances', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->time('retardation');
			$table->time('extra_hours');
			$table->char('state');
			$table->string('turn');
			$table->time('start_time');
			$table->time('departure_time');
			$table->time('check_in')->nullable();
			$table->time('check_out')->nullable();
			$table->integer('notifying_id')->nullable();
			$table->string('notifying_type')->nullable();
			$table->date('date_day');

			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
		Schema::drop('attendances');
	}

}
