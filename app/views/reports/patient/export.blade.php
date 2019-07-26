<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/ui-lightness/jquery-ui-min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dataTables.bootstrap.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/layout.css') }}" />
	<script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/jquery-ui-min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/dataTables.bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/script.js') }} "></script>
	<title>{{ Config::get('kblis.name') }} {{ Config::get('kblis.version') }}</title>
</head>
<body>
     <?php $specimen = $spdetails ?>

	<div class="panel panel-primary" id="patientReport" style="border: none; font-size: 1em !important;">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			{{ trans('messages.patient-report') }}
		</div>
		<div class="panel-body">
			@if($error!='')
				<!-- if there are search errors, they will show here -->
				<div class="alert alert-info">{{ $error }}</div>
		
			@elseif (count($rej_status) > 0)
                                @include("reportHeader")
                                 <strong>
                                                <p> 
                                                 <?php
                                                   if($print_status == 0)
                                                    {
                                                        $print_status = 1;
                                                    }
                                                ?>
                                                        {{trans('messages.patient-report').' - '.date('d-m-Y')}}
                                                        <b style="padding-left: 10%;"><i> {{ 'No. Printed:  '. $print_status }}</i></b> 
                                                        <b style="padding-left: 10%;"> Date Sample Collected: {{$date_sample_collected}} </b>
                                                </p>
                                                
                                </strong>

                                 <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                        <th>{{ trans('messages.patient-name')}}</th>
                                                                <td>{{ $patient->name }}</td>
                                                        <th>{{ trans('messages.gender')}}</th>
                                                        <td>{{ $patient->getGender(false) }}</td>
                                                        <th>{{ trans('messages.age')}}</th>
                                                        <td>{{ $patient->getAge("YY/MM")}}</td>
                                                </tr>
                                                <?php
                                                $test = array();
                                                if(!empty($tests[0])){
                                                        $test = $tests[0];
                                                }
                                                ?>

                                                <tr>
                                                        <th>{{trans('messages.patient-id')}}</th>
                                                        <td>{{ $patient->external_patient_number }}</td>

                                                        <th colspan="2">Physical Address</th>
                                                        <td colspan="2">{{ $patient->address }}</td>

                                                </tr>
                                                </tbody>
                               </table>
 			       <div class="panel-heading ">
                                  <span class="glyphicon glyphicon-tint"></span>
                                  <span><strong>{{Lang::choice('messages.specimen-id', 1)}}</strong>&nbsp;:&nbsp;  <strong> {{ $specimen->accession_number }}</strong></span>
				<?php 

					$res =  DB::select(DB::raw("SELECT tests.time_created AS time_cre, tests.requested_by AS req_by,visits.ward_or_location AS ward FROM tests INNER JOIN specimens ON specimens.id = tests.specimen_id INNER JOIN visits ON visits.id = tests.visit_id WHERE specimens.id ='$specimen->id'"));
				?>
                                  <span class="pull-right"><strong>Requested By </strong>&nbsp;:&nbsp;  <strong> {{ $res[0]->req_by }} ( {{$res[0]->ward}})   
                                                                   </strong></span>
                               </div>


			       <table class="table table-bordered rspecimen">
                                                                        <tbody>

                                                                        <tr>
                                                                                <td><strong>{{Lang::choice('messages.specimen-type', 1)}}</strong></td>
                                                                                <td>{{ $specimen->specimenType->name }}</td>

                                                                                <td><strong>{{Lang::choice('messages.date-ordered', 1)}}</strong></td>
                                                                                <td> {{ $res[0]->time_cre  }}</td>
                                                                        </tr>

                                                                        <tr>
                                                                                <td><strong>{{Lang::choice('messages.specimen-tests-ordered', 1)}}</strong></td>
                                                                                <td>{{ $specimen->testTypes() }}</td>

                                                                                <td><strong>{{Lang::choice('messages.test-category', 2)}}</strong></td>
                                                                                <td>{{ $specimen->labSections() }}</td>
                                                                        </tr>

                                                                        <tr>
                                                                                <td><strong>{{trans('messages.ordered-specimen-status')}}</strong></td>
                                                                                @if($specimen->specimen_status_id == Specimen::NOT_COLLECTED)
                                                                                        <td>{{trans('messages.specimen-not-collected')}}</td>
                                                                                @elseif($specimen->specimen_status_id == Specimen::ACCEPTED)
                                                                                        <td>{{trans('messages.specimen-accepted')}}</td>
                                                                                @elseif($specimen->specimen_status_id == Specimen::REJECTED)
                                                                                        <td>{{trans('messages.specimen-rejected')}}</td>
                                                                                @endif

                                                                                @if($specimen->specimen_status_id == Specimen::ACCEPTED)
                                                                                        <td><strong>{{ trans('messages.collected-by') }}</strong></td>
                                                                                @elseif($specimen->specimen_status_id == Specimen::REJECTED)
                                                                                        <td><strong>{{ trans('messages.rejected-by') }}</strong></td>
                                                                                @endif

                                                                                @if($specimen->specimen_status_id == Specimen::NOT_COLLECTED)
                                                                                        <td></td>
                                                                                @elseif($specimen->specimen_status_id == Specimen::ACCEPTED)
                                                                                        <td>{{$specimen->acceptedBy->name}}</td>
                                                                                @elseif($specimen->specimen_status_id == Specimen::REJECTED)
                                                                                        <td>{{$specimen->rejectedBy->name}}</td>
                                                                                @endif
                                                                        </tr>


					</tbody>
			</table>


			<?php
                                                $number = $specimen->accession_number;
                                                        $rej_reason = DB::select(DB::raw("SELECT rejection_reasons.reason AS reason FROM rejection_reasons INNER JOIN specimens ON specimens.rejection_reason_id = rejection_reasons.id WHERE specimens.accession_number='$number'"));
                                        ?>
                        <table class="table table-bordered rtest">
                                <tbody>
                                        <tr>
                                                <th colspan="8">{{trans('messages.specimenrejected')}}
                                                </th>
                                        </tr>

                                        <tr>
                                                <td>{{$rej_reason[0]->reason}}</td>
                                        </tr>
                                </tbody>
                        </table>











			@else

				<div id="report_content">
					@include("reportHeader")
					<strong>
						<p>
							{{trans('messages.patient-report').' - '.date('d-m-Y')}}
							 <b style="padding-left: 10%;"><i> {{ 'No. Printed:  '. $print_status }}</i></b> 
                                                        <b style="padding-left: 10%;"> Date Sample Collected: {{$date_sample_collected}} </b>

						</p>
					</strong>
					<table class="table table-bordered">
						<tbody>
						<tr>
							<th>{{ trans('messages.patient-name')}}</th>
								<td>{{ $patient->name }}</td>
							<th>{{ trans('messages.gender')}}</th>
							<td>{{ $patient->getGender(false) }}</td>
							<th>{{ trans('messages.age')}}</th>
							<td>{{ $patient->getAge("YY/MM")}}</td>
						</tr>
						<?php
						$test = array();
						if(!empty($tests[0])){
							$test = $tests[0];
						}
						?>

						<tr>
							<th>{{trans('messages.patient-id')}}</th>
							<td>{{ $patient->external_patient_number }}</td>

							<th colspan="2">Physical Address</th>
							<td colspan="2">{{ $patient->address }}</td>

						</tr>
						</tbody>
					</table>

					@forelse($data as $accession_number => $tests)
						<?php
						$specimen = Specimen::where('accession_number', '=', $accession_number)->first();
						$test = $tests[0];
						?>
						<div class="panel panel-success">
							<div class="panel-heading ">
								<span class="glyphicon glyphicon-tint"></span>
								<span><strong>{{Lang::choice('messages.specimen-id', 1)}}</strong>&nbsp;:&nbsp;  <strong> {{ $specimen->accession_number }}</strong></span>

								<span class="pull-right"><strong>Requested By </strong>&nbsp;:&nbsp;  <strong> {{ $test->requested_by }}
									({{$test->visit->ward_or_location or trans('messages.unknown') }})</strong></span>
							</div>
							<div class="panel-body">

								<table class="table table-bordered rspecimen">
									<tbody>

									<tr>
										<td><strong>{{Lang::choice('messages.specimen-type', 1)}}</strong></td>
										<td>{{ $specimen->specimenType->name }}</td>

										<td><strong>{{Lang::choice('messages.date-ordered', 1)}}</strong></td>
										<td>{{	$test->isExternal()?$test->external()->request_date:$test->time_created }}</td>
									</tr>

									<tr>
										<td><strong>{{Lang::choice('messages.specimen-tests-ordered', 1)}}</strong></td>
										<td>{{ $specimen->testTypes() }}</td>

										<td><strong>{{Lang::choice('messages.test-category', 2)}}</strong></td>
										<td>{{ $specimen->labSections() }}</td>
									</tr>

									<tr>
										<td><strong>{{trans('messages.ordered-specimen-status')}}</strong></td>
										@if($specimen->specimen_status_id == Specimen::NOT_COLLECTED)
											<td>{{trans('messages.specimen-not-collected')}}</td>
										@elseif($specimen->specimen_status_id == Specimen::ACCEPTED)
											<td>{{trans('messages.specimen-accepted')}}</td>
										@elseif($specimen->specimen_status_id == Specimen::REJECTED)
											<td>{{trans('messages.specimen-rejected')}}</td>
										@endif

										@if($specimen->specimen_status_id == Specimen::ACCEPTED)
											<td><strong>{{ trans('messages.collected-by') }}</strong></td>
										@elseif($specimen->specimen_status_id == Specimen::REJECTED)
											<td><strong>{{ trans('messages.rejected-by') }}</strong></td>
										@endif

										@if($specimen->specimen_status_id == Specimen::NOT_COLLECTED)
											<td></td>
										@elseif($specimen->specimen_status_id == Specimen::ACCEPTED)
											<td>{{$specimen->acceptedBy->name}}</td>
										@elseif($specimen->specimen_status_id == Specimen::REJECTED)
											<td>{{$specimen->rejectedBy->name}}</td>
										@endif
									</tr>

									@if(count($verified) == count($tests))
										<tr>
											<td><strong>{{trans('messages.verified-by')}}</strong></td>
											<td>{{ $test->verifiedBy->name or trans('messages.verification-pending')}}</td>
											<td><strong> {{trans('messages.date-verified')}}</strong></td>
											<td>{{ $test->time_verified }}</td>
										</tr>
									@endif
									</tbody>
								</table>
								<table class="table table-bordered rtest">
									<tbody>
									<tr>
										<th colspan="8">{{trans('messages.test-results')}}
											{{(count($verified) != count($tests)) ?	('<span class="pull-right"><i>'.trans('messages.verification-pending')).'</i></span>' : ''}}</th>
									</tr>
									<tr>
										<th class="col-md-2">{{Lang::choice('messages.test-type', 1)}}</th>
										<th>{{trans('messages.test-results')}}</th>
										<th >{{trans('messages.test-remarks')}}</th>
										<th >{{trans('messages.tested-by')}}</th>
									</tr>

									<?php

									$sorted_tests = Array();
									$predefined_order = Array();

									if (in_array("CSF Analysis", explode(', ', $specimen->testTypes()))){
										$predefined_order = Array("Cell Count", "India Ink", "Gram Stain", "Differential", "Culture & Sensitivity");
									}

									if (in_array("Urinalysis", explode(', ', $specimen->testTypes()))){
										$predefined_order = Array("Urine Macroscopy", "Urine Microscopy", "Urine Chemistries");
									}

									if (in_array("Sterile Fluid Analysis", explode(', ', $specimen->testTypes()))){
										$predefined_order = Array("Cell Count", "Gram Stain", "ZN Stain", "Differential", "Culture & Sensitivity");
									}

									foreach($predefined_order AS $order){
										foreach($tests AS $t){
											if($order == $t->testType->name){
												array_push($sorted_tests, $t);
											}
										}
									}

									$tests = array_unique(array_merge($sorted_tests, $tests));

									?>

									@forelse($tests as $test)
										<tr>
											<td>{{ $test->testType->name }}</td>
											<td>
												@if(count($test->testResults) <= 1)
													@foreach($test->testResults as $result)

														@if($result->result)
															<p>
																{{ $result->result }}

																<?php $organism_names = ''?>
																@if(count($test->susceptibility)>0 && $result->result == "Growth")
																	@foreach($test->organisms() AS $og)
																		<?php
																		$organism_name = Organism::find($og['organism_id'])->name;
																		$organism_names = (!empty($organism_names))? ($organism_names.', '.$organism_name) : $organism_name;																?>
																	@endforeach
																	of {{$organism_names ? $organism_names : '---'}}
																@endif
																{{ Measure::find($result->measure_id)->unit }}
																<?php
																$measureRng = Measure::getRange($test->visit->patient, $result->measure_id);
																?>

																@if($measureRng && $test->testType->instruments->count() > 0)
																	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><b>{{$measureRng}}</b></i>
																@endif
															</p>
														@else
															Not done
														@endif
													@endforeach
												@else
													<table style="margin: 0px;padding:0px;width:100%" class="table-bordered table-condensed">
														<tr>
															<td>
																<b>Measure</b>
															</td>
															<td><b>Result</b></td>
															@if($test->testType->instruments->count() > 0)

																<td style="width: 20%"><b>Range</b></td>
															@endif
														</tr>
														@foreach($test->testResults as $result)

															@if(Measure::find($result->measure_id)->name == "HIV Status")
																<?php
																continue;
																?>
															@endif


															<tr>
																<td style="width: 40%">
																	{{ Measure::find($result->measure_id)->name }}
																</td>
																<td>
																	@if(!empty($result->result))
																		<?php $organism_names = ''?>
																		{{ $result->result }}
																		@if(count($test->susceptibility)>0 && $result->result == "Growth")
																			@foreach($test->organisms() AS $og)
																				<?php
																				$organism_name = Organism::find($og['organism_id'])->name;
																				$organism_names = (!empty($organism_names))? ($organism_names.', '.$organism_name) : $organism_name;																?>
																			@endforeach
																			of {{$organism_names ? $organism_names : '---'}}
																		@endif
																		{{ Measure::find($result->measure_id)->unit }}


																		@if( $test->testType->instruments->count() > 0)
																			<?php

																			$measureRng = Measure::getRange($test->visit->patient, $result->measure_id);
																			?>
																<td>
																	@if($measureRng)
																		<b>{{$measureRng}}</b>&nbsp;
																	@else
																		N/A
																	@endif
																</td>

																@endif
																@else

																	@if($test->testType->instruments->count() > 0)

																		@if ($test->testType->name == 'Manual Differential & Cell Morphology')
																			&nbsp;
																			<td>&nbsp;</td>
																		@else
																			Not done
																			<?php

																			$measureRng = Measure::getRange($test->visit->patient, $result->measure_id);
																			?>
																			<td>
																				@if($measureRng)
																					<b>{{$measureRng}}</b>&nbsp;
																				@else
																					N/A
																				@endif
																			</td>
																		@endif
																	@else
																		@if ($test->testType->name == 'Manual Differential & Cell Morphology')
																			&nbsp;
																		@else
																			Not done
																		@endif
																	@endif
																@endif
																</td>
															</tr>
														@endforeach
													</table>
												@endif
											</td>
											<td>{{ $test->interpretation == '' ? 'N/A' : $test->interpretation }}</td>
											<td style="width: 20%;">{{ $test->testedBy->name}}<br />
												On {{ $test->time_completed }}
												@if($test->resultDevices())
													<br /><br />

													<b><i> {{ 'Using:  '.$test->resultDevices() }}</i></b>
												@endif
											</td>

										</tr>
									@empty
										<tr>
											<td colspan="8">{{trans("messages.no-records-found")}}</td>
										</tr>
									@endforelse
									</tbody>
								</table>

								<?php  
									$susc_available = false;
									foreach($tests as $test){
										if(count($test->susceptibility)>0){
											$susc_available = true;
										}
									}
								?>
								@if($susc_available == true)
									<p><strong>{{trans("messages.susceptibility-test-results")}}</strong></p>
								@endif
						
								<?php $interpretationText = array("R" => "Resistant", "I" => "Intermediate", "S" => "Sensitive")?>
								@foreach($tests as $test)
									@if(count($test->susceptibility)>0)
									<table class="table table-bordered  rsusc">

											<?php $i = 0 ?>
											@foreach($test->organisms() as $organism)
												<?php
												$organism = Organism::find($organism->organism_id);

												?>
													{{($i % 2 == 0) ? ('<tr class="row">') : ""}}
													<td>
													<table class="table table-bordered">
														<tbody>
														<tr>
															<th colspan="3">{{ $organism->name }}</th>
														</tr>
														<tr>
															<th width="50%">{{ Lang::choice('messages.drug',1) }}</th>

															<th>{{ trans('messages.interp')}}</th>
														</tr>
														@foreach(Susceptibility::drugs_search($test->id, $organism->id) as $drug)
															<?php
															$drug = Drug::find($drug->drug_id);
															?>
															@if($drugSusceptibility = Susceptibility::getDrugSusceptibility($test->id, $organism->id, $drug->id))
																<tr>
																	<td>{{ $drug->name }}</td>

																	<td>{{ $drugSusceptibility->interpretation!=null?
																		($drugSusceptibility->interpretation.'-'.$interpretationText[$drugSusceptibility->interpretation]) :'' }}</td>
																</tr>
															@else
																<tr>
																	<td>{{ $drug->name }}</td>
																	<td></td>
																	<td></td>
																</tr>
															@endif
														@endforeach
														</tbody>
													</table>
													</td>
														{{($i % 2 == 1) ? ('</tr>') : ""}}
													<?php $i = $i + 1 ?>
											@endforeach
										</table>
									@endif
								@endforeach
							</div>
						</div>
				</div>
				@empty
					<tr>
						<td colspan="7">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse
			@endif
		</div>
	</div>

	</div>
</body>
</html>
