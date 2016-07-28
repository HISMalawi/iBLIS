@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
			<li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		 	<li><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
		  	<li class="active">{{trans('messages.turnaround-report')}}</li>
		</ol>
	</div>

	<div class='container-fluid'>
		<div class='row'>
			<div class='col-lg-12'>
				{{ Form::open(array('route' => array('turnaround.report'), 'class' => 'form-inline', 'role' => 'form', 'id' => 'form-patientreport-filter', 'method' => 'POST', 'onclick' => 'unsetPrinterValue();', 'style' => 'display:inline')) }}
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
								<div class="col-sm-1">
								    {{ Form::label('end', trans('messages.to')) }}
								</div>
								<div class="col-sm-1">
								    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
							                array('class' => 'form-control standard-datepicker')) }}
						        </div>
							</div>
						</div>
						<div class="col-sm-3">
					    	<div class="row">
								<div class="col-sm-4">
								    {{ Form::label('lab_section', 'Section') }}
								</div>
								<div class="col-sm-3">
								    {{ Form::select('lab_section', $category_names, isset($input['lab_section'])?$input['lab_section']:$category->name, array('class' => 'form-control')) }}
						        </div>
							</div>
						</div>
						<div class="col-sm-3">
					    	<div class="row">
								<div class="col-sm-4">
								    {{ Form::label('time_format', 'Time Unit') }}
								</div>
								<div class="col-sm-3">
								    {{ Form::select('time_format', $time_formats, isset($input['time_format'])?$input['time_format']: 'hours', array('class' => 'form-control')) }}
						        </div>
							</div>
						</div>
						
					</div>

					<div class="row">
						<div class="col-sm-offset-10 col-sm-3">
							<div class="row">
								<div class=" col-sm-3">
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
			 Turn around time
		</div>
		<div class="panel-body">
			@include("reportHeader")
			<?php $from = isset($input['start'])?$input['start']:date('d-m-Y'); ?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');
				$to = new Datetime($to);
				$from = new Datetime($from);
				 ?>
			<b>{{trans('messages.from').' '.$from->format('d F, Y').' '.trans('messages.to').' '.$to->format('d F, Y')}}</b>
			<table class="table table-striped table-hover table-condensed" id="datatable">
				<thead>
					<tr>
						<th>Test Types</th>
						<th>Target Turn Around Time</th>
						<th>Average Turn Around Time</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th colspan="3">
							{{$category->name}}
						</th>
					</tr>
					@foreach($category->testTypes as $test_type)
						<tr>
							<td>{{$test_type->name}}</td>	
							<td>
									{{$data[$test_type->name]['target']}}
									@if(isset($input['time_format']))
									 	{{$input['time_format']}}
									@else
									 	{{'hours'}} 
									@endif
							</td>
							<td>@if((isset($data[$test_type->name]['tat'])) && ($data[$test_type->name]['tat'] != 0))
									{{$data[$test_type->name]['tat']}}
									@if(isset($input['time_format']))
									 {{$input['time_format']}}
									 @else
									 {{'hours'}} 
									 @endif
								@else
									{{'-'}}
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<?php //echo $patients->links(); 
			Session::put('SOURCE_URL', URL::full());?>
		</div>
	</div>

	<div id='container'>
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
						<button type="button" class="btn" data-dismiss="modal" onclick="unsetPrinterValue();">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Average Turn Around Time'
        },
       	subtitle: {
            text: <?php echo "'".trans('messages.from').' '.$from->format('d F, Y').' '.trans('messages.to').' '.$to->format('d F, Y')."'";?>
        },
        xAxis: {
            categories: [
                <?php echo "'".join($test_type_list, "','")."'"; ?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Turn Around Time <b>(<?php echo isset($input['time_format'])?$input['time_format']: 'Hours'; ?>)</b>'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} <?php echo isset($input['time_format'])?$input['time_format']: 'Hours'; ?></b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Target Turn Around Time',
            data: [<?php foreach ($test_type_list
             as $key => $value) {
            	echo strtok($data[$value]['target'], " ").",";
            }?>]

        }, {
            name: 'Turn Around Time',
            data: [<?php foreach ($test_type_list
             as $key => $value) {
            	echo $data[$value]['tat'].",";
            }?>]

        }]
    });
});
	</script>
<!--CONFIRMATION POPUP END -->
@stop
