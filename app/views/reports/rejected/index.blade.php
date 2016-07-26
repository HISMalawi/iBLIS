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
				{{ Form::open(array('route' => array('rejected.sample'), 'class' => 'form-inline', 'role' => 'form', 'id' => 'form-patientreport-filter', 'method' => 'POST', 'style' => 'display:inline')) }}
					<div class='row'>
						<div class="col-sm-4">
					    	<div class="row">
								<div class="col-sm-2">
								    {{ Form::label('start', trans('messages.from')) }}
								</div>
								<div class="col-sm-2">
								    {{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
							                array('class' => 'form-control standard-datepicker')) }}
						        </div>
							</div>
						</div>
						<div class="col-sm-4">
					    	<div class="row">
								<div class="col-sm-2">
								    {{ Form::label('end', trans('messages.to')) }}
								</div>
								<div class="col-sm-2">
								    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
							                array('class' => 'form-control standard-datepicker')) }}
						        </div>
							</div>
						</div>
						<!--div class="col-sm-4">
					    	<div class="row">
								<div class="col-sm-2">
								    {{ Form::label('test_type', 'Test') }}
								</div>
								<div class="col-sm-2">
								     {{Form::select('test_type', $test_type_names, isset($input['test_type'])?$input['test_type']:$test_type_name, array('class' => 'form-control')) }}
						        </div>
							</div>
						</div-->
						<div class="col-sm-4">
					    	<div class="row">
								<div class="col-sm-2">
								    {{ Form::label('lab_section', 'Section') }}
								</div>
								<div class="col-sm-2">
								     {{Form::select('lab_section', $categories, isset($input['lab_section'])?$input['lab_section']:$category, array('class' => 'form-control')) }}
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
								       		{{ Form::button(trans('messages.print'), array('class' => 'btn btn-success', 'onclick' => "selectPrinter();")) }}
								</div>
								<div class="col-sm-2">
								  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> Download Excel", 
						                array('class' => 'btn btn-info', 'id' => 'filter', 'name' => 'excel', 'value' => 'excel', 'type' => 'submit')) }}
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
			Rejected Samples
		</div>
	
		<div class="panel-body">
			@include("reportHeader")
			<?php $from = isset($input['start'])?$input['start']:date('d-m-Y'); ?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');
				$to = new Datetime($to);
				$from = new Datetime($from);
				 ?>
			<b>{{trans('messages.from').' '.$from->format('d F, Y').' '.trans('messages.to').' '.$to->format('d F, Y')}}</b>
			<hr>
		
			<!--table for rejected samples-->
			@if(count($rejected_wards))
				<p align='center'><b>REJECTED SAMPLES</b></p>
				<div class="table-responsive" style="width: 100%; overflow-x: scroll;">	
					<table class="table table-striped table-hover table-condensed table-sm">
						
						<tbody>
							
							<?php $count = count($rejected_wards)+2; ?>		
							@foreach($rejection_reasons as $rejection_reason)
							
								<tr>
									<td colspan={{$count}}><b>{{$rejection_reason}}</b></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									@foreach($rejected_wards as $rejected_ward)
										<td align='center'>{{$rejected_ward}}</td>
									@endforeach
									<td align='center'><b>TOTAL</b></td>
								</tr>
									
									@foreach($test_types as $test_type)
										<?php $total = 0;?>
										<tr>
											<td>{{$test_type}}</td>
												@foreach($rejected_wards as $rejected_ward)
													<td align='center'>
														{{isset($rejected_specimens[$rejection_reason][$rejected_ward][$test_type])?$rejected_specimens[$rejection_reason][$rejected_ward][$test_type]:0}}
													</td>
													<?php if(isset($rejected_specimens[$rejection_reason][$rejected_ward][$test_type])){$total += $rejected_specimens[$rejection_reason][$rejected_ward][$test_type];}?>
												@endforeach
											<td align='center'><b>{{$total}}</b></td>
										</tr>
									@endforeach
							@endforeach
						</tbody>
					</table>
				</div>
			
				<!--end of table for rejected samples-->
			@else
				<p>There are no rejected samples for the period selected</p>
			@endif
			<?php //echo $patients->links(); 
			Session::put('SOURCE_URL', URL::full());?>
		</div>
	</div>

	<!--PRINT SELECT PRINTER POPUP BEGIN -->
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
					<button type="button" class="btn" onclick="unsetValue();" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--SELECT PRINTER POPUP END -->
@stop