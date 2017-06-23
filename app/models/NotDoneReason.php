<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class NotDoneReason extends Eloquent
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
	protected $table = 'not_done_reasons';


	function getNotDoneReasons()
	{
		$sql = "SELECT reason,id FROM not_done_reasons";		
		$reasons = DB::select(DB::raw($sql));

		return $reasons;
	}

	function updateReason($id,$reason)
	{
		$sql = "UPDATE not_done_reasons SET reason='$reason' WHERE id='$id'";
		DB::update(DB::raw($sql));
	}

	function deleteReason($id)
	{
		$sql = "DELETE FROM not_done_reasons WHERE id='$id'";
		DB::update(DB::raw($sql));
	}

	function checkReasonInUse($id)
	{	$status = false;
		$sql = "SELECT id FROM tests WHERE tests.not_done_reasons='$id'";
		$rs = DB::select(DB::raw($sql));

		if(count($rs)>0)
		{
			$status = true;
		}
		
		return $status;

	}
}