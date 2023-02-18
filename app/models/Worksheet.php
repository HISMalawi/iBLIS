<?php

class Worksheet extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'worksheets';
	public $timestamps = true;

	const NOT_RECEIVED = 1;
	const PENDING = 2;
	const STARTED = 3;
	const COMPLETED = 4;
	const VERIFIED = 5;
	const VOIDED = 6;
	const NOT_DONE = 7;
	const TEST_REJECTED = 8;

	const WORKSHEET_LIMIT = 11;
	
	  	public static function checkSpecimen($specimenId){
        	$res = DB::select ("SELECT * FROM specimens WHERE tracking_number='$specimenId' OR accession_number='$specimenId'");
        	if (count($res) > 0 ){
				return [true,$res[0]->id];
        	}else{
				return [false,0];
			}
		}


		public static function checkWorksheet(){
			$res = DB::select("SELECT * FROM worksheets GROUP BY id DESC LIMIT 1");
			if(count($res)>0){
				return [true,$res[0]->tests_assigned,$res[0]->id];
			}else{
				return [false,0];
			}

		}

	
   	 
}
