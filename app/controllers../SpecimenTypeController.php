<?php

use Illuminate\Database\QueryException;

/**
 * Contains functions for managing specimen types  
 *
 */
class SpecimenTypeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active specimentypes
			$specimentypes = SpecimenType::orderBy('name', 'ASC')->get();

		// Load the view and pass the specimentypes
		return View::make('specimentype.index')->with('specimentypes', $specimentypes);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create SpecimenType
		return View::make('specimentype.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$rules = array('name' => 'required|unique:specimen_types,name');
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// store
			$specimentype = new SpecimenType;
			$specimentype->name = Input::get('name');
			$specimentype->description = Input::get('description');

			try{
				$specimentype->save();
			$url = Session::get('SOURCE_URL');
			return Redirect::to($url)
                    ->with('message', trans('messages.success-creating-specimen-type'));
			}catch(QueryException $e){
                Log::error($e);
			}
			
			// redirect
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Show a specimentype
		$specimentype = SpecimenType::find($id);

		//Show the view and pass the $specimentype to it
		return View::make('specimentype.show')->with('specimentype', $specimentype);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the specimentype
		$specimentype = SpecimenType::find($id);

		//Open the Edit View and pass to it the $specimentype
		return View::make('specimentype.edit')->with('specimentype', $specimentype);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$rules = array('name' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// Update
			$specimentype = SpecimenType::find($id);
			$specimentype->name = Input::get('name');
			$specimentype->description = Input::get('description');
			$specimentype->hl7_identifier = Input::get('hl7_identifier');
			$specimentype->hl7_text = Input::get('hl7_text');
			$specimentype->hl7_coding_system = Input::get('hl7_coding_system');
			$specimentype->save();

			// redirect
			$url = Session::get('SOURCE_URL');
			
			return Redirect::to($url)
			->with('message', trans('messages.success-updating-specimen-type'))->with('activespecimentype', $specimentype ->id);
		
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

	/**
	 * Remove the specified resource from storage (soft delete).
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the specimentype
		$specimentype = SpecimenType::find($id);
		$inUseByTesttype = $specimentype->testTypes->toArray();
		$inUseBySpecimen = $specimentype->specimen->toArray();
		if (empty($inUseByTesttype) && empty($inUseBySpecimen)) {
		    // The specimen type is not in use
			$specimentype->delete();
		} else {
		    // The specimen type is in use
		    return Redirect::route('specimentype.index')
		    	->with('message', trans('messages.failure-specimen-type-in-use'));
		}
		// redirect
		  $url = Session::get('SOURCE_URL');
			
			return Redirect::to($url)
			->with('message', trans('messages.success-updating-specimen-type'));
	}

	public static function getTestTypes(){

		$specimen_type = Input::get('specimentype');
		$specimenType = SpecimenType::find($specimen_type);
		$testTypes = [];
		$testPanels = [];
		if($specimenType) {
			$location = TestCategory::where("id", '=', Session::get('location_id'))->first();

			if (str_is('*RECEPTION*', strtoupper($location))) {
				$testTypes = $specimenType->testTypes->lists('name', 'id');
			}else {
				$testTypes = DB::table('testtype_specimentypes')
					->join('test_types', 'test_types.id', '=', 'testtype_specimentypes.test_type_id')
					->select('test_types.*')
					->where('testtype_specimentypes.specimen_type_id', '=', $specimen_type)
					->whereNull('test_types.deleted_at')
					->where('test_types.test_category_id', '=', Session::get('location_id'))->lists('name', 'id');
			}

			//check for test panels
			if (str_is('*RECEPTION*', strtoupper($location))) {
				$testPanels = DB::table('panel_types')
					->join('panels', 'panel_types.id', '=', 'panels.panel_type_id')
					->join('test_types', 'test_types.id', '=', 'panels.test_type_id')
					->join('testtype_specimentypes', 'test_types.id', '=', 'testtype_specimentypes.test_type_id')
					->select('panel_types.*')
					->where('testtype_specimentypes.specimen_type_id', '=', $specimen_type)->lists('name', 'name');

			}else {
				$testPanels = DB::table('panel_types')
					->join('panels', 'panel_types.id', '=', 'panels.panel_type_id')
					->join('test_types', 'test_types.id', '=', 'panels.test_type_id')
					->join('testtype_specimentypes', 'test_types.id', '=', 'testtype_specimentypes.test_type_id')
					->select('panel_types.*')
					->where('testtype_specimentypes.specimen_type_id', '=', $specimen_type)
					->where('test_types.test_category_id', '=', Session::get('location_id'))->lists('name', 'name');
			}
		}

		$panelTests = DB::table('panels')
						->join('panel_types', 'panel_types.id', '=', 'panels.panel_type_id')
						->join('test_types', 'test_types.id', '=', 'panels.test_type_id')
						->select('test_types.*')
						->whereIn('panel_types.name', array_keys($testPanels))->lists('name', 'id');

		$testTypes = array_diff($testTypes, $panelTests);

		if($specimenType->name == "CSF"){
			$testPanels = array_diff($testPanels, array("Sterile Fluid Analysis"));
		}else{
			$testPanels = array_diff($testPanels, array("CSF Analysis"));
		}

		return json_encode(($testTypes + $testPanels));
	}
}
