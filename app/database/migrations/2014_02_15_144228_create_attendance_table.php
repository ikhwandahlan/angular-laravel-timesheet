<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('attendance', function (Blueprint $table) {

			$table->increments('attendance_id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdade('cascade');

			$table->decimal('rate')->unsigned();

			$table->integer('payment_id')->unsigned();
			$table->foreign('payment_id')->references('payment_id')->on('payment')->onDelete('cascade')->onUpdade('cascade');

			$table->timestamp('date_from');
			$table->timestamp('date_to');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::drop('attendance');
	}

}
