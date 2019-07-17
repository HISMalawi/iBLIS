<?php

class TestNotDoneController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$notdoneObject = new NotDoneReason;
		$reasons = $notdoneObject->getNotDoneReasons();

        // Load the view and pass the reasons
        return View::make('testnotdone.index')->with('reasons', $reasons);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('testnotdone.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array('reason'=> 'required');

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::route("testnotdone.create")
                ->withErrors($validator);
        } else {
            // store
            $notDone = new NotDoneReason;
            $notDone->reason = Input::get('reason');
            $notDone->save();
        }
            $url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
            
            ->with('message', trans('messages.sucess-not-done-added'));
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
		return View::make('testnotdone.edit')->with('id',$id);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{  
		$rules = array('reason' => 'required');

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            // Update
            $edit = new NotDoneReason;
            $edit->updateReason($id,Input::get('reason'));

            // redirect
            $url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
                    ->with('message', trans('messages.sucess-not-done-edit')) ->with('activerejection', 
                    	$edit->id);
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

	public function delete($id)
    {
        //Soft delete the rejection
        $delete = new NotDoneReason;
       
       	if (($delete->checkReasonInUse($id))==true)
       	{
       		$url = Session::get('SOURCE_URL');            
            return Redirect::to($url)
                ->with('message', trans('messages.can-not-delete-reason'));
       	}
       	else
       	{
       		$delete->deleteReason($id);
       	}
      
        $url = Session::get('SOURCE_URL');
            
        return Redirect::to($url)
            ->with('message', trans('messages.sucess-deleted-reason'));

    }

}
