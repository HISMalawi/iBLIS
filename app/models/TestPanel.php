<?php

class TestPanel extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_panels';

	public function panelType()

	{
		return $this->belongsTo('PanelType', 'panel_type_id', 'id');
	}
}
