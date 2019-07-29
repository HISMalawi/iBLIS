<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CapturingNotDoneReasons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tests', function(Blueprint $table)
		{
			//
			$table->string('not_done_reasons');
            $table->string('person_talked_to_for_not_done');      

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tests', function(Blueprint $table)
		{
			//
			$table->string('not_done_reasons');
            $table->string('person_talked_to_for_not_done');

		});
	}


}
