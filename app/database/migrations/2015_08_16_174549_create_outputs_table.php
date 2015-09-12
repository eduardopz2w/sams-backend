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
			$table->string('info')->nullable();
			$table->date('date_start')->nullable();
			$table->date('date_end')->nullable();
			$table->string('type');
			$table->boolean('state');
			$table->foreign('elder_id')->references('id')->on('elders')->onDelete('cascade');
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
