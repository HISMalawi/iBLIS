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

		public static function verifiedWorksheet($worksheetNumber=0){
			$res = Worksheet::find($worksheetNumber);
			if(count($res) >0){
				$res->worksheet_status_id = Worksheet::VERIFIED;
				$res->verified_at =  date('Y-m-d H:i:s');
				$res->save();

				$tests = DB::SELECT("SELECT * FROM tests WHERE worksheet_id='$worksheetNumber'");
				if(count($tests) > 0){
					foreach($tests as $test){
						$tst = Test::find($test->id);
						$tst->test_status_id = Worksheet::VERIFIED;
						$tst->time_verified = date('Y-m-d H:i:s');
						$tst->verified_by = "";
						$tst->save();

						$dat = new UnsyncOrder;
						$dat->specimen_id = $test->id;
						$dat->data_not_synced = "verified";
						$dat->data_level = "test";
						$dat->sync_status = "not-synced";
						$dat->updated_by_name = "";
						$dat->updated_by_id = "" ;
						$dat->save();
					}
					return true;
				}else{
					return false;
				}
			}
		}

	
   	 
}
