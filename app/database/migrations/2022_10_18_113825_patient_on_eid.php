<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatientOnEid extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//

		Schema::create('patients_on_eid', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('specimen_id')->unsigned()->default(0);
			$table->string('Unique_child_id',100);
			$table->string('caregive_surname',100);
			$table->string('caregiver_firstname',100);
            $table->integer('HTC_provider')->unsigned()->default(0);
			$table->string('lasec_barcode',100);

            $table->index('specimen_id');
            $table->index('lasec_barcode'); 
			$table->foreign('specimen_id')->references('id')->on('specimens');

			$table->softDeletes();
            $table->timestamps();
        });
		//
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::dropIfExists('patients_on_eid');
	}

}
