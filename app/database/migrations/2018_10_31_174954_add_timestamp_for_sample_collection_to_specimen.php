<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampForSampleCollectionToSpecimen extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{	Schema::table('specimens', function(Blueprint $table)
                {

		    $table->timestamp('date_of_collection');
	
		});	//
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	     Schema::table('specimens', function(Blueprint $table)
                {

                    $table->timestamp('date_of_collection');

                }); 
		//
	}

}
