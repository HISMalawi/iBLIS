<?php

use Illuminate\Database\QueryException;

/**
 *Contains functions for managing patient records 
 *
 */
class PatientController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
		{
		$search = Input::get('search');
		
		$patients = Patient::search($search)->orderBy('id', 'desc')->paginate(Config::get('kblis.page-items'))->appends(Input::except('_token'));
		
		if (count($patients) == 0) {
		 	Session::flash('message', trans('messages.no-match'));
		}
		
		// Load the view and pass the patients
		return View::make('patient.index')->with('patients', $patients)->withInput(Input::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create Patient
		$lastInsertId = DB::table('patients')->max('id')+1;
		return View::make('patient.create')->with('lastInsertId', $lastInsertId);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$rules = array(
			'first_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'dob' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			return Redirect::back()->withErrors($validator)->withInput(Input::all());
		} else {
			// store
			$patient = new Patient;
			$patient->external_patient_number = Input::get('external_patient_number');

			$first_name = Input::get('first_name');
			$last_name = Input::get('last_name');
			$patient->name = $first_name." ".$last_name;
			$patient->first_name_code = isset($first_name) ? Soundex::encode($first_name)  : null;
			$patient->last_name_code = isset($last_name) ? Soundex::encode($last_name)  : null;

			$patient->gender = Input::get('gender');
			$patient->dob = Input::get('dob');
			$patient->email = Input::get('email');
			$patient->address = Input::get('address');
			$patient->phone_number = Input::get('phone_number');
			$patient->created_by = Auth::user()->id;
			$patient->patient_number = DB::table('patients')->max('id')+1;			;

			try{
				$patient->save();
			$url = Session::get('SOURCE_URL');
			return Redirect::to($url)
			->with('message', 'Successfully created patient!');
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
		//Show a patient
		$patient = Patient::find($id);

		//Show the view and pass the $patient to it
		return View::make('patient.show')->with('patient', $patient);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the patient
		$patient = Patient::find($id);

		//Open the Edit View and pass to it the $patient
		return View::make('patient.edit')->with('patient', $patient);
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
		$rules = array(
			'patient_number' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'dob' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('patient/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// Update
			$patient = Patient::find($id);
			$patient->patient_number = Input::get('patient_number');
			$patient->external_patient_number = Input::get('external_patient_number');

			$first_name = Input::get('first_name');
			$last_name = Input::get('last_name');
			$patient->name = $first_name." ".$last_name;
			$patient->first_name_code = isset($first_name) ? Soundex::encode($first_name)  : null;
			$patient->last_name_code = isset($last_name) ? Soundex::encode($last_name)  : null;

			$patient->gender = Input::get('gender');
			$patient->dob = Input::get('dob');
			$patient->email = Input::get('email');
			$patient->address = Input::get('address');
			$patient->phone_number = Input::get('phone_number');
			$patient->created_by = Auth::user()->id;
			$patient->save();

			// redirect
			$url = Session::get('SOURCE_URL');
			return Redirect::to($url)
			->with('message', 'The patient details were successfully updated!') ->with('activepatient',$patient ->id);

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
		//Soft delete the patient
		$patient = Patient::find($id);

		$patient->delete();

		// redirect
			$url = Session::get('SOURCE_URL');
			return Redirect::to($url)
			->with('message', 'The commodity was successfully deleted!');
	}

	/**
	 * Return a Patients collection that meets the searched criteria as JSON.
	 *
	 * @return Response
	 */
	public function search()
	{
        return Patient::search(Input::get('text'))->take(Config::get('kblis.limit-items'))->get()->toJson();
	}

}
