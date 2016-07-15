@extends("layout")
@section("content")

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
				{{ Form::open(array('route' => array('reports.tb'), 'class' => 'form-inline', 'role' => 'form', 'id' => 'form-patientreport-filter', 'method' => 'POST', 'style' => 'display:inline')) }}
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
						<div class="col-sm-5">
							<div class="row">
								<div class="col-sm-2">
								  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
						                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
						        </div>
						        <div class="col-sm-1">
						       		{{ Form::button(trans('messages.print'), array('class' => 'btn btn-success', 'onclick' => "selectPrinter();")) }}
						    	</div>
						    </div>
						</div>
					</div>
					{{ Form::hidden('printer_name', '', array('id' => 'printer_name')) }}

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
			{{trans('messages.tb-report')}}
		</div>
		<div class="panel-body">
			@include("reportHeader")
			<b>{{'As of'.' '.date('d-m-Y')}}</b>
			<div class="table-responsive" style="width: 100%; overflow: auto;">
				@if(count($years))

				<table class="table table-striped table-hover table-condensed table-sm">
					<thead>
						<tr>
							<td colspan="13" align='center'><b>TB MICROSCOPY</b></td>
						</tr>
						<tr>
							<td><b>RESULT</b></td>
							@foreach($period as $dt)
								<td align='center'><b>{{$dt->format('F')}}</b></td>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<?php
							$total = array(0);
						?>
						@foreach($micro_results as $micro_result)
							<tr>
								<td><b>{{$micro_result}}</b></td>
								@foreach($period as $month)
									<td align='center'>{{isset($microscopy_data[$month->format('F')][$micro_result])?$microscopy_data[$month->format('F')][$micro_result]: 0}}</td>
									<?php
										if(isset($total[$month->format('F')]))
										{
											$total[$month->format('F')] += isset($microscopy_data[$month->format('F')][$micro_result])?$microscopy_data[$month->format('F')][$micro_result]:0;
										}
										else
										{
											$total[$month->format('F')] = isset($microscopy_data[$month->format('F')][$micro_result])?$microscopy_data[$month->format('F')][$micro_result]:0;
										}
										
									?>
								@endforeach
							</tr>
						@endforeach
						<tr>
							<td><b>TOTAL EXAMINED</b></td>
							@foreach($period as $month)
								<td align='center'><b>{{$total[$month->format('F')]}}</b></td>
							@endforeach
						</tr>
						
						<tr>
							<td colspan='13'>&nbsp;</td>	
						</tr>
						<tr>
							<td colspan="13" align='center'><b>INDICATION FOR GENEXPERT TEST</b></td>
						</tr>
						
						<tr>
							<td><b>RESULT</b></td>
							@foreach($period as $dt)
								<td align='center'><b>{{$dt->format('F')}}</b></td>
							@endforeach
						</tr>
						<?php $total = array(0); ?>
						@foreach($genex_results as $genex_result)
							<tr>
								<td><b>{{$genex_result}}</b></td>
								@foreach($period as $month)
									<td align='center'>{{isset($genex_data[$month->format('F')][$genex_result])?$genex_data[$month->format('F')][$genex_result]: 0}}</td>
									<?php
										if(isset($total[$month->format('F')]))
										{
											$total[$month->format('F')] += isset($genex_data[$month->format('F')][$genex_result])?$genex_data[$month->format('F')][$genex_result]:0;
										}
										else
										{
											$total[$month->format('F')] = isset($genex_data[$month->format('F')][$genex_result])?$genex_data[$month->format('F')][$genex_result]:0;
										}
										
									?>
								@endforeach
							</tr>
						@endforeach
						<tr>
							<td><b>TOTAL EXAMINED</b></td>
							@foreach($period as $month)
								<td align='center'><b>{{$total[$month->format('F')]}}</b></td>
							@endforeach
						</tr>
						
					</tbody>
				</table>
				@else
					<p align='center'>There are no tb results to display</p>
				@endif
			</div>
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
