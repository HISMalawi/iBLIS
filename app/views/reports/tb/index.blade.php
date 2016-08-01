@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
		  <li class="active">{{trans('messages.tb-report')}}</li>
		</ol>
	</div>

	<div class='container-fluid'>
		<div class='row'>
			<div class='col-lg-12'>
				{{ Form::open(array('route' => array('reports.tb'), 'class' => 'form-inline', 'role' => 'form', 'id' => 'form-patientreport-filter', 'method' => 'POST', 'style' => 'display:inline')) }}
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
						<div class="pull-right col-sm-3">
							<div class="row">
								<div class="col-sm-3">
								  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
						                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
						        </div>
						        @if(count($result_names))
							        <div class="col-sm-2">
							       		{{ Form::button(trans('messages.print'), array('class' => 'btn btn-success', 'onclick' => "selectPrinter();")) }}
							    	</div>
							    	 <div class="col-sm-3">
								  		{{ Form::button("<span class='glyphicon glyphicon-file'></span> Export", array('class' => 'btn btn-info',
					        				'id' => "btnExport")) }}
						            </div>
					            @endif
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
			<?php 
				$from = isset($input['start'])?$input['start']:date('d-m-Y');
			 	$to = isset($input['end'])?$input['end']:date('d-m-Y');
				$to = new Datetime($to);
				$from = new Datetime($from);
			?>
			<b>{{trans('messages.from').' '.$from->format('d F, Y').' '.trans('messages.to').' '.$to->format('d F, Y')}}</b>
			<div class="table-responsive" style="width: 100%; overflow: auto;">

			<?php
				$count = 1;
				foreach($period as $dt)
				{
					$count ++;
				} 
			?>

			@if(count($result_names))
				<div id='dvData'>
					<table class="table table-striped table-hover table-condensed table-sm">
						<tbody>
							@foreach($measures as $measure)
					
								<tr>
									<td colspan="{{$count}}" align='center'><b>{{strtoupper($measure->name)}}</b></td>
								</tr>
								<tr>
									<td><b>RESULT</b></td>
									@foreach($period as $dt)
										<td align='center'><b>{{$dt->format('F')}}</b></td>
									@endforeach
								</tr>
							
							
								<?php
									$total = array(0);
								?>

								@foreach($result_names as $result_name)
									@if(in_array($result_name, $measure_results[$measure->name]))
										<tr>
											<td><b>{{$result_name}}</b></td>
											@foreach($period as $month)
												<td align='center'>
													{{isset($data[$measure->name][$month->format('F')][$result_name])?$data[$measure->name][$month->format('F')][$result_name]: 0}}
												</td>
												<?php
													if(isset($total[$month->format('F')]))
													{
														$total[$month->format('F')] += isset($data[$measure->name][$month->format('F')][$result_name])?$data[$measure->name][$month->format('F')][$result_name]:0;
													}
													else
													{
														$total[$month->format('F')] = isset($data[$measure->name][$month->format('F')][$result_name])?$data[$measure->name][$month->format('F')][$result_name]:0;
													}
													
												?>
											@endforeach
										</tr>
									@endif
								@endforeach
								<tr>
									<td><b>TOTAL EXAMINED</b></td>
									@foreach($period as $month)
										<td align='center'><b>{{$total[$month->format('F')]}}</b></td>
									@endforeach
								</tr>

								@if($measure->name == 'Smear microscopy result')
									<tr>
										<td><b>PICKUP RATE</b></td>
										@foreach($period as $month)
											<?php
												//echo $total[$month->format('F')];
											$positives = 0;
											if(isset($data[$measure->name][$month->format('F')]['Negative']))
											{
												$positives =  $total[$month->format('F')] - $data[$measure->name][$month->format('F')]['Negative'];
											}
											
												if($total[$month->format('F')])
												{
													$percentage = ceil(($positives/$total[$month->format('F')]) * 100);
												}
												else
												{
													$percentage = 0;
												}
												
											
											?>
											<td align='center'><b>{{$percentage}}%</b></td>
										@endforeach
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
				
				@else
					<p align='center'>There are no tb results to display for the period selected.</p>
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

<script type="text/javascript">

	$("#btnExport").click(function(e) {
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#dvData').html()));
    e.preventDefault();
})
</script>

@stop
