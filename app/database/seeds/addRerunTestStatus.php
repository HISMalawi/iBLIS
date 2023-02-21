<?php

class addRerunTestStatus extends DatabaseSeeder
{
    public function run()
    { Eloquent::unguard();
    	$status = TestStatus::create(array(
    		'id' => 9,
    		'name' => 'rerun-test',
    		'test_phase_id' => 1
    	));
    }


}


