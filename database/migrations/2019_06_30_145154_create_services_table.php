<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('title');
			$table->text('description', 65535);
			$table->float('price', 10, 0);
			$table->float('fees', 10, 0)->default(0);
			$table->string('p_method');
			$table->string('currency');
			$table->string('pm_slug')->nullable();
			$table->integer('duration');
			$table->integer('purchases_number')->default(0);
			$table->integer('remaining')->default(1);
			$table->string('img_path');
			$table->string('the_status')->default('open');
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
		Schema::drop('services');
	}

}
