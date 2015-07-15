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
			$table->longText('image');
			$table->string('pathology_psychiatric')->nullable();
			$table->string('pathology_chronic')->nullable();
			$table->string('allergies')->nullable();
			$table->enum('index_katz', ['A', 'B', 'C', 'D', 'E', 'F', 'G']);
			$table->string('index_lawtonbrody');
			$table->string('disability_physical')->nullable();
      $table->string('disability_psychic')->nullable();
      $table->boolean('feeding_asistidad');
			$table->enum('size_diaper', ['S', 'M', 'L']);
      $table->enum('baston', ['1 point', '2 point', '3 point'])->nullable();
      $table->string('muleta')->nullable();
      $table->boolean('wheelchair')->nullable();
      $table->boolean('walker')->nullable();

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
