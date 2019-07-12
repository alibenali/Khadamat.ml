<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments_offers', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('user_id')->unsigned()->index('payments_offers_user_id_foreign');
			$table->integer('conversation_id')->unsigned()->index('payments_offers_conversation_id_foreign');
			$table->integer('payment_id')->unsigned()->index('payments_offers_payment_id_foreign');
			$table->text('title', 65535);
			$table->text('details', 65535);
			$table->string('pm_slug');
			$table->string('p_method');
			$table->string('currency')->nullable();
			$table->float('price');
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
		Schema::drop('payments_offers');
	}

}
