<?php

class FacilityWardController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all wards wards
		$wards = FacilityWard::orderBy('name', 'asc')->get();
		//Load the view and pass the wards wards
		return View::make('facilityward.index')->with('wards',$wards);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('facilityward.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('name' => 'required|unique:wards,name');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::route('facilityward.index')->withErrors($validator)->withInput();
		} else {
			// Add
			$ward = new FacilityWard();
			$ward->name = Input::get('name');
			// redirect
			try{
				$ward->save();
				$url = Session::get('SOURCE_URL');
				return Redirect::to($url)
					->with('message', trans('messages.successfully-updated-ward'))
					->with('activeward', $ward ->id);
			} catch(QueryException $e){
				Log::error($e);
			}
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
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the facility
		$ward = FacilityWard::find($id);
		return View::make('facilityward.edit')->with('ward', $ward);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//Validate and check
		$rules = array('name' => 'required|unique:wards,name');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::route('facilityward.index')->withErrors($validator)->withInput();
		} else {
			// Update
			$ward = FacilityWard::find($id);
			$ward->name = Input::get('name');
			$ward->save();
			// redirect
			$url = Session::get('SOURCE_URL');

			return Redirect::to($url)

				->with('message', trans('messages.successfully-updated-ward')) ->with('activeward', $ward ->id);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Deleting the Item
		$ward = FacilityWard::find($id);

		//VisitTypeWard::where('ward_id', '=', $id)->delete();
		$inUseByvisits = VisitTypeWard::where('ward_id', '=', $id)->first();
		if (empty($inUseByvisits)) {
			$ward->delete();
		} else {
			// The ward is in use
			return Redirect::route('facilityward.index')
				->with('message', trans('messages.failure-ward-in-use'));
		}

		$url = Session::get('SOURCE_URL');

		return Redirect::to($url)

			->with('message', trans('messages.successfully-deleted-ward'));
	}


}
