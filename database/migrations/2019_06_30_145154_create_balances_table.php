<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBalancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('balances', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('user_id')->unsigned()->index('balances_user_id_foreign');
			$table->integer('ccp')->default(0);
			$table->float('paypal_usd')->default(0.00);
			$table->float('paypal_euro')->default(0.00);
			$table->float('paysera_usd')->default(0.00);
			$table->float('paysera_euro')->default(0.00);
			$table->integer('hold_ccp')->default(0);
			$table->float('hold_paypal_usd')->default(0.00);
			$table->float('hold_paypal_euro')->default(0.00);
			$table->float('hold_paysera_usd')->default(0.00);
			$table->float('hold_paysera_euro')->default(0.00);
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
		Schema::drop('balances');
	}

}
