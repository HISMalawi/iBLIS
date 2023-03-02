@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.infection-report') }}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.aggregate.infection'), 'method' => 'post','class' => 'form-inline', 'role' => 'form')) }}
<!-- <div class='container-fluid'> -->
	<div class="row">
		<div class="col-md-3">
	    	<div class="row">
				<div class="col-md-2">
					{{ Form::label('start', trans("messages.from")) }}
				</div>
				<div class="col-md-10">
					{{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
			    </div>
	    	</div>
	    </div>
	    <div class="col-md-3">
	    	<div class="row">
				<div class="col-md-2">
			    	{{ Form::label('end', trans("messages.to")) }}
			    </div>
				<div class="col-md-10">
				    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
		        </div>
	    	</div>
	    </div>
        <div class="col-md-4">
	        <div class="col-md-4">
	        	{{ Form::label('test_type', Lang::choice('messages.test-category',1)) }}
	        </div>
	        <div class="col-md-8">
	            {{ Form::select('test_category', array(0 => '-- All --')+TestCategory::all()->sortBy('name')->lists('name','id'),
	            	isset($input['test_category'])?$input['test_category']:0, array('class' => 'form-control')) }}
	        </div>
        </div>
	    <div class="col-md-2">
	    	<span>
	    		{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		        array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
	    	</span>
	    	<span id="exp" style="display: none;">
	    		{{ Form::button("<span class='glyphicon glyphicon-export'></span> ".trans('messages.csv'), 
			    			    array('class' => 'btn btn-success', 'id' => 'export', 'type' => 'button', 'onclick' => "export()")) }}
	    	</span>
		    
	    </div>
	 
	</div>
<!-- </div> -->
{{ Form::close() }}
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.infection-report') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
	<strong>
		<p> {{ trans('messages.infection-report') }} - 
			<?php $from = isset($input['start'])?$input['start']:date('01-m-Y');?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');?>
			<?php $period = "";?>
			@if($from!=$to)
				{{trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to}}
				<?php $period = $from.'_'.$to; ?>
			@else
				{{trans('messages.for').' '.date('d-m-Y')}}
				<?php $period = date('d-m-Y'); ?>
			@endif
		</p>

	</strong>
	<div class="table-responsive">
		<table class="table table-condensed report-table-border">
			<thead>
				<tr>
					<th rowspan="2">{{ Lang::choice('messages.test',1) }}</th>
					<th rowspan="2">{{ Lang::choice('messages.measure',1) }}</th>
					<th rowspan="2">{{ trans('messages.test-results') }}</th>
					<th rowspan="2">{{ trans('messages.gender') }}</th>
					<th colspan="{{ count($ageRanges) }}">{{ trans('messages.measure-age-range') }}</th>
					<th rowspan="2">{{ trans('messages.mf-total') }}</th>
					<th rowspan="2">{{ Lang::choice('messages.total',1) }}</th>
					<th rowspan="2">{{ trans('messages.total-tests') }}</th>
				</tr>
				<tr>
					@foreach($ageRanges as $ageRange => $description)
						<th title='{{$description}}'>{{ $ageRange }}</th>
						@endforeach
				</tr>
			</thead>
		</table>
	</div>
@stop