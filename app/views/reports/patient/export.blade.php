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

	<div class="panel panel-primary" id="patientReport" style="border: none">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			{{ trans('messages.patient-report') }}
		</div>
		<div class="panel-body">
			@if($error!='')
				<!-- if there are search errors, they will show here -->
				<div class="alert alert-info">{{ $error }}</div>
			@else

				<div id="report_content">
					@include("reportHeader")
					<strong>
						<p>
							{{trans('messages.patient-report').' - '.date('d-m-Y')}}
						</p>
					</strong>
					<table class="table table-bordered">
						<tbody>
						<tr>
							<th>{{ trans('messages.patient-name')}}</th>
							@if(Entrust::can('view_names'))
								<td>{{ $patient->name }}</td>
							@else
								<td>N/A</td>
							@endif
							<th>{{ trans('messages.gender')}}</th>
							<td>{{ $patient->getGender(false) }}</td>
							<th>{{ trans('messages.age')}}</th>
							<td>{{ $patient->getAge()}}</td>
						</tr>

						<tr>
							<th>{{trans('messages.patient-id')}}</th>
							<td>{{ $patient->external_patient_number }}</td>
							<th colspan="2">{{ trans('messages.requesting-facility-department')}}</th>
							<td colspan="2">{{ Config::get('kblis.organization') }}</td>
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
								<span><strong>{{ $specimen->accession_number }} &nbsp;:&nbsp; {{ $specimen->specimenType->name }}</strong></span>
								<span class="pull-right"><strong>Date ordered: &nbsp;&nbsp;&nbsp;{{	$test->isExternal()?$test->external()->request_date:$test->time_created }}</strong></span>

							</div>
							<div class="panel-body">

								<table class="table table-bordered">
									<tbody>

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

										<td><strong>{{ trans('messages.collected-by')."/".trans('messages.rejected-by')}}</strong></td>
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
								<table class="table table-bordered">
									<tbody>
									<tr>
										<th colspan="8">{{trans('messages.test-results')}}
											{{(count($verified) != count($tests)) ?	('<span class="pull-right"><i>'.trans('messages.verification-pending')).'</i></span>' : ''}}</th>
									</tr>
									<tr>
										<th>{{Lang::choice('messages.test-type', 1)}}</th>
										<th>{{trans('messages.test-results')}}</th>
										<th>{{trans('messages.test-remarks')}}</th>
										<th>{{trans('messages.tested-by')}}</th>
										<th>{{trans('messages.date-tested')}}</th>
									</tr>
									@forelse($tests as $test)
										<tr>
											<td>{{ $test->testType->name }}</td>
											<td>
												@if(count($test->testResults) <= 1)
													@foreach($test->testResults as $result)

														@if($result->result)
															<p>
																{{ $result->result }}
																{{ Measure::find($result->measure_id)->unit }}
															</p>
														@endif
													@endforeach
												@else
													<table style="margin: 0px;" class="table table-bordered">
														@foreach($test->testResults as $result)

															@if(!empty($result->result))
																<tr>
																	<td style="width: 40%">
																		{{ Measure::find($result->measure_id)->name }}
																	</td>
																	<td>
																		{{ $result->result }}
																		{{ Measure::find($result->measure_id)->unit }}
																	</td>
																</tr>
															@endif
														@endforeach
													</table>
												@endif
											</td>
											<td>{{ $test->interpretation == '' ? 'N/A' : $test->interpretation }}</td>
											<td>{{ $test->testedBy->name or trans('messages.pending')}}</td>
											<td>{{ $test->time_completed }}</td>

										</tr>
									@empty
										<tr>
											<td colspan="8">{{trans("messages.no-records-found")}}</td>
										</tr>
									@endforelse
									</tbody>
								</table>

								<p><strong>{{trans("messages.susceptibility-test-results")}}</strong></p>
								@foreach($tests as $test)
									@if(count($test->susceptibility)>0)
									<table class="table table-bordered ">

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
															<th>{{ trans('messages.zone-size')}}</th>
															<th>{{ trans('messages.interp')}}</th>
														</tr>
														@foreach(Susceptibility::drugs_search($test->id, $organism->id) as $drug)
															<?php
															$drug = Drug::find($drug->drug_id);
															?>
															@if($drugSusceptibility = Susceptibility::getDrugSusceptibility($test->id, $organism->id, $drug->id))
																<tr>
																	<td>{{ $drug->name }}</td>
																	<td>{{ $drugSusceptibility->zone!=null?$drugSusceptibility->zone:'' }}</td>
																	<td>{{ $drugSusceptibility->interpretation!=null?$drugSusceptibility->interpretation:'' }}</td>
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
