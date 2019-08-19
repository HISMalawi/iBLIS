@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.breadcrumb_title_positive_negative') }}</li>
	</ol>
</div>

<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
				{{trans('messages.Organims-Count-Label')}}
		</div>
	<div class="panel panel-body">
<div class="nav navbar-inverse">
		<ul class="nav nav-tabs col-sm-offset-1">
				<li><a style="background-color: black;color:white;" href="/culturesensitivitycounts">{{trans('messages.General-Counts')}}</a></li>
				<li><a  href="/wardcounts">{{trans('messages.Counts-Based-On-Wards')}}</a></li>
				<li><a  href="/organismcounts">{{trans('messages.Counts-Based-On-Organisms')}}</a></li>
				<li><a href="/organisminwardscounts">{{trans('messages.Counts-Based-On-Organisms-In-Wards')}}</a></li>
				<li><a href="/susceptibilitycounts">{{trans('messages.Measure-Values-Counts')}}</a></li>

		</ul>
	</div>

	<div id="general_count"  style="margin-top: 1%;">

		<div class="row">
			<div class="panel col-sm-offset-1 col-sm-10 col-sm-offset-1">
				<div class="panel panel-header">
						{{trans('messages.General-Counts-Label')}}
						<?php 
							function convertMonth($monthGot){  
							    if($monthGot==1){return "January";} else if ($monthGot==2){return "February";}
								else if($monthGot==3){return "March";}else if ($monthGot==4){return "April";}
								else if($monthGot==5){return "May";}else if ($monthGot==6){return "June";}
								else if($monthGot==7){return "July";}else if ($monthGot==8){return "August";}
								else if($monthGot==9){return "September";}else if ($monthGot==10){return "October";}
								else if($monthGot==11){return "November";}else if ($monthGot==12){return "December";} }
						?>

						 <?php 
						 	if (isset($input['year'])){$year = $input['year'];}else{
											$year =date("Y");}
							if (isset($input['month'])){$month = $input['month'];}else{$month =date("m");}
							echo (convertMonth($month)."-".$year);
						  ?>
				</div>

				<div class="panel panel-body">
						
					<div class="row" style="padding-top:2px;padding-bottom: 20px;border-bottom: thin solid grey;">

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
	       			    	<div class="row">
	       			    		<div class="col-md-2">
						            {{ Form::label('year',Lang::choice("messages.year",1)) }}
						        </div>
						        <div class="col-md-10">
						        	{{ Form::text('year','2017') }}
						        </div>
						    </div>
						</div>
						<div class="col-md-2">
		 				   {{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		    			    array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
	    				</div> 
					</div>

					<div class="row" style="margin-top: 30px;">
						<div class="table-responsive col-sm-offset-2 col-sm-8 col-sm-offset-2">
						<div>{{trans('messages.General-count-header')}} <?php if(isset($total)){echo $total;}else{echo "00";}  ?></div>
							<table class="table table-condensed report-table-border">
							


							</table>
						</div>

					</div>

				</div>

			</div>
					
		</div>
	</div>
  </div>

   </div>

</div>
@stop