<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecimenLifespanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//specimen_lifespan table
		Schema::create('specimen_lifespan', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('test_type_id')->unsigned();
      $table->integer('specimen_type_id')->unsigned();
      $table->string('lifespan');

      $table->foreign('test_type_id')->references('id')->on('test_types');
      $table->foreign('specimen_type_id')->references('id')->on('specimen_types');
      $table->unique(array('test_type_id','specimen_type_id'));
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
		Schema::table('specimen_lifespan', function (Blueprint $table) {
			$table->dropForeign('specimen_lifespan_test_type_id_foreign');
			$table->dropForeign('specimen_lifespan_specimen_type_id_foreign');
		});

		Schema::drop('specimen_lifespan');
	}

}
