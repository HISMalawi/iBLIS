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
	<title>{{ Config::get('kblis.name') }} {{ Config::get('kblis.version') }}</title>
</head>

<body>
<div class="panel panel-primary">
		
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			{{ trans('messages.laboratory-statistics')}} Report
		</div>
		<div class="panel-body">
			@include("reportHeader")
			<?php $from = isset($input['start'])?$input['start']:date('d-m-Y'); ?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');
				$to = new Datetime($to);
				$from = new Datetime($from);
				 ?>
			<b>{{trans('messages.from').' '.$from->format('F, Y').' '.trans('messages.to').' '.$to->format('F, Y')}}</b>
			<br>

			<table width="100%" class="table table-bordered table-condensed">
				<tbody>
					@foreach($categories as $category)
						@if(strtoupper($category->name) != 'LAB RECEPTION')
							<?php $count = 2;?>
								@foreach($period as $dt)
									<?php $count++; ?>
								@endforeach
							<tr>
								<td colspan="{{$count}}"><b>{{$category->name}}</b></td>
							</tr>
							<tr>
								<td><b>TESTS</b></td>
					
								@foreach($period as $dt)
									<td><b>{{$dt->format('M')}}</b></td>

								@endforeach
								<td><b>Total</b></td>
							</tr>
							
							@foreach($category->testTypes as $test_type)
								<tr>
									<td>{{$test_type->name}}</td>
									<?php $total = 0;?>
									@foreach($period as $month)
										<td>
											{{$data[$category->name][$test_type->name][$month->format('Y-m')]}}
											<?php $total += $data[$category->name][$test_type->name][$month->format('Y-m')];?>
										</td>
									@endforeach
									<td>{{$total}}</td>
								</tr>
							@endforeach
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>