@extends("layout")
@section("content")

	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datepicker.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/select2/css/select2.css') }}" />

	<div>
		<ol class="breadcrumb">
			<li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
			<li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
			<li class="active">{{trans('messages.test-details')}}</li>
		</ol>
	</div>
	<?php $showWorkSheet = false;?>
	<form id="remoteOrderForm" method="GET" action="{{URL::route('test.mergeorupdate', array(trim($tracking_number).'-'.'accept'))}}">
		<div class="panel panel-primary">
			<div class="panel-heading ">
				<div class="container-fluid">
					<div class="row less-gutter">
						<div class="col-md-11">
							<span class="glyphicon glyphicon-folder-open" style="margin-right: 10px;"></span>{{trans('messages.test-details')}}
						
							{{-- @if(Auth::user()->can('request_test'))
								<div class="panel-btn pull-right">
									<a class="btn btn-sm btn-success"
									href="{{URL::route('test.mergeorupdate', array($tracking_number))}}"
									data-toggle="modal" >
										<span class="glyphicon glyphicon-next"></span>
										Proceed
									</a>
								</div>
							@endif --}}

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
						<div class="">
							<div class="">  <!-- Patient Details -->
								

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

									$facilityObject = Facility::where('name', $sending_lab)->get();

									$district = "";
									$facility = "";
									
									if(count($facilityObject) > 0){

										$district = $facilityObject[0]->district;
										$siteCode = $facilityObject[0]->facility_code;
										$facility = $facilityObject[0]->name;

									}else{

										$district = "";
										$facility = "";
									}
								
								?>
								<div class="panel-body">
									<div class="container-fluid">
										<div class="panel panel-default">
											<div class="panel-heading">
												<h1 class="panel-title"><strong>Section 1:</strong> Health Facility Information </h1>
											</div>
											<div class="panel-body">
												<div class="row">

													<div class="col-md-6">
														<div class="form-group">
															<label><strong>{{"District:"}}</strong></label>
															<select  class="form-control required district-select" style="float: none;" name="district" id="district">
															<option value="">-- Select district ---</option>
																@foreach ($districts as $fac_district)
																	<option value={{$fac_district->name}}>{{ $fac_district->name }}</option>
																@endforeach
															</select>
														</div>
													</div>


													<div class="col-md-6">
														<div class="form-group">
															<label><strong>{{"Facility Name:"}}</strong></label>
															<select  class="form-control required facility-select" style="float: none;" name="facility" id="facility">
																<option value="">-- Select facility ---</option>
																@foreach ($facilities as $facility_)
																<option value="{{$facility_->name}}">{{ $facility_->name }}</option>
																@endforeach
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										



										<div class="panel panel-default">
											<div class="panel-heading">
												<h1 class="panel-title"><strong>Section 2:</strong> Patient Information</h1>
											</div>
											<div class="panel-body">
												<div class="row">
													<div class="col-md-6">
														<p><strong>{{"Patient Surname:"}}</strong></p>
														<input class="form-control" required  type="text" id="pSurname" name="patientSurname">
													</div>
													<div class="col-md-6">
														<p><strong>{{"Patient Firstname:"}}</strong></p>
														<input class="form-control" required  type="text" id="pFirst" name="patientFirst">
													</div>
												</div>
												<div class="row" style="margin-top: 10px !important;">
													<div class="col-md-6">
															
														<div class="row">
															<div class="col-md-12">
																<p><strong>{{"Patient ID:"}}</strong></p>
																<input class="form-control" required  type="text" id="pId" name="patientId">
															</div>
														</div>
														<div class="row" style="margin-top: 10px !important;">
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
																		<input class="form-control" required type="text" id="birthday" name="dob">
																	</div>
																</div>
																<div class="row" style="margin-top: 10px !important;">
																	<div class="col-md-12">
																		<p><strong>{{"Date Sample Drawn:"}}</strong></p>
																		<input class="form-control" required  type="text" id="drawnDate" name="drawnDate">
																	</div>
																</div>

															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<div style="font-size: 14px;"><strong>{{"Gender/Preg/Bf:"}}</strong></div>
																	<div class="radio">
																	<label><input type="radio" required name="radio" id="male" value="male">Male</label>
																	</div>
																	<div class="radio">
																	<label><input type="radio" required name="radio" id="female" value="female">Female Non-Preg./Bf.</label>
																	</div>
																	<div class="radio">
																	<label><input type="radio" required name="radio" id="preg" value="female">Female Pregnant</label>
																	</div>
																	<div class="radio">
																		<label><input type="radio" required name="radio" id="breast" value="female">Female Breastfeeding</label>
																	</div>
																</div>
																
																{{-- <p><strong>{{"Gender/Preg/Bf:"}}</strong></p>
																	<label class="container">Male
																		<input type="radio" name="radio" id="male" value="male">
																		<span class="check"></span>
																	</label>
																	<label class="container ml-3">Female Non-Preg./Bf.
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
																	</label> --}}
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>





										<div class="panel panel-default">
											<div class="panel-heading">
												<h1 class="panel-title"><strong>Section 3:</strong>{{" Test Type"}}</h1>
											</div>
											<div class="panel-body">
												<div class="row">
														<div class="col-md-6 form-group">
															<label><strong>{{"Reason For Testing:"}}</strong></label>
															<select required class="form-control" type="text" id="reason" name="reason">
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


										<div class="panel panel-default">
											<div class="panel-heading">
												<h1 class="panel-title"><strong>Section 4:</strong>{{" Patient and Samples Details"}}</h1>
											</div>
											<div class="panel-body">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label><strong>{{"ART Initiation Date:"}}</strong></label>
															<input required class="form-control"  id="artStart" type="text"  name="artStart">
														</div>
													</div>		
													<div class="col-md-4">
														<div class="form-group">
															<label><strong>{{"Sample Type:"}}</strong></label>
															<select required class="form-control" type="text" id="sampleType" name="sampleType">
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
													<div class="col-md-4">
														<div class="form-group">
															<label><strong>{{"Current ART Regimen:"}}</strong></label>
															<select required class="form-control" type="text" id="regimen" name="regimen">
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
										</div>


										<div class="panel panel-default">
											<div class="panel-heading">
												<h1 class="panel-title"><strong>Section 5:</strong>{{" Details of Person Colllecting Sample"}}</h1>
											</div>
											<div class="panel-body">
												<div class="row">
														<div class="col-md-3">
															<div class="form-group">
															<label><strong>{{"Sirname:"}}</strong></label>
															<input required class="form-control"  type="text" id="drawerSirname" name="drawerSirname">
															</div>
														</div>		
														
														<div class="col-md-3">
															<div class="form-group">
															<label><strong>{{"First Name:"}}</strong></label>
															<input required class="form-control"  type="text" id="drawerFirstname" name="drawerFirstname">
															</div>
														</div>	
														
														<div class="col-md-3">
															<div class="form-group">
															<label><strong>{{"Phone Number:"}}</strong></label>
															<input class="form-control"  type="text" id="phoneDrawer" name="phoneDrawer">
															</div>
														</div>	
														
														<div class="col-md-3">
															<div class="form-group">
															<label><strong>{{"HTC Provider ID:"}}</strong></label>
															<input required class="form-control"  type="text" id="provider" name="provider">
															</div>
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
						<div class="col-md-offset-8 col-md-4">
							<div class="pull-right">
								<a class="btn btn-warning"
									href="{{URL::route('test.mergeorupdate', array(trim($tracking_number)))}}"
									data-toggle="modal" >
									<span class="glyphicon glyphicon-next"></span>
									Cancel
								</a>
								<a class="btn btn-danger"
									href="{{URL::route('test.mergeorupdate', array(trim($tracking_number).'-'.'rejected'))}}"
									data-toggle="modal" >
									<span><i class="glyphicon glyphicon-remove-sign"></i></span>
									Reject Test
								</a>
								{{-- <a class="btn btn-sm btn-success"
									href="{{URL::route('test.mergeorupdate', array(trim($tracking_number).'-'.'accept'))}}"
									data-toggle="modal" >
									<span class="glyphicon glyphicon-next"></span>
									Accept Test
								</a> --}}

								<button type="submit" class="btn btn-primary">
									<span><i class="glyphicon glyphicon-check"></i></span>
									Accept Test
								</button>
							</div>
												
						</div>
					</div>									
				</div>
			</div>
		</div>
	</form>

	<script src="{{ URL::asset('plugins/validate/validate.min.js') }}"></script>
	<script src="{{ URL::asset('plugins/select2/js/select2.js') }}"></script>
	<script src="{{ URL::asset('js/bootstrap-datepicker.js') }} "></script>
	
	<script>
		$(document).ready(function () {

			$('#birthday').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true,
                todayHighlight: true
            })

			$('#drawnDate').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true,
                todayHighlight: true
            })

			$('#artStart').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true,
                todayHighlight: true
            })

			$('#remoteOrderForm').validate({
				errorClass: "error-class text-danger",
				errorElement: "div",
				rules: {
					district: {
						required: true
					}
				}
			})

			$('.district-select').select2({
                theme: 'bootstrap4',
            });

            $($('.district-select').data('select2').$container).addClass('form-control');

			
            $('.facility-select').select2({
                theme: 'bootstrap4',
            });

            $($('.facility-select').data('select2').$container).addClass('form-control');

			var sendingLab = "{{$sending_lab}}";
			
			var district = "{{$district}}";


			$('#district').val(`${district}`).trigger('change');
			$('#facility').val(`${sendingLab}`).trigger('change');


            $('.district-select').on('change', function() {
                				
                $.ajax({
                    url: `/filter-facilities/${$('.district-select').val()}`,
                    async: true,
                    type: 'GET',
                    success: function (response) {
                        var select2 = $('.facility-select');
                        select2.empty();
                        select2.append('<option value="">--- Select a facility ---</option>');
                        $.each(response.data, function (index, value) {
                            select2.append('<option value="' + value.name + '">' + value.name + '</option>');
                        });
                    }
                });

            });

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
			
			if(pGender == "M"){
				document.getElementById('male').checked = true;
			}else if(pGender == "F"){
				document.getElementById('female').checked = true;
			}

			var sampleType = "{{$sampleType}}";
			var sampleStatus = "{{$sampleStatus}}";
			var testReason = "{{$testReason}}";
			var dateCreated = "{{$dateCreated}}";

			document.getElementById('drawnDate').value = dateCreated;

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
		});
	</script>

						

@stop

