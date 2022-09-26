@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.malaria-microscopy', 2) }}</li>
	</ol>
</div>
    @if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
	@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
	@endif

{{ Form::open(array('route' => array('reports.malariaMicroscopy'), 'method' => 'post')) }}
    <div class="container-fluid">
        <div class="row report-filter">
            <div class="col-md-3">
                <div class="col-md-2">
                    {{ Form::label('start_date', trans("messages.from")) }}
                </div>
                <div class="col-md-10">
                    {{ Form::text('start_date', isset($input['start_date'])?$input['start_date']:date('Y-m-d'), 
                        array('class' => 'form-control standard-datepicker')) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-2">
                    {{ Form::label('end_date', trans("messages.to")) }}
                </div>
                <div class="col-md-10">
                    {{ Form::text('end_date', isset($input['end_date'])?$input['end_date']:date('Y-m-d'), 
                        array('class' => 'form-control standard-datepicker')) }}
                </div>
            </div>
            <div class="col-md-2">
                {{Form::submit(trans('messages.view'), 
                    array('class' => 'btn btn-info', 'id'=>'filter', 'name'=>'filter'))}}
            </div>
        </div>
    </div>
{{ Form::close() }}

<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<div class="container-fluid">
			<div class="row less-gutter">
				<div class="col-md-8">
					<span class="glyphicon glyphicon-user"></span>
					{{ trans('messages.malaria-report') }}
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		@include("reportHeader")
	</div>
    
</div>
</div>
@stop