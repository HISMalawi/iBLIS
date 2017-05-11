<?php

class Panel extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'panels';


	public function checkPanel($id)
	{   $status = false;
		$ids = array();

		$sql = "SELECT tests.id AS testId FROM tests WHERE tests.panel_id=(SELECT panel_id FROM tests WHERE tests.id='$id')";
		$rst = DB::select(DB::raw($sql));

		if (count($rst)>0)
		{
			$ids = $rst;
		}
		
		return $ids;
	}

}
