<?php

class FacilityWard extends Eloquent
{
	protected $table = "wards";

	public function visitTypes()
	{
		return $this->belongsToMany('VisitTypes', 'visittype_wards');
	}
}