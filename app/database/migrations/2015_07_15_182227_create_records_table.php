<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('records', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('elder_id')->unsigned();
			$table->string('image_url');
			$table->string('mime');
			$table->string('pathology_psychiatric')->nullable();
			$table->string('pathology_chronic')->nullable();
			$table->string('disability_moto')->nullable();
			$table->string('disability_visual')->nullable();
			$table->string('disability_hearing')->nullable();
			$table->boolean('self_validating');
			$table->string('allergies')->nullable();
			$table->enum('index_katz', ['A', 'B', 'C', 'D', 'E', 'F', 'G']);
			$table->integer('index_lawtonbrody');
			$table->integer('disability_physical');//indice incapacidad fisica
      $table->integer('disability_psychic');//indice incapacidad psiquica
      $table->boolean('feeding_assisted');
			$table->enum('size_diaper', ['S', 'M', 'L', 'No aplica'])->nullable();
      $table->enum('baston', ['1 point', '4 point', '3 point', 'No aplica'])->nullable();
      $table->string('muleta')->nullable();
      $table->boolean('wheelchair');
      $table->boolean('walker');
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
		Schema::drop('records');
	}

}
