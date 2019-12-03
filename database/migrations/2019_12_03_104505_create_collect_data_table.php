<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCollectDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('collect_data', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('gender', 11);
			$table->string('age', 33);
			$table->string('nationality', 33);
			$table->string('image_type', 50);
			$table->string('image_name', 50);
			$table->text('image_path');
			$table->integer('comfortable');
			$table->string('factors', 100);
			$table->float('rect_sx', 10, 0);
			$table->float('rect_sy', 10, 0);
			$table->float('rect_ex', 10, 0);
			$table->float('rect_ey', 10, 0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('collect_data');
	}

}
