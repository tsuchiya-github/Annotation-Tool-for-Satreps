<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSatrepsImageDatabaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('satreps_image_database', function(Blueprint $table)
		{
			$table->integer('ID', true);
			$table->string('image_type', 50);
			$table->string('image_name', 50);
			$table->text('image_path');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('satreps_image_database');
	}

}
