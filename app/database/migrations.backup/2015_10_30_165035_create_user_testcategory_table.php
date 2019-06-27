<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTestcategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_testcategory', function ($table) {
						$table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('test_category_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users'); 
            $table->foreign('test_category_id')->references('id')->on('test_categories');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_testcategory', function (Blueprint $table) {
            $table->dropForeign('user_testcategory_user_id_foreign');
            $table->dropForeign('user_testcategory_test_category_id_foreign');
        });        

        Schema::drop('user_testcategory');
	}

}
