<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Susceptibility extends Eloquent
{
	/**
	 * Enabling soft deletes for drug susceptibility.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'drug_susceptibility';
	/**
	 * User relationship
	 */
	public function user()
	{
	  return $this->belongsTo('User', 'user_id');
	}
	/**
	 * Test relationship
	 */
	public function test()
    {
        return $this->hasOne('Test', 'test_id');
    }
    /*
    *	Function to return drug susceptibility given testId, organismId and drugId
    *
    */
    public static function getDrugSusceptibility($test_id, $organism_id, $drug_id){

    	$susceptibility = Susceptibility::where('test_id', $test_id)
    									->where('organism_id', $organism_id)
    									->where('drug_id', $drug_id)
    									->first();
    	return $susceptibility;
    }

	public static function drugs_search($test_id,$organism_id){
		$drugs = Susceptibility::where('test_id', $test_id)
			->where('organism_id', $organism_id)
			->whereRaw("COALESCE(interpretation, '') != '' ")
			->selectRaw('distinct drug_id')->get();

		return $drugs;
	}

	public function getOrganismSusceptibility($organismId,$drugId)
	{
			$sql = "SELECT drug_susceptibility.interpretation AS inter, drug_susceptibility.test_id AS testId FROM drug_susceptibility WHERE drug_susceptibility.organism_id='$organismId' AND drug_susceptibility.drug_id='$drugId'";
			$susc = DB::select(DB::raw($sql));

			return $susc;
	}


}