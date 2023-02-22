<?php

class addNewSpecimenStatus extends DatabaseSeeder
{
    public function run()
    { Eloquent::unguard();
    	$status = SpecimenStatus::create(array(
    		'id' => 4,
    		'name' => 'specimen-collected'
    	));
    }


}


