<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOccurrencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occurrences', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('elder_id')->unsigned();
			$table->string('case_situation');
			$table->date('date');
			$table->string('image_url')->nullable();
			$table->string('mime')->nullable();

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
		Schema::drop('occurrences');
	}

}
