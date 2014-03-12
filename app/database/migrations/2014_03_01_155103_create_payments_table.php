<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('payments', function (Blueprint $table) {

			$table->increments('payment_id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdade('cascade');

			$table->integer('amount')->unsigned();
			$table->integer('days')->unsigned();
			$table->integer('hours')->unsigned();

			$table->boolean('payed')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::drop('payments');
	}

}
