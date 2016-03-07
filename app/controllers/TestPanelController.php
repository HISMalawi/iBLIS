<?php

use Illuminate\Database\QueryException;

/**
 *Contains functions for managing visit types
 *
 */
class TestPanelController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active paneltypes
			$paneltypes = PanelType::orderBy('name', 'ASC')->get();

		// Load the view and pass the paneltypes
		return View::make('testpanel.index')->with('testpanels', $paneltypes);
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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	public function store()
	{
		$rules = array(
			'name' => 'required|unique:panel_types,name'
		);
		$validator = Validator::make(Input::all(), $rules);
			//array to be split here and sent to appropriate place! man! with ids and all possibilities

		// process the login
		if ($validator->fails()) {
			return Redirect::route('testpanel.create')->withErrors($validator);
		} else {
			// store 
			$paneltype = new PanelType;
			$paneltype->name = trim(Input::get('name'));
			$paneltype->short_name = trim(Input::get('short_name'));
			$paneltype->save();
			try {
				$paneltype->save();
				$testtypes = Input::get('testtypes');

				Panel::where('panel_type_id', '=', $paneltype->id)->delete();

				foreach ($testtypes AS $id => $v) {
					$panel = array(
						'panel_type_id' => $paneltype->id,
						'test_type_id' => $v
					);
					DB::table('panels')->insert($panel);
				}
			}catch(QueryException $e){
				Log::error($e);
			}

			return Redirect::route('testpanel.index')
				->with('message', trans('messages.success-creating-test-panel'));
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

		$testpanel = PanelType::find($id);

		$testtypes = DB::table('panels')
			->join('test_types', 'test_types.id', '=', 'panels.test_type_id')
			->select('test_types.*')
			->where('panels.panel_type_id', '=', $id);

		return View::make('testpanel.show')->with('testpanel', $testpanel)
			->with("testtypes", $testtypes);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the vtestpanel
		$testpanel = PanelType::find($id);
		$testtypes = TestType::orderBy('name')->get();
		$panels = Panel::where("panel_type_id", '=', $id)->get();

		//Open the Edit View and pass to it the $testpanel
		return View::make('testpanel.edit')
					->with('testpanel', $testpanel)
					->with('panels', $panels)
					->with('testtypes', $testtypes);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'name' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// Update
			$testpanel = PanelType::find($id);
			$testpanel->name = trim(Input::get('name'));
			$testpanel->short_name = trim(Input::get('short_name'));

			try{
				$testpanel->save();
				$testtypes = Input::get('testtypes');

				Panel::where('panel_type_id', '=', $testpanel->id)->delete();

				if (count($testtypes) > 0) {
					foreach ($testtypes AS $id => $v) {
						$panel = array(
							'panel_type_id' => $testpanel->id,
							'test_type_id' => $v
						);
						DB::table('panels')->insert($panel);
					}
				}
			}catch(QueryException $e){
				Log::error($e);
			}

			// redirect
			$url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
						->with('message', trans('messages.successfully-updated-test-panel'))->with('activetestpanel', $testpanel ->id);
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
		//Soft delete the testpanel
		$testpanel = PanelType::find($id);
        $inUseByvisits = TestPanel::where('panel_type_id', '=', $id)->first();
		if (empty($inUseByvisits)) {
		    // The visit type is not in use
			Panel::where('panel_type_id', '=', $testpanel->id)->delete();
			$testpanel->delete();
		} else {
		    // The visit type is in use
		    return Redirect::route('testpanel.index')
		    	->with('message', 'messages.failure-test-panel-in-use');
		}
		// redirect
		return Redirect::route('testpanel.index')
			->with('message', trans('messages.successfully-deleted-test-panel'));
	}
}
