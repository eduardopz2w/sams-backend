<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOutputsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('outputs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('elder_id')->unsigned();
			$table->integer('employee_id')->unsigned()->nullable();
			$table->integer('relative_id')->unsigned()->nullable();
			$table->string('image_url')->nullable();
			$table->string('mime')->nullable();
			$table->time('hour_output');
			$table->time('hour_arrival');
			$table->date('date_init');
			$table->date('date_end');
			$table->string('type');
			$table->string('address');
			$table->boolean('state');

			$table->foreign('elder_id')->references('id')->on('elders')->onDelete('cascade');
			$table->foreign('employee_id')->references('id')->on('employees');
			$table->foreign('relative_id')->references('id')->on('relatives');
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
		Schema::drop('outputs');
	}

}
