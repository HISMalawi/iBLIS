<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UnsyncOrder extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unsync_orders', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('specimen_id');
            $table->string('data_not_synced');
            $table->string('data_level');
            $table->string('sync_status');
            $table->string('updated_by_name')->nullable();
            $table->integer('updated_by_id')->nullable();

            $table->index('specimen_id');
			$table->index('sync_status');
			$table->index('data_level');
			$table->index('data_not_synced');
            
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
		Schema::dropIfExists('unsync_orders');
	}

}
