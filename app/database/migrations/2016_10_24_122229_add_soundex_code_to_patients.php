<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoundexCodeToPatients extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('patients', function(Blueprint $table)
		{
			//
			DB::statement('ALTER TABLE patients MODIFY name VARCHAR(255);');
            $table->string('first_name_code')->nullable();;
            $table->string('last_name_code')->nullable();;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('patients', function(Blueprint $table)
		{
			//
			DB::statement('ALTER TABLE patients MODIFY name VARCHAR(100)');
            $table->dropColumn('first_name_code');
            $table->dropColumn('last_name_code');
		});
	}

}
