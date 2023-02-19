<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacilityCodeDistrictFacilityTypeToFacilities extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('facilities', function(Blueprint $table)
		{
			$table->string('facility_code')->nullable();
			$table->string('district')->nullable();
			$table->string('facility_type')->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('facilities', function(Blueprint $table)
		{
			//
            $table->dropColumn('facility_code');
			$table->dropColumn('district');
			$table->dropColumn('facility_type');

		});
	}

}
