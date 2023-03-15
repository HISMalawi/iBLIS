<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FastTrackedViralLoadTests extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

	 /* changed schema*/
	public function up()
	{
		Schema::create('fast_tracked_viral_load_tests', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('tracking_number',100);
			$table->integer('measure_id')->unsigned()->default(0);
			$table->string('result',100);
			$table->string('device_name',100);
			$table->integer('worksheet_number')->unsigned()->default(0);
			$table->string('sync_status',100);
			$table->timestamp('synced_at')->default(DB::raw('CURRENT_TIMESTAMP'));

			$table->softDeletes();
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
		Schema::dropIfExists('fast_tracked_viral_load_tests');
	}

}
