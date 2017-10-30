<?php

class TestStatus extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_statuses';

	const test_rejected = 8;

	public $timestamps = false;

	/**
	 * Test relationship
	 */
    public function tests()
    {
        return $this->hasMany('Test');
    }

	/**
	 * TestPhase relationship
	 */
	public function testPhase()
	{
		return $this->belongsTo('TestPhase');
	}
}