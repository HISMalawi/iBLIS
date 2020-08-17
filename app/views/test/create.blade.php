@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li>
		  	<a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a>
		  </li>
		  <li class="active">{{trans('messages.new-test')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
            <div class="container-fluid">
                <div class="row less-gutter">
                    <div class="col-md-11">
						<span class="glyphicon glyphicon-adjust"></span>{{trans('messages.new-test')}}
                    </div>
                    <div class="col-md-1">
                        <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
                            <span class="glyphicon glyphicon-backward"></span></a>
                    </div>
                </div>
            </div>
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('route' => 'test.saveNewTest', 'id' => 'form-new-test')) }}
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">{{trans("messages.patient-details")}}</h3>
								</div>
								<div class="panel-body inline-display-details">
									<span><strong>{{trans("messages.patient-number")}}</strong> {{ $patient->patient_number }}</span>
									<span><strong>{{ Lang::choice('messages.name',1) }}</strong> {{ $patient->name }}</span>
									<span><strong>{{trans("messages.age")}}</strong> {{ $patient->getAge() }}</span>
									<span><strong>{{trans("messages.gender")}}</strong>
										{{ $patient->gender==0?trans("messages.male"):trans("messages.female") }}</span>
								</div>
							</div>
							<div class="form-group">
								{{ Form::hidden('patient_id', $patient->id) }}
								{{ Form::label('visit_type', trans("messages.visit-type")) }}
								{{ Form::select('visit_type', [' ' => '--- Select visit type ---'] + $visittypes, null,
									 array('id' => 'visit_type', 'class' => 'form-control', 'onchange' => 'loadWards(this.value)')) }}
							</div>
							<div class="form-group">
								{{ Form::label('ward', trans("messages.ward")) }}
								{{ Form::select('ward', [], null,
									 array('class' => 'form-control', 'onmousedown' => 'loadWards(document.getElementById("visit_type").value)')) }}
							</div>

							<div class="form-group">
								{{ Form::label('requesting_clinician', trans("messages.physician")) }}
								{{Form::text('requesting_clinician', Input::old('requesting_clinician'), array('class' => 'form-control'))}}
							</div>

							<div class="form-group">
								{{ Form::label('specimen_type', trans("messages.specimen-type-title")) }}
								{{ Form::select('specimen_type', ([' ' => '--- Select specimen type ---'] + $specimen_types), null,
									 array('id' => 'specimen_type',
									 'class' => 'form-control',
									 'onchange' => 'loadTestTypes(this.value)')) }}
							</div>
							<div class="form-group">
								{{ Form::label('tests', trans("messages.select-tests")) }}
								<div class="form-pane">

									<table class="table table-striped table-hover table-condensed search-table" id="testtypes">
									<thead>
										<tr>
											<th>{{ Lang::choice('messages.test',2) }}</th>
											<th>{{ trans('messages.actions') }}</th>
														
										</tr>
									</thead>
									<tbody>

									</tbody>
						            </table>
				
								<div class="form-group actions-row">
								{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save-test'), 
									array('class' => 'btn btn-primary', 'onclick' => 'submit()', 'alt' => 'save_new_test')) }}
								</div>
						</div>
					</div>
				</div>

			{{ Form::close() }}
		</div>
	</div>
	<script>
		setTimeout(function() {
			loadWards(document.getElementById("visit_type").value);
			loadTestTypes(document.getElementById('specimen_type').value);
		}, 30
		)
	</script>
@stop	