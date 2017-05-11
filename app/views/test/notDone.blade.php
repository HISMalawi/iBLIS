@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
		  <li class="active">Not Done Reasons</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
            <div class="container-fluid">
                <div class="row less-gutter">
                    <div class="col-md-11">
						<span class="glyphicon glyphicon-filter"></span>Not Done Reasons
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
		
		{{ Form::open(array('route' => 'test.ignoreSpecimen')) }}
			{{ Form::hidden('test_id', $test_id) }}
			<div class="panel-body">
				<div class="form-group">
					{{ Form::label('rejectionReason', trans('messages.rejection-reason')) }}
				
					<select name="reasonGot">
						
						@foreach($reasons AS $reason)
							<option value="{{$reason->id}}">
								{{$reason->reason}}
							</option>
						@endforeach

					</select>
				</div>
				<div class="form-group">
					{{ Form::label('not_done_explained_to', trans("messages.reject-explained-to")) }}
					{{Form::text('not_done_explained_to', Input::old('not_done_explained_to'),
						array('class' => 'form-control'))}}
				</div>
				<div class="form-group actions-row">
					{{ Form::button("<span class='glyphicon glyphicon-thumbs-down'></span> ".trans('messages.reject'),
						['class' => 'btn btn-danger', 'onclick' => 'submit()']) }}
				</div>
			</div>
		{{ Form::close() }}
		</div>
	</div>
@stop