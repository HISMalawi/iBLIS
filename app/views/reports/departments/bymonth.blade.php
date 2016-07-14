@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
			<li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		 	<li><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
		  	<li class="active">{{trans('messages.departments-summary-report')}}</li>
		</ol>
	</div>

	<div class='container-fluid'>
		<div class='row'>
			<div class='col-lg-12'>
				{{ Form::open(array('route' => array('reports.departments_summary'), 'class' => 'form-inline', 'role' => 'form', 'id' => 'form-patientreport-filter', 'method' => 'POST', 'style' => 'display:inline')) }}
					<div class='row'>
						<div class="col-sm-3">
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
						<div class="col-sm-3">
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
						<div class="col-sm-offset-1 col-sm-5">
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
			{{ trans('messages.laboratory-statistics')}}
		</div>
		<div class="panel-body">
			@include("reportHeader")
			<?php $from = isset($input['start'])?$input['start']:date('d-m-Y'); ?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');
				$to = new Datetime($to);
				$from = new Datetime($from);
				 ?>
			<b>{{trans('messages.from').' '.$from->format('F, Y').' '.trans('messages.to').' '.$to->format('F, Y')}}</b>
			<table class="table table-striped table-hover table-condensed">
				<tbody>
					@foreach($categories as $category)
						@if(strtoupper($category->name) != 'LAB RECEPTION')
							<tr>
								<th>TESTS</th>
								<?php $count = 2;?>
								@foreach($period as $dt)
									<td align='center'><b>{{$dt->format('M')}}</b></td>
									<?php $count++; ?>
								@endforeach
								<td align='center'><b>Total</b></td>
							</tr>
							<tr>
								<td colspan="{{$count}}"><b>{{$category->name}}</b></td>
							</tr>
							@foreach($category->testTypes as $test_type)
								<tr>
									<td>{{$test_type->name}}</td>
									<?php $total = 0;?>
									@foreach($period as $month)
										<td align='center'>
											{{$data[$category->name][$test_type->name][$month->format('Y-m')]}}
											<?php $total += $data[$category->name][$test_type->name][$month->format('Y-m')];?>
										</td>
									@endforeach
									<td align='center'>{{$total}}</td>
								</tr>
							@endforeach
						@endif
					@endforeach
				</tbody>
			</table>
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