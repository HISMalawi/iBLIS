<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Organism extends Eloquent
{
	/**
	 * Enabling soft deletes for organisms.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'organisms';
	/**
	 * Drugs relationship
	 */
	public function drugs()
	{
	  return $this->belongsToMany('Drug', 'organism_drugs');
	}
	/**
	 * Set compatible drugs
	 *
	 * @return void
	 */
	public function setDrugs($drugs, $resetAll = true){

		$drugsAdded = array();
		$organismID = 0;	

		if(is_array($drugs)){
			foreach ($drugs as $key => $value) {
				$drugsAdded[] = array(
					'organism_id' => (int)$this->id,
					'drug_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$organismID = (int)$this->id;
			}

		}

		if($resetAll) {
			// Delete existing test_type measure mappings
			DB::table('organism_drugs')->where('organism_id', '=', $organismID)->delete();
		}
		// Add the new mapping
		DB::table('organism_drugs')->insert($drugsAdded);
	}


	public function getOrganisms()
	{
		$sql ="SELECT organisms.name AS organismName, organisms.id AS organismsId FROM organisms";
		$organisms = DB::select(DB::raw($sql));

		return $organisms;
	}

	public function deleteTestOrganisms($test_id)
	{	
		$sql = "DELETE FROM test_organisms WHERE test_organisms.test_id='$test_id'";
		DB::update(DB::raw($sql));
	}

	public function deleteTestOrganismsByOrgId($test_id,$orgId)
	{	
		$sql = "DELETE FROM test_organisms WHERE test_organisms.test_id='$test_id' AND test_organisms.organism_id='$orgId'";
		DB::update(DB::raw($sql));
	}

}