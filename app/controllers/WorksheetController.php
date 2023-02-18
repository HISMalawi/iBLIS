<?php

class WorksheetController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$worksheets = DB::select("SELECT * FROM worksheets ORDER BY id DESC");
		return View::make('worksheet.index')
				->with('worksheets',$worksheets);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	public function viewWorksheetTests($worksheetId=0){
		$worksheetId = 17;
		$tests = DB::SELECT("SELECT patients_on_art.arv_number,patients_on_art.art_initiation_date,
						patients_on_art.art_current_regimen,patients.name,patients.gender,
						tests.time_created,test_types.name AS test_type,
						specimen_types.name AS specimen_type,
						test_results.result FROM tests 
						INNER JOIN specimens ON specimens.id = tests.specimen_id 
						INNER JOIN visits ON visits.id = tests.visit_id 
						INNER JOIN patients ON patients.id = visits.patient_id 
						INNER JOIN patients_on_art ON patients_on_art.specimen_id = specimens.id 
						INNER JOIN specimen_types ON specimen_types.id = specimens.specimen_type_id 
						INNER JOIN test_results ON test_results.test_id = tests.id 
						INNER JOIN test_types ON test_types.id = tests.test_type_id 
						WHERE worksheet_id ='$worksheetId'");

		return View::make('worksheet.viewWorksheetTest')
				->with('tests',$tests)
				->with('worksheetNumber',$worksheetId);
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
		//
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
