<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArvNumberToPatientOnArt extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('patients_on_art', function(Blueprint $table)
		{
			$table->string('arv_number')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('patients_on_art', function(Blueprint $table)
		{
			//
            $table->dropColumn('arv_number');
		});
	}

}
