<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKadai4Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kadai4', function(Blueprint $table)
		{
			$table->string('name', 30)->nullable();
			$table->float('stock', 10, 0)->nullable();
			$table->float('price', 10, 0)->nullable();
			$table->float('amount', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kadai4');
	}

}
