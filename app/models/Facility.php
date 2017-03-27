<?php

class Facility extends Eloquent
{
	protected $table = "facilities";



	public static function getFacilityCode($facility_name)
	{
		
			$id = Facility::where('name',$facility_name)->first()->id;


			return $id;
			
	}


}