<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatientReportPrintStatues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('patient_report_print_statuses', function ($table) {
			$table->increments('id')->unsigned();
			$table->string('specimen_id');
		    $table->string('printed_by');
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('patient_report_print_statuses');
	}

}
