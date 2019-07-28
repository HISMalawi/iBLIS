<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/ui-lightness/jquery-ui-min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dataTables.bootstrap.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/layout.css') }}" />
        <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery-ui-min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/dataTables.bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/script.js') }} "></script>
        <script type="text/javascript" src="{{ URL::asset('js/spin.js') }} "></script>
        <script type="text/javascript" src="{{ URL::asset('highcharts/highcharts.js') }} "></script>
        <script type="text/javascript" src="{{ URL::asset('highcharts/exporting.js') }} "></script>
        <title>{{ Config::get('kblis.name') }} {{ Config::get('kblis.version') }}</title>
    </head>
<body>

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