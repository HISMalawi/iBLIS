<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestOrganims extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test_organisms', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('test_id')->unsigned();
            $table->integer('result_id')->unsigned();
			$table->integer('organism_id')->unsigned();		
			$table->timestamps();		

            $table->foreign('test_id')->references('id')->on('tests');            
			$table->foreign('organism_id')->references('id')->on('organisms');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		 Schema::table('test_organisms', function (Blueprint $table) {
            
            $table->dropForeign('test_organisms_test_id_foreign');            
			$table->dropForeign('test_organisms_organism_id_foreign');
            
        });

		Schema::drop('test_organisms');
	}

}
