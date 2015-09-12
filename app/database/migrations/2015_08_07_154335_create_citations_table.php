<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('citations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('elder_id')->unsigned();
			$table->string('state');
			$table->date('date_day');
			$table->time('hour');
			$table->string('reason');
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
		Schema::drop('citations');
	}

}
