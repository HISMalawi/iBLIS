<?php

use Illuminate\Database\QueryException;

/**
 *Contains functions for managing visit types
 *
 */
class VisitTypeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active visittypes
			$visittypes = VisitType::orderBy('name', 'ASC')->get();

		// Load the view and pass the visittypes
		return View::make('visittype.index')->with('visittypes', $visittypes);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$wards = FacilityWard::orderBy('name')->get();
		
		//Create visitType
		return View::make('visittype.create')
					->with('wards', $wards);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$action = Input::get('action');

		if ($action == "results") {

			$visit_type = Input::get('visittype');

			$wards = FacilityWard::where('id', 'IN',
				VisitTypeWard::where('visit_type_id', '=', $visit_type).lists('id')
			);

			return json_encode($wards);
		}

		$rules = array(
			'name' => 'required|unique:visit_types,name'
		);
		$validator = Validator::make(Input::all(), $rules);
			//array to be split here and sent to appropriate place! man! with ids and all possibilities

		// process the login
		if ($validator->fails()) {
			return Redirect::route('visittype.create')->withErrors($validator);
		} else {
			// store 
			$visittype = new VisitType;
			$visittype->name = trim(Input::get('name'));			;
			try {
				$visittype->save();
				$wards = Input::get('wards');

				VisitTypeWard::where('visit_type_id', '=', $visittype->id)->delete();

				foreach ($wards AS $id => $v) {
					$v_type_ward = array(
						'visit_type_id' => $visittype->id,
						'ward_id' => $v
					);
					DB::table('visittype_wards')->insert($v_type_ward);
				}
			}catch(QueryException $e){
				Log::error($e);
			}

			return Redirect::route('visittype.index')
				->with('message', trans('messages.success-creating-visit-type'));
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
		//Show a visittype
		$visittype = VisitType::find($id);

		//Show the view and pass the $visittype to it
		return View::make('visittype.show')->with('visittype', $visittype);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the visittype
		$visittype = VisitType::find($id);
		$wards = FacilityWard::orderBy('name')->get();
		$visittype_wards = VisitTypeWard::where("visit_type_id", '=', $id)->get();

		//Open the Edit View and pass to it the $visittype
		return View::make('visittype.edit')
					->with('visittype', $visittype)
					->with('visittype_wards', $visittype_wards)
					->with('wards', $wards);
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
			$visittype = VisitType::find($id);
			$visittype->name = trim(Input::get('name'));

			try{
				$visittype->save();
				$wards = Input::get('wards');

				VisitTypeWard::where('visit_type_id', '=', $visittype->id)->delete();

				foreach ($wards AS $id => $v) {
					$v_type_ward = array(
						'visit_type_id' => $visittype->id,
						'ward_id' => $v
					);
					DB::table('visittype_wards')->insert($v_type_ward);
				}
			}catch(QueryException $e){
				Log::error($e);
			}

			// redirect
			$url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
						->with('message', trans('messages.successfully-updated-visit-type'))->with('activevisittype', $visittype ->id);
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
		//Soft delete the visittype
		$visittype = VisitType::find($id);
        $inUseByvisits = Visit::where('visit_type', '=', $visittype->name)->first();
		if (empty($inUseByvisits)) {
		    // The visit type is not in use
			VisitTypeWard::where('visit_type_id', '=', $visittype->id)->delete();
			$visittype->delete();
		} else {
		    // The visit type is in use
		    return Redirect::route('visittype.index')
		    	->with('message', 'messages.failure-visit-type-in-use');
		}
		// redirect
		return Redirect::route('visittype.index')
			->with('message', trans('messages.successfully-deleted-visit-type'));
	}
}
