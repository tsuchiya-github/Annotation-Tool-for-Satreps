<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTsuchiyawebTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tsuchiyaweb', function(Blueprint $table)
		{
			$table->string('email')->comment('メールアドレス');
			$table->string('subject', 30)->comment('件名');
			$table->text('message')->comment('本文');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tsuchiyaweb');
	}

}
