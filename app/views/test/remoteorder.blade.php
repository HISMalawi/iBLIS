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
							<div class="panel-btn">
								<a class="btn btn-sm btn-success"
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
					<div class="col-md-6">
						<div class="display-details">
							<h3 class="view"><strong>{{ Lang::choice('messages.test-type',1) }}
								</strong> {{ implode(', ', Sender::get_name($test)); }}
							</h3>

							<p class="view"><strong>{{trans('messages.date-ordered')}}</strong>
								{{ $test->date_drawn }}</p>

							<p class="view"><strong>{{trans('messages.lab-receipt-date')}}</strong>
								{{$test->date_received}}</p>

							<p class="view"><strong>Sending Facility</strong>
								{{ $test->sending_facility }}</p>

							<p class="view"><strong>Receiving Facility</strong>
								{{ $test->receiving_facility }}</p>

							<p class="view"><strong>{{trans('messages.ward')}}</strong>
								{{$test->order_location}}</p>

							<p class="view-striped"><strong>Ordered By</strong>
								{{$test->who_order_test->first_name.' '.$test->who_order_test->last_name}}</p>

						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-info">  <!-- Patient Details -->
							<div class="panel-heading">
								<h3 class="panel-title">{{trans("messages.patient-details")}}</h3>
							</div>
							<div class="panel-body">
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{trans("messages.patient-number")}}</strong></p></div>
										<div class="col-md-9">
											{{$test->patient->national_patient_id}}</div></div>
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{ Lang::choice('messages.name',1) }}</strong></p></div>
										<div class="col-md-9">
											{{$test->patient->first_name.' '.$test->patient->middle_name.' '.$test->patient->last_name}}
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<p><strong> Date of Birth </strong></p></div>
										<div class="col-md-9">
											{{$test->patient->date_of_birth}}
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{trans("messages.gender")}}</strong></p></div>
										<div class="col-md-9">
											{{$test->patient->gender}}
										</div>
									</div>
								</div>
							</div> <!-- ./ panel-body -->
						</div> <!-- ./ panel -->
						<div class="panel panel-info"> <!-- Specimen Details -->
							<div class="panel-heading">
								<h3 class="panel-title">{{trans("messages.specimen-details")}}</h3>
							</div>
							<div class="panel-body">
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{ Lang::choice('messages.specimen-type',1) }}</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->sample_type }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>Tracking Number</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->_id }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans('messages.specimen-number')}}</strong></p>
										</div>
										<div class="col-md-8">
											<?php
												try{
													$acc_num = Specimen::where('accession_number', $test->_id)->first()->accession_number;
												}catch(Exception $e){$acc_num = '';}
											?>
											{{$acc_num}}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans('messages.specimen-status')}}</strong></p>
										</div>
										<div class="col-md-8">
											{{trans('messages.'.$test->status) }}
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
@stop