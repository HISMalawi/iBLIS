@extends("layout")
@section("content")
	<style>
		.datatable> tbody > tr > td:first-child
		{
		    position: absolute;
		    display: block;
		    background-color: #F2F2F2;
		    /*height:100%;*/
		    width: 170px!important;
		    border: 0px!important;
		

		}
				.datatable>thead:first-child>tr:first-child>td:first-child
		{
		    position: absolute;
		    display: inline-block;
		    background-color:#F2F2F2;
		    /*height:100%;8*/
		    width: 170px!important;
		
		}

		.datatable>thead>tr:last-child>td:last-child
		{
		    width: 170px!important;
		}
		.datatable>tbody>tr:last-child>td:last-child
		{
		    width: 170px!important;
		}
		
		.datatable> tbody > tr > td:nth-child(2)
		{
		    padding-left:170px !important;


		}
		.datatable> thead > tr > td:nth-child(2)
		{
		    padding-left:170px !important;


		}

		
	</style>
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
		  <li class="active">{{trans('messages.departmental-report')}}</li>
		</ol>
	</div>

	<div class='container-fluid'>
		<div class='row'>
			<div class='col-lg-12'>
				{{ Form::open(array('route' => array('reports.department'), 'class' => 'form-inline', 'role' => 'form', 'method' => 'POST', 'id' => 'form-patientreport-filter', 'style' => 'display:inline')) }}
					<div class='row'>
						<div class="col-sm-3">
					    	<div class="row">
								<div class="col-sm-2">
								    {{ Form::label('year', 'Year') }}
								</div>
								<div class="col-sm-2">
								    {{ Form::select('year', $years, isset($input['year'])?$input['year']:date('Y'), 
							                array('class' => 'form-control')) }}
						        </div>
							</div>
						</div>
						<div class="col-sm-4">
					    	<div class="row">
								<div class="col-sm-4">
								    {{ Form::label('lab_section', 'Lab Section') }}
								</div>
								<div class="col-sm-3">
								    {{ Form::select('lab_section', $category_names, isset($input['lab_section'])?$input['lab_section']:$category->name, array('class' => 'form-control')) }}
						        </div>
							</div>
						</div>
						<div class="col-sm-5">
					    	<div class="row">
								<div class="col-sm-2">
								  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
						                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
						        </div>
						        <div class="col-sm-2">
									{{ Form::button(trans('messages.print'), array('class' => 'btn btn-success',
						        	'onclick' => "selectPrinter()")) }}
							   	</div>
							</div>
						</div>
					</div>
					{{ Form::hidden('printer_name', '', array('id' => 'printer_name')) }}
					{{ Form::hidden('pdf', '', array('id' => 'word')) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>

	<br>

	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif

	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			{{trans('messages.department-report')}}
		</div>
		<?php $wards = array_unique($wards);?>
		<div class="panel-body">
			@include("reportHeader")
			<b>{{'As of'.' '.date('d-m-Y')}}</b>
			<hr>
			<div class="table-responsive" style="width: 100%; overflow-x: scroll;">
				@if(count($wards))
				<table class="datatable table table-striped table-hover table-condensed">
					<thead>
						<tr>
							<td><b>TESTS</b></td><td align='center' colspan="{{count($wards)}}"><b>WARDS</b></td>
						</tr>
					</thead>
					<tbody>
						@foreach($period as $dt)
								<tr>
									<td ><b>{{$dt->format('F')}}</b></td>
									@foreach($wards as $ward)
										<?php $ward = str_replace(' ', '', $ward);?>
										<td align='center'><b>{{$ward}}</b></td>
									@endforeach
									<td align='center'><b>TOTAL</b></td>
								</tr>
							@foreach($category->testTypes as $test_type)
								<tr>
									<td>{{$test_type->name}}</td>
									<?php $total = 0;?>
									@foreach($wards as $ward)
										<td align='center'>{{$data[$test_type->name][$dt->format('M')][$ward]}}</td>
										<?php $total +=$data[$test_type->name][$dt->format('M')][$ward];?>
									@endforeach
									<td align='center'><b>{{$total}}</b></td>
								</tr>
							@endforeach
						@endforeach	
					</tbody>
				</table>
			
			

				@else
					<p align='center'>There are no tests in the {{$category->name}} Lab Section to display.</p>
				@endif
			</div>
			<br>
				
			<!--table for critical values-->
			@if(count($critical_wards))
				<p align='center'><b>CRITICAL VALUES</b></p>
				<div class="table-responsive" style="width: 100%; overflow-x: scroll;">
					
					<table class="datatable table table-striped table-hover table-condensed table-sm">
						
							<tr>
								<td>&nbsp;</td>
								@foreach($critical_wards as $critical_ward)
									<td align='center'><b>{{$critical_ward}}</b></td>
								@endforeach
								<td align='center'><b>TOTAL</b></td>
							</tr>
						</thead>
						<tbody>
						
							@foreach($critical_measures as $critical_measure)

								<tr>
									<td>
										<b>{{$critical_measure}}</b>
									</td>
									<td colspan="{{count($critical_wards)+1}}">&nbsp;</td>
								</tr>
								<tr>
									<td>- High</td>
									<?php 
										$total_high = 0;
										$total_low = 0;
									?>
									@foreach($critical_wards as $critical_ward)
										<td align='center'>{{isset($critical_values[$critical_measure][$critical_ward]['high'])?$critical_values[$critical_measure][$critical_ward]['high']:0}}</td>
										<?php if(isset($critical_values[$critical_measure][$critical_ward]['high'])){ $total_high += $critical_values[$critical_measure][$critical_ward]['high'];}?>
									@endforeach
									<td align='center'><b>{{$total_high}}</b></td>
								</tr>
								<tr>
									<td>- Low</td>
									@foreach($critical_wards as $critical_ward)
										<td align='center'>{{isset($critical_values[$critical_measure][$critical_ward]['low'])?$critical_values[$critical_measure][$critical_ward]['low']:0}}</td>
										<?php if(isset($critical_values[$critical_measure][$critical_ward]['low'])){ $total_low += $critical_values[$critical_measure][$critical_ward]['low'];}?>
									@endforeach
									<td align='center'><b>{{$total_low}}</b></td>
								</tr>
							@endforeach
						</tbody>	
					</table>
				</div>
			@endif
			<!--end table for critical values-->

			<?php //echo $patients->links(); 
			Session::put('SOURCE_URL', URL::full());?>
		</div>
	</div>


		<!--PRINT CONFIRMATION POPUP BEGIN -->
	<div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: left;">
						Select Printer
					</h4>
				</div>
				<div class="modal-body">
	        <span style="text-align:center;">
	          <table align="center" id="printers">
				   @foreach($available_printers AS $printer)
				  <tr onmousedown="updateValue(this)" value="{{$printer}}">
					  <td><input type="radio" class="printer_radio_button" value="{{$printer}}" name="printer_name"/></td>
					  <td style="text-align: left; padding-left:50px;">{{$printer}}</td>
				  </tr>
				  @endforeach
			  </table>
	        </span>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="submitPrintForm();">Okay</button>
						<button type="button" class="btn" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--CONFIRMATION POPUP END -->
@stop