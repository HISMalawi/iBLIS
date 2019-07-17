<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TestCategory extends Eloquent
{
	/**
	 * Enabling soft deletes for test categories.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_categories';

	/**
	 * Test types relationship
	 *
	 */
	public function testTypes(){
         return $this->hasMany('TestType', 'test_category_id');
      }


    public function getCategories($option)
	{	if($option=="-- All --")
		{
			$types = DB::select(DB::raw("SELECT test_categories.name,test_categories.id FROM test_categories"));
		}
		else
		{  $types = DB::select(DB::raw("SELECT test_categories.name,test_categories.id FROM test_categories WHERE test_categories.id='$option'"));
		}

		return $types;
	}



    /**
	* Given the test category name we return the test category ID
	*
	* @param $testcategory - the name of the test category
	*/
	public static function getTestCatIdByName($testCategory)
	{
		try 
		{
			$testCatId = TestCategory::where('name', 'like', $testCategory)->firstOrFail();
			return $testCatId->id;
		} catch (ModelNotFoundException $e) 
		{
			Log::error("The test category ` $testCategory ` does not exist:  ". $e->getMessage());
			//TODO: send email?
			return null;
		}
	}
}