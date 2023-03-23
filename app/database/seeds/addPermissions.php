<?php

class addPermissions extends DatabaseSeeder
{
    public function run()
    { Eloquent::unguard();

		     /* Permissions table */
			 $permissions = array(
				array("name" => "print_worksheet", "display_name" => "Can print tests in worksheet"),
				array("name" => "verify_worksheet", "display_name" => "Can approve worksheet"),	
				array("name" => "register_viral_load", "display_name" => "Can register viral load"),
				array("name" => "receive_sample", "display_name" => "Can reeive sample"),
				array("name" => "view_re-run", "display_name" => "Can view reruns"),
				array("name" => "view worksheet", "display_name" => "Can view worksheet")
			);
			foreach ($permissions as $permission) {
				Permission::create($permission);
			}
			$this->command->info('Permissions table seeded');	
    }


}


