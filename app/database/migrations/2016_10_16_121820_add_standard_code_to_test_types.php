<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStandardCodeToSpecimenTypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_types', function(Blueprint $table)
		{
			//
            $table->string('hl7_identifier');
            $table->string('hl7_text');
            $table->string('hl7_coding_system');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('test_types', function(Blueprint $table)
		{
			//
            $table->dropColumn('hl7_identifier');
            $table->dropColumn('hl7_text');
            $table->dropColumn('hl7_coding_system');
		});
	}

}
