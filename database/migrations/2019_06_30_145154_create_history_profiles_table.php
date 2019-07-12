<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHistoryProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('history_profiles', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('user_id')->unsigned()->index('history_profiles_user_id_foreign');
			$table->string('name')->nullable();
			$table->integer('seriousness')->nullable();
			$table->integer('phone')->nullable();
			$table->string('email')->nullable();
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password')->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->boolean('is_admin')->nullable();
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
		Schema::drop('history_profiles');
	}

}
