<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PatientReportPrintStatus extends Eloquent
{
	/**
	 * Enabling soft deletes for Measures.
	 *
	 */

	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'patient_report_print_statuses';

	/**
	 * Measure constants
	 */
	const NUMERIC = 1;
	const ALPHANUMERIC = 2;
	const AUTOCOMPLETE = 3;
	const FREETEXT = 4;

	/**
	 * test relationship
	 */
	public function tests()
	{
	  return $this->hasMany('Specimen');
	}

	/**
	 * user relationship
	 */
	public function users()
	{
	  return $this->hasMany('User');
	}

	public  function get_print_status($visit_id)
	{

		$sql = "SELECT count(*) AS print_count FROM patient_report_print_statuses 
				WHERE patient_report_print_statuses.specimen_id = (
					SELECT tests.specimen_id FROM tests WHERE tests.visit_id ='$visit_id' LIMIT 1 
				)";

		$rs = DB::select(DB::raw($sql));

		if(count($rs)>0)
		{
			return $rs[0]->print_count; 
		}
		else
		{
			return false;
		}

	}


}
