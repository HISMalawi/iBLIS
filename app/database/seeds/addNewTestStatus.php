<?php

class addNewTestStatus extends DatabaseSeeder
{
    public function run()
    { Eloquent::unguard();
    	$status = TestStatus::create(array(
    		'id' => 8,
    		'name' => 'test-rejected',
    		'test_phase_id' => 1
    	));
    }


}


