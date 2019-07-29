<?php

use Illuminate\Database\QueryException;

/**
 *Contains functions for managing visit types
 *
 */
class SpecimenLifespanController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active specimen_lifespan
		$specimenlifespans = DB::table("testtype_specimentypes")->get();

		foreach( $specimenlifespans AS $key => $value){
			$lifespan = DB::table('specimen_lifespan')
				->whereRaw("specimen_type_id = $value->specimen_type_id AND test_type_id = $value->test_type_id")->first();
			if (!$lifespan){
				$lspan = array(
					'specimen_type_id' =>  $value->specimen_type_id,
					'test_type_id' => $value->test_type_id,
					'lifespan' => 8 //we set the default lifespan to 8 hours
				);
				DB::table('specimen_lifespan')->insert($lspan);
			}
		}

		// Load the view and pass the specimen_lifespan
		return View::make('specimenlifespan.index')->with('specimenlifespan', $specimenlifespans);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$testtypes = TestType::orderBy('name')->get();
		
		//Create testpanel
		return View::make('testpanel.create')
					->with('testtypes', $testtypes);
	}

	public function edit($id)
	{
		//Get the specimenlifespan
		$test_type_id = Input::get('test_type_id');
		$specimenlifespan= SpecimenLifespan::whereRaw("specimen_type_id = $id AND test_type_id = $test_type_id")->first();

		return View::make('specimenlifespan.edit')
					->with('specimenlifespan', $specimenlifespan);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$test_type_id = Input::get('test_type_id');

		$rules = array(
			'lifespan' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// Update
			$lspan = SpecimenLifespan::whereRaw("specimen_type_id = $id AND test_type_id = $test_type_id")->first();
			$lspan->lifespan = trim(Input::get('lifespan'));
			$lspan->save();

			$url = Session::get('SOURCE_URL');
            return Redirect::to($url)
						->with('message', trans('messages.successfully-updated-specimen-lifespan'));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
