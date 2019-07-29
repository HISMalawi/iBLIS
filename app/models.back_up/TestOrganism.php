<?php

class TestOrganism extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_organisms';

	public $timestamps = false;

	public function updateTestOrganisms($id,$result_id,$organism_id)
	{		$dat = date('Y-m-d H:i:s');
			$sql = "UPDATE test_organisms SET test_id='$id' WHERE test_id='$id'";
			DB::update(DB::raw($sql));

			$sql = "UPDATE test_organisms SET result_id ='$result_id' WHERE test_id='$id'";
			DB::update(DB::raw($sql));

			$sql = "UPDATE test_organisms SET organism_id ='$organism_id' WHERE test_id='$id'";
			DB::update(DB::raw($sql));

			$sql = "UPDATE test_organisms SET created_at ='$dat' WHERE test_id='$id'";
			DB::update(DB::raw($sql));
	}
}
