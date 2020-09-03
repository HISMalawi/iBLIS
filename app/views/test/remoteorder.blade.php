@extends("layout")
@section("content")
<?php
	// var_dump("test"); exit;

?>
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
					<div class="col-md-6">
						<div class="display-details">
							<h3 class="view"><strong>{{ Lang::choice('messages.test-type',1) }}
								</strong> {{ implode(', ', Sender::get_name($test)); }}
							</h3>

							<p class="view"><strong>{{trans('messages.date-ordered')}}</strong>
								{{ $test->data->other->date_created }}</p>

							<p class="view"><strong>{{trans('messages.lab-receipt-date')}}</strong>
								{{date("d-m-Y")}}</p>

							<p class="view"><strong>Sending Facility</strong>
								{{ $test->data->other->sending_lab }}</p>

							<p class="view"><strong>Receiving Facility</strong>
								{{ $test->data->other->receiving_lab }}</p>

							<p class="view"><strong>{{trans('messages.ward')}}</strong>
								{{$test->data->other->order_location}}</p>

							<p class="view-striped"><strong>Ordered By</strong>
								{{$test->data->other->sample_created_by->name}}</p>

						</div>
					</div>
					<?php

						// var_dump($test); exit;
					?>
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
											{{$test->data->other->patient->id}}</div></div>
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{ Lang::choice('messages.name',1) }}</strong></p></div>
										<div class="col-md-9">
											{{$test->data->other->patient->name}}
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<p><strong> Date of Birth </strong></p></div>
										<div class="col-md-9">
											{{date_format(date_create($test->data->other->patient->dob), "d-M-Y")}}
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{trans("messages.gender")}}</teststrong></p></div>
										<div class="col-md-9">
											{{$test->data->other->patient->gender}}
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
											{{$test->data->other->sample_type }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>Tracking Number</strong></p>
										</div>
										<div class="col-md-8">
											{{$tracking_number}}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans('messages.specimen-number')}}</strong></p>
										</div>
										<div class="col-md-8">
											<?php
												try{
													$acc_num = Specimen::where('tracking_number', $tracking_number)->first()->accession_number;
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
											{{$test->data->other->specimen_status }}
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

	<div class="panel panel-info">  <!-- Test Results -->
		<div class="panel-heading">
			<h3 class="panel-title">{{trans("messages.test-results")}}</h3>
		</div>
		<div class="panel-body">
			<div class="container-fluid">
			
				@if ($test_result->error == false)						
						@foreach($test_result->data->results as $testName => $results)

							<div class="col-md-6">
								<table class="table table-bordered">
									<tbody>
									<tr>
										<th>{{ $testName }}</th>
										<th>
											&nbsp;
										</th>
									</tr>
									<tr>
										<th width="50%">{{ Lang::choice('messages.measure-type',1) }}</th>
										<th>{{ trans('messages.result-name')}}</th>
									</tr>

										@foreach($results as $measure => $value)

											@if($measure != "result_date")
												<tr>
													<td>{{ $measure }}</td>
													<td> {{$value}} </td>
												</tr>
											@endif
									
										@endforeach
									</tbody>
								</table>
							</div>

						@endforeach
				@else
							<div class="col-md-6">
								<table class="table table-bordered">
									<tbody>
									<tr>
										<th></th>
										<th>
											&nbsp;
										</th>
									</tr>
									<tr>
										<th width="50%">{{ Lang::choice('messages.measure-type',1) }}</th>
										<th>{{ trans('messages.result-name')}}</th>
									</tr>
										
												<tr>
													<td>N/A</td>
													<td>N/A</td>
												</tr>
										
									</tbody>
								</table>
							</div>
				@endif
			</div>
		</div> <!-- ./ panel-body -->
	</div>  <!-- ./ panel -->

	
@stop