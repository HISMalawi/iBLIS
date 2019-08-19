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
					{{ Form::label('start', Lang::choice("messages.year",1)) }}
				</div>
				<div class="col-md-10">
					{{ Form::text('year','2017') }}
			    </div>
	    	</div>
	    </div>
	    <div class="col-md-3">
	    	<div class="row">
				<div class="col-md-2">
			    	{{ Form::label('end', Lang::choice("messages.month",1)) }}
			    </div>
				<div class="col-md-10">
				    {{ Form::selectMonth('month')}}
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
			<?php 
				function convertMonth($monthGot){  
				    if($monthGot==1){return "January";} else if ($monthGot==2){return "February";}
					else if($monthGot==3){return "March";}else if ($monthGot==4){return "April";}
					else if($monthGot==5){return "May";}else if ($monthGot==6){return "June";}
					else if($monthGot==7){return "July";}else if ($monthGot==8){return "August";}
					else if($monthGot==9){return "September";}else if ($monthGot==10){return "October";}
					else if($monthGot==11){return "November";}else if ($monthGot==12){return "December";} }
			?>

		<p> {{ trans('messages.test-status-report') }} 
			<?php if (isset($input['year'])){$year = $input['year'];}else{$year=date("Y");}?>
			<?php if (isset($input['month'])){$month= $input['month'];}else{$month=date("m");}?>
			
			{{Lang::choice('messages.year',1). ': ' .$year.  ' '.Lang::choice('messages.month',1).': '.convertMonth($month)}}
			
			

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
							{ 	$test_data = $testTypes[$count][$cat_name];
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