<?php

class FastTrackedViralLoadTest extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fast_tracked_viral_load_tests';
	public $timestamps = true;
   	 


	public static function retrieveFastTrackedTest($tracking_number){
		$res = DB::SELECT("SELECT * FROM fast_tracked_viral_load_tests WHERE tracking_number='$tracking_number' AND sync_status='false'");
		if(count($res)> 0){
			return [true,$res[0]->measure_id,$res[0]->result,$res[0]->created_at,$res[0]->id,$res[0]->worksheet_number];
		}else{
			return [false,0];
		}
	}

	public static function syncFastTrackedTest($id){
		$res = FastTrackedViralLoadTest::find($id);
		$res->sync_status = "true";
		$res->synced_at = date('Y-m-d H:i:s');
		$res->save();
	}

}
