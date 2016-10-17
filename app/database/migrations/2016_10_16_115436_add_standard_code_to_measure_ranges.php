<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStandardCodeToMeasureRanges extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('measure_ranges', function(Blueprint $table)
		{
			//
            $table->string('hl7_identifier');
            $table->string('hl7_text');
            $table->string('hl7_coding_system');
            $table->string('hl7_measure_type_override');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('measure_ranges', function(Blueprint $table)
		{
			//
            $table->dropColumn('hl7_identifier');
            $table->dropColumn('hl7_text');
            $table->dropColumn('hl7_coding_system');
            $table->string('hl7_measure_type_override');
		});
	}

}
