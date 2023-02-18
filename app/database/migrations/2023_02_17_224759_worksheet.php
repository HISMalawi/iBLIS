<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Worksheet extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('worksheets', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('device_name',100);
			$table->integer('worksheet_status_id')->unsigned()->default(0);
			$table->timestamp('started_at')->nullable();;
			$table->timestamp('completed_at')->nullable();;
			$table->timestamp('verified_at')->nullable();;
			$table->string('verified_by',100);

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
		Schema::dropIfExists('worksheets');
	}

}
