<?php

class FacilityWard extends Eloquent
{
	protected $table = "wards";

	public function visitTypes()
	{
		return $this->belongsToMany('VisitTypes', 'visittype_wards');
	}

	public static function getWardCode($ward_name)
	{
			$id = FacilityWard::where('name',$ward_name)->first()->id;

			return $id;
			
	}
}