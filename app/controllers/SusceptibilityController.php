<?php

class SusceptibilityController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$action = Input::get('action');
		$user_id = Auth::user()->id;
		$test = Input::get('test');
		$organism = Input::get('organism');
		$drug = Input::get('drug');
		$zone = Input::get('zone');
		$interpretation = Input::get('interpretation');

		if($action == "row-values"){
			$drugs = Drug::orderBy('name')->lists('name', 'id');
			return json_encode(array('oid' => Input::get('organismId'), 'drugs' => $drugs));
		}

		if ($action == "delete") {
			Susceptibility::where("test_id",  Input::get('testId'))
				->where("organism_id", Input::get('organismId'))
				->delete();
			return json_encode($test);

		}

		for($i=0; $i<count($test); $i++){
			$sensitivity = Susceptibility::getDrugSusceptibility($test[$i], $organism[$i], $drug[$i]);
			if(count($sensitivity)>0){
				$drugSusceptibility = Susceptibility::find($sensitivity->id);
				$drugSusceptibility->user_id = $user_id;
				$drugSusceptibility->test_id = $test[$i];
				$drugSusceptibility->organism_id = $organism[$i];
				$drugSusceptibility->drug_id = $drug[$i];
				$drugSusceptibility->zone = $zone[$i];
				$drugSusceptibility->interpretation = $interpretation[$i];
				$drugSusceptibility->save();
			}else{
				$drugSusceptibility = new Susceptibility;
				$drugSusceptibility->user_id = $user_id;
				$drugSusceptibility->test_id = $test[$i];
				$drugSusceptibility->organism_id = $organism[$i];
				$drugSusceptibility->drug_id = $drug[$i];
				$drugSusceptibility->zone = $zone[$i];
				$drugSusceptibility->interpretation = $interpretation[$i];
				$drugSusceptibility->save();
			}

		}

		//Save newly mapped drug names

		$new_drugs = Input::get('new_drug');
		$new_zones = Input::get('new_zone');
		$new_interp = Input::get('new_interp');

		for ($i=0; $i<count($new_drugs); $i++){
				if(!empty($new_interp[$i]) && !empty($new_drugs[$i])) {
					$sensitivity = Susceptibility::getDrugSusceptibility($test[0], $organism[0], $drug);
					if (count($sensitivity) > 0) {
						$drugSusceptibility = Susceptibility::find($sensitivity->id);
					} else {

						$organismObj = Organism::find($organism[0]);
						$organismObj->setDrugs(array('0' => $new_drugs[$i]), false);
						$drugSusceptibility = new Susceptibility;
					}
					$drugSusceptibility->user_id = $user_id;
					$drugSusceptibility->test_id = $test[0];
					$drugSusceptibility->organism_id = $organism[0];
					$drugSusceptibility->drug_id = $new_drugs[$i];
					$drugSusceptibility->zone = $new_zones[$i];
					$drugSusceptibility->interpretation = $new_interp[$i];
					$drugSusceptibility->save();
				}
		}

		if ($action == "results"){
			$test_id = Input::get('testId');
			$organism_id = Input::get('organismId');
			$susceptibility = Susceptibility::where('test_id', $test_id)
											->where('organism_id', $organism_id)
											->where('zone', '!=', 0)
											->get();
			foreach ($susceptibility as $drugSusceptibility) {
				$drugSusceptibility->drugName = Drug::find($drugSusceptibility->drug_id)->name;
				$drugSusceptibility->pathogen = Organism::find($drugSusceptibility->organism_id)->name;
				if($drugSusceptibility->interpretation == 'I'){
					$drugSusceptibility->sensitivity = 'Intermediate';
				}
				else if($drugSusceptibility->interpretation == 'R'){
					$drugSusceptibility->sensitivity = 'Resistant';
				}
				else if($drugSusceptibility->interpretation == 'S'){
					$drugSusceptibility->sensitivity = 'Sestitive';
				}
			}

			return json_encode($susceptibility);
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
