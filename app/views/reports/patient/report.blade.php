@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.patient-report') }}</li>
	</ol>
</div>
<div class='container-fluid'>
    {{ Form::open(array('url' => 'patientreport/'.$patient->id, 'class' => 'form-inline', 'id' => 'form-patientreport-filter', 'method'=>'POST')) }}
		{{ Form::hidden('patient', $patient->id, array('id' => 'patient')) }}
		<div class="row">
			<div class="col-sm-3">
				<label class="checkbox-inline">
	        		{{ Form::checkbox('pending', "1", isset($pending)) }}{{trans('messages.include-pending-tests')}}
				</label>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<div class="col-sm-2">
						{{ Form::label('start', trans("messages.from")) }}</div><div class="col-sm-1">
			        	{{ Form::text('start', isset($input['start'])?$input['start']:null, 
			                array('class' => 'form-control standard-datepicker')) }}
			        </div>
		        </div>
	        </div>
	        <div class="col-sm-3">
				<div class="row">
			        <div class="col-sm-2">
				        {{ Form::label('end', trans("messages.to")) }}
				    </div>
				    <div class="col-sm-1">
		                {{ Form::text('end', isset($input['end'])?$input['end']:null, 
		                    array('class' => 'form-control standard-datepicker')) }}
		            </div>
	            </div>
            </div>
            <div class="col-sm-3">
				<div class="row">
		            <div class="col-sm-4">
			            {{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
			                    array('class' => 'btn btn-primary', 'id' => 'filter', 'type' => 'submit')) }}
		            </div>
		            @if(count($verified) == count($tests))
		            <div class="col-sm-1">
				        {{ Form::submit(trans('messages.export-to-word'), array('class' => 'btn btn-success', 
				        	'id' => 'word', 'name' => 'word')) }}
				    </div>
				    @endif
			    </div>
		    </div>
	    </div>
	    {{ Form::hidden('visit_id', $visit, array('id'=>'visit_id')) }}
	{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary" id="patientReport">
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
				</tr>
				<tr>
					<th>{{ trans('messages.patient-id')}}</th>
					<td>{{ $patient->patient_number}}</td>
					<th>{{ trans('messages.age')}}</th>
					<td>{{ $patient->getAge()}}</td>
				</tr>
				<tr>
					<th>{{ trans('messages.patient-lab-number')}}</th>
					<td>{{ $patient->external_patient_number }}</td>
					<th>{{ trans('messages.requesting-facility-department')}}</th>
					<td>{{ Config::get('kblis.organization') }}</td>
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
						<span><strong>{{ $specimen->specimenType->name }}</strong></span>
						<span class="pull-right"><strong>Date ordered: &nbsp;&nbsp;&nbsp;{{	$test->isExternal()?$test->external()->request_date:$test->time_created }}</strong></span>

					</div>
					<div class="panel-body">

				<table class="table table-bordered">
					<tbody>

					<tr>
						<td><strong>{{trans('messages.specimen-id')}}</strong></td>
						<td>{{ $specimen->accession_number }}</td>

						<td><strong>{{Lang::choice('messages.test-category', 2)}}</strong></td>
						<td>{{ $specimen->labSections() }}</td>
					</tr>

					<tr>
						<td><strong>{{trans('messages.specimen-status')}}</strong></td>
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
					<tr>
						<td><strong>{{Lang::choice('messages.test-type', 1)}}</strong></td>
						<td colspan="3">{{ $specimen->testTypes() }}</td>
					</tr>

			</tbody>
		</table>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th colspan="8">{{trans('messages.test-results')}}</th>
				</tr>
				<tr>
					<th>{{Lang::choice('messages.test-type', 1)}}</th>
					<th>{{trans('messages.test-results-values')}}</th>
					<th>{{trans('messages.test-remarks')}}</th>
					<th>{{trans('messages.tested-by')}}</th>
					<th>{{trans('messages.results-entry-date')}}</th>
					<th>{{trans('messages.date-tested')}}</th>
					<th>{{trans('messages.verified-by')}}</th>
					<th>{{trans('messages.date-verified')}}</th>
				</tr>
				@forelse($tests as $test)
						<tr>
							<td>{{ $test->testType->name }}</td>
							<td>
								@foreach($test->testResults as $result)

										@if($result->result)
											<p>
												{{ Measure::find($result->measure_id)->name }}: {{ $result->result }}
												{{ Measure::find($result->measure_id)->unit }}
											</p>
										@endif
								@endforeach</td>
							<td>{{ $test->interpretation == '' ? 'N/A' : $test->interpretation }}</td>
							<td>{{ $test->testedBy->name or trans('messages.pending')}}</td>
							<td>{{ $test->testResults->last()->time_entered }}</td>
							<td>{{ $test->time_completed }}</td>
							<td>{{ $test->verifiedBy->name or trans('messages.verification-pending')}}</td>
							<td>{{ $test->time_verified }}</td>
						</tr>
				@empty
					<tr>
						<td colspan="8">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse
			</tbody>
		</table>
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
@stop