<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->string('reason', 150);
			$table->date('date_star');
			$table->date('date_end')->nullable();
			$table->enum('turn', ['morning', 'afternoon', 'night', 'complete']);
			$table->boolean('state');
			$table->string('type');

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
		Schema::drop('permits');
	}

}
