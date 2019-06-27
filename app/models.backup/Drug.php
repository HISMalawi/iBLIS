<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Drug extends Eloquent
{
	/**
	 * Enabling soft deletes for drugs.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'drugs';


	function getOrganismDrugs($organismName)
	{
		$sql = "SELECT drugs.name AS drugName, drugs.id AS drugId FROM organisms INNER JOIN organism_drugs ON organism_drugs.organism_id =
		organisms.id INNER JOIN drugs ON drugs.id = organism_drugs.drug_id WHERE organisms.name='$organismName'";
		
		$drugs = DB::select(DB::raw($sql));

		
		return $drugs;
	}
}