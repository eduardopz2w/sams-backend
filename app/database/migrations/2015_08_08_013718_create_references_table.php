<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReferencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('references', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('elder_id')->unsigned();
			$table->integer('citation_id')->unsigned();
			$table->mediumText('treatment');
			$table->mediumText('description');
			$table->string('expert');
			$table->date('issued');

			$table->foreign('elder_id')->references('id')->on('elders')->onDelete('cascade');
			$table->foreign('citation_id')->references('id')->on('citations');
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
		Schema::drop('references');
	}

}
