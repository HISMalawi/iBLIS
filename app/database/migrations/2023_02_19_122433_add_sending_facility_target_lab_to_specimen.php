<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSendingFacilityTargetLabToSpecimen extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('specimens', function(Blueprint $table)
		{
			$table->string('sending_facility_id')->nullable();
			$table->string('target_lab')->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('specimens', function($table)
		{
			//
            $table->dropColumn('sending_facility_id');
			$table->dropColumn('target_lab');

		});
	}

}
