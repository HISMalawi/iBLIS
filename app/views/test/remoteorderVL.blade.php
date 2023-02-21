@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
			<li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
			<li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
			<li class="active">{{trans('messages.test-details')}}</li>
		</ol>
	</div>
	<?php $showWorkSheet = false;?>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<div class="container-fluid">
				<div class="row less-gutter">
					<div class="col-md-11">
						<span class="glyphicon glyphicon-cog"></span>{{trans('messages.test-details')}}
					
						@if(Auth::user()->can('request_test'))
							<div class="panel-btn pull-right">
								<a class="btn btn-sm btn-success"
								   href="{{URL::route('test.mergeorupdate', array($tracking_number))}}"
								   data-toggle="modal" >
									<span class="glyphicon glyphicon-next"></span>
									Proceed
								</a>
							</div>
						@endif

					</div>
					<div class="col-md-1">
						<a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
						   alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
							<span class="glyphicon glyphicon-backward"></span></a>
					</div>
				</div>
			</div>
		</div> <!-- ./ panel-heading -->
		<div class="panel-body">
			<div class="container-fluid">
				<div class="row">					
					<div class="col-md-offset-2 col-md-8">
						<div class="panel panel-info">  <!-- Patient Details -->
							

							<?php 
								$sending_lab = $test->data->other->sending_lab;		
								$patientFirst = explode(" ",$test->data->other->patient->name)[0];
								$patientSecond = explode(" ",$test->data->other->patient->name)[1];
								$patientId = $test->data->other->patient->id;
								$patientGender = $test->data->other->patient->gender;
								$patientDOB = $test->data->other->patient->dob;
								$patientId = $test->data->other->patient->id;

								$sampleType = $test->data->other->sample_type;
								$sampleStatus = $test->data->other->specimen_status;
								$testReason = $test->data->other->priority;
								$dateCreated = $test->data->other->date_created;
								$dateCreated  = date('Y-m-d', strtotime($dateCreated));

								$regimen = $test->data->other->art_regimen;
								$siteCode = $test->data->other->site_code_number;
								$arv_number = $test->data->other->arv_number;
								$art_start_date = $test->data->other->art_start_date;
								$art_start_date  = date('Y-m-d', strtotime($art_start_date));


								$createdByFirst = explode(" ",$test->data->other->sample_created_by->name)[0];
								$createdBySecond = explode(" ",$test->data->other->sample_created_by->name)[1];

								$requestedBy = $test->data->other->requested_by;

								$fac = DB::SELECT("SELECT * FROM facilities WHERE name ='$sending_lab'");
								if(count($fac)>0){
									$district = $fac[0]->district;
									$siteCode = $fac[0]->facility_code;
								}
							
							?>
							<div class="panel-body">
								<div class="container-fluid">
									<div class="panel panel-info">
										<div class="panel-heading">
											<h1 class="panel-title">{{"Section 1: Health Facility Information "}}</h1>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-md-3">
													<p><strong>{{"District:"}}</strong></p>
													</div>
												<div class="col-md-3">
													<input class="form-control"  type="text" id="district" name="district">
												</div>


												<div class="col-md-3">
													<p><strong>{{"Facility Name:"}}</strong></p>
													</div>
												<div class="col-md-3">
													<input class="form-control"  type="text" id="facility" name="facility">
												</div>
											</div>
										</div>
									</div>
									



									<div class="panel panel-info">
										<div class="panel-heading">
											<h1 class="panel-title">{{"Section 2: Patient Information"}}</h1>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-md-6">
													<p><strong>{{"Patient Surname:"}}</strong></p>
													<input class="form-control"  type="text" id="pSurname" name="patientSurname">
												</div>
												<div class="col-md-6">
													<p><strong>{{"Patient Firstname:"}}</strong></p>
													<input class="form-control"  type="text" id="pFirst" name="patientFirst">
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
														
													<div class="row">
														<div class="col-md-12">
															<p><strong>{{"Patient ID:"}}</strong></p>
															<input class="form-control"  type="text" id="pId" name="patientId">
														</div>
													</div>
													<div class="row">
														<div class="col-md-7">
															<p><strong>{{"Patient/Gurdian Phone Number:"}}</strong></p>
															<input class="form-control"  type="text" id="phoneGurdian" name="phoneGurdian">
														</div>
													</div>


												</div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6">														

															<div class="row">
																<div class="col-md-12">
																	<p><strong>{{"Date of Birth:"}}</strong></p>
																	<input class="form-control" type="date" id="birthday" name="phoneDrawer">
																</div>
															</div>
															<div class="row">
																<div class="col-md-12">
																	<p><strong>{{"Date Sample Drawn:"}}</strong></p>
																	<input class="form-control"  type="date" id="drawnDate" name="drawnDate">
																</div>
															</div>

														</div>
														<div class="col-md-6">
															<p><strong>{{"Gender/Preg/Bf:"}}</strong></p>
																<label class="container">Male
																	<input type="radio" name="radio" id="male" value="male">
																	<span class="check"></span>
																</label>
																<label class="container">Female Non-Preg./Bf.
																	<input type="radio" name="radio" id="female" value="female">
																	<span class="check"></span>
																</label>
																<label class="container">Female Pregnant
																	<input type="radio" name="radio" id="preg" value="female">
																	<span class="check"></span>
																</label>
																<label class="container">Female Breastfeeding
																	<input type="radio" name="radio" id="breast" value= "female">
																	<span class="check"></span>
																</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>





									<div class="panel panel-info">
										<div class="panel-heading">
											<h1 class="panel-title">{{"Section 3: Test Type"}}</h1>
										</div>
										<div class="panel-body">
											<div class="row">
													<div class="col-md-6">
														<p><strong>{{"Reason For Testing:"}}</strong></p>
														<select class="form-control" type="date" id="reason" name="reason">
															<option id="routine"> 
																	Routine
															</option>
															<option id="targeted">  
																	Targeted
															</option>
															<option id="follow"> 
																	Follow-up after high VL
															</option>
															<option id="repeat"> 
																	Repeat (rejected/lost/missing)
															</option>
														</select>
													</div>												
											</div>
										</div>
									</div>


									<div class="panel panel-info">
										<div class="panel-heading">
											<h1 class="panel-title">{{"Section 5: Patient and Samples Details"}}</h1>
										</div>
										<div class="panel-body">
											<div class="row">
													<div class="col-md-6">
														<p><strong>{{"ART Initiation Date:"}}</strong></p>
														<input class="form-control"  id="artStart" type="date"  name="artStart">
													</div>		
													<div class="col-md-6">
														<p><strong>{{"Sample Type:"}}</strong></p>
														<select class="form-control" type="date" id="sampleType" name="sampleType">
															<option id="70ml"> 
																	DBS 70ml
															</option>
															<option id="plasma"> 
																	Plasma
															</option>
															<option id="dbs"> 
																	DBS
															</option>
															<option id="blood"> 
																	Blood
															</option>
														</select>
													</div>								
											</div>
											<div class="row">															
													<div class="col-md-6">
														<p><strong>{{"Current ART Regimen:"}}</strong></p>
														<select class="form-control" type="date" id="regimen" name="regimen">
															<option id="13A"> 
																	13A
															</option>
															<option id="15A"> 
																	15A
															</option>
															<option id="12A"> 
																	12A
															</option>
														</select>
													</div>								
											</div>
										</div>
									</div>


									<div class="panel panel-info">
										<div class="panel-heading">
											<h1 class="panel-title">{{"Section 6: Details of Person Colllecting Sample"}}</h1>
										</div>
										<div class="panel-body">
											<div class="row">
													<div class="col-md-6">
														<p><strong>{{"Sirname:"}}</strong></p>
														<input class="form-control"  type="text" id="drawerSirname" name="drawerSirname">
													</div>		
													<div class="col-md-6">
														<p><strong>{{"First Name:"}}</strong></p>
														<input class="form-control"  type="text" id="drawerFirstname" name="drawerFirstname">
													</div>								
											</div>
											<div class="row">															
													<div class="col-md-6">
														<p><strong>{{"Phone Number:"}}</strong></p>
														<input class="form-control"  type="text" id="phoneDrawer" name="phoneDrawer">
													</div>	
													<div class="col-md-4">
														<p><strong>{{"HTC Provider ID:"}}</strong></p>
														<input class="form-control"  type="text" id="provider" name="provider">
													</div>								
											</div>
										</div>
									</div>




						

					</div>
				</div>
			</div> <!-- ./ container-fluid -->

		</div> <!-- ./ panel-body -->
	</div> <!-- ./ panel -->

	<div class="panel-info">  <!-- Test Results -->
		
		<div class="panel-body" >
			<div class="container-fluid">
				<div class="row">					
					<div class="col-md-offset-4 col-md-6">
							<div class="panel-btn pull-right ">
								<a class="btn btn-sm btn-danger"
								   href="{{URL::route('test.mergeorupdate', array($tracking_number))}}"
								   data-toggle="modal" >
									<span class="glyphicon glyphicon-next"></span>
									Cancel
								</a>
							</div>
							<div class="panel-btn pull-right">
								<a class="btn btn-sm btn-danger"
								   href="{{URL::route('test.mergeorupdate', array($tracking_number.'-'.'rejected'))}}"
								   data-toggle="modal" >
									<span class="glyphicon glyphicon-next"></span>
									Reject Test
								</a>
							</div>
							<div class="panel-btn pull-right">
								<a class="btn btn-sm btn-success"
								   href="{{URL::route('test.mergeorupdate', array($tracking_number.'-'.'accept'))}}"
								   data-toggle="modal" >
									<span class="glyphicon glyphicon-next"></span>
									Accept Test
								</a>
							</div>		

					
											
					</div>
				</div>									
			</div>
		</div> <!-- ./ panel-body -->
	</div>  <!-- ./ panel -->
	
	
	
	<script>
		var sendingLab = "{{$sending_lab}}";
		var district = "{{$district}}";

		var pFirst = "{{$patientFirst}}";
		var pSecond = "{{$patientSecond}}";
		var pID = "{{$patientId}}";
		var pGender = "{{$patientGender}}";
		var pDOB = "{{$patientDOB}}";

		var siteCode = "{{$siteCode}}";
		var hybridId = siteCode +" - "+pID;
		document.getElementById('pSurname').value = pSecond;
		document.getElementById('pId').value = hybridId;
		document.getElementById('pFirst').value = pFirst;
		document.getElementById('birthday').value = pDOB;
		
		if(pGender = "male"){
			document.getElementById('male').checked = true;
		}else{
			document.getElementById('female').checked = true;
		}

		var sampleType = "{{$sampleType}}";
		var sampleStatus = "{{$sampleStatus}}";
		var testReason = "{{$testReason}}";
		var dateCreated = "{{$dateCreated}}";

		document.getElementById('drawnDate').value = dateCreated;
		console.log(testReason);
		if(testReason == "routine"){
			document.getElementById('routine').selected = true;
		}
		if(testReason == "targeted"){
			document.getElementById('targeted').selected = true;
		}		
		if(testReason == "follow"){
			document.getElementById('follow').selected = true;
		}		
		if(testReason == "repeat"){
			document.getElementById('repeat').selected = true;
		}

		var regimen = "{{$regimen}}";
		var arv_number = "{{$arv_number}}";
		var art_start_date = "{{$art_start_date}}";
		var sampleType = "{{$sampleType}}";

		document.getElementById('artStart').value = art_start_date;

		if(sampleType == "70ml"){
			document.getElementById('70ml').selected = true;
		}else if(sampleType == "plasma"){
			document.getElementById('plasma').selected = true;
		}else if(sampleType == "DBS"){
			document.getElementById('dbs').selected = true;
		}else if(sampleType == "Blood"){
			document.getElementById('blood').selected = true;
		}
		
		var createdByFirst = "{{$createdByFirst}}";
		var createdBySecond = "{{$createdBySecond}}";
		var requestedBy = "{{$requestedBy}}";
		
		document.getElementById('drawerSirname').value = createdByFirst;
		document.getElementById('drawerFirstname').value = createdBySecond;

		document.getElementById('facility').value = sendingLab;
		document.getElementById('district').value = district;

	</script>
						

@stop

