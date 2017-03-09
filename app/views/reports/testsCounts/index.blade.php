@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.test-status-report') }}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.aggregate.testsResultsCounts'), 'class' => 'form-inline', 'role' => 'form')) }}
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
		    {{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		        array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
	    </div>
	</div>
<!-- </div> -->
{{ Form::close() }}
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.test-status-report') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
	<strong>
		<p> {{ trans('messages.test-status-report') }} - 
			<?php $from = isset($input['start'])?$input['start']:date('01-m-Y');?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');?>
			@if($from!=$to)
				{{trans('messages.from'). ' ' .$from.  ' '.trans('messages.to').' '.$to}}
			@else
				{{trans('messages.for').' ' .date('d-m-Y')}}
			@endif
		</p>
	</strong>

	
		<div class="table-responsive">
			<table class="table table-condensed report-table-border">
				<thead>
					<tr>
						<th>{{ Lang::choice('messages.test',1) }}</th>
						<th>{{ trans('messages.total-count') }}</th>
						<th>{{ trans('messages.total-positive-count') }}</th>
						<th>{{ trans('messages.total-negative-count') }}</th>
					</tr>
					
				</thead>
				
				<tbody>

				<?php
				
					


					for ($count=0;$count<count($testTypes);$count++)
					{

						$cat_name = key($testTypes[$count]);
						
						if ($cat_name=="Lab Reception")
						{

						}
						else
						{
							echo '<tr colspan="3">';
							echo '<th>'.$cat_name.'</th>';
							echo '</tr>';

							
							for($counter=0;$counter<count($testTypes[$count][$cat_name][0]);$counter++)
							{ 							
						          
								
								$test_data = $testTypes[$count][$cat_name];
								$test_name = key($test_data[0][$counter]);
							
								$test_count = $test_data[0][$counter][$test_name]['count']; 
								$positive = $test_data[0][$counter][$test_name]['positive'];
								$negative = $test_data[0][$counter][$test_name]['negative'];
									
								echo '<tr colspan="3">';
								echo '<td>'.$test_name.'</td>';
								echo '<td>'.$test_count.'</td>';
								echo '<td>'.$positive.'</td>';
								echo '<td>'.$negative.'</td>';
								echo '</tr>';

							}
					    }


					}	

				?>

				</tbody>

			</table>
		</div>
	</div>
</div>

@stop