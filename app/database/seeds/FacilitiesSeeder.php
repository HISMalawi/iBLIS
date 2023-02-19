<?php

class FacilitiesSeeder extends DatabaseSeeder
{
    public function run()
    { Eloquent::unguard();
	
		$faciities = fopen(base_path("app/database/seeds/facilities.csv"),"r");
		$firstLine = true;
		while(($facility = fgetcsv($faciities, 2000, ",")) !== FALSE){
			
			if(!$firstLine){
				Facility::create([
					"name" => $facility[4],
					"facility_code" => $facility[1],
					"district" => $facility[3],
					"facility_type" => $facility[6]
				]);
			}
			$firstLine = false;
		}
		
		fclose($faciities);
    }


}


