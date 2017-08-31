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
			{{ trans('messages.laboratory-statistics')}}
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
			<table class="table table-striped table-hover table-condensed">
				<tbody>
					@foreach($categories as $cat)
						<?php
							if(count($categories) == 1)
							{
								$category_name = $categories->name;
								$test_category_id = $categories->id;
								$cat = $categories;
							}
						?>
						@if(strtoupper($cat->name) != 'LAB RECEPTION')
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
								<td colspan="{{$count}}"><b>{{$cat->name}}</b></td>
							</tr>
							@foreach($cat->testTypes as $test_type)
								<tr>
									<td>{{$test_type->name}}</td>
									<?php $total = 0;?>
									@foreach($period as $month)
										<td align='center'>
											{{$data[$cat->name][$test_type->name][$month->format('Y-m')]}}
											<?php $total += $data[$cat->name][$test_type->name][$month->format('Y-m')];?>
										</td>
									@endforeach
									<td align='center'>{{$total}}</td>
								</tr>
							@endforeach
						@endif
						<?php
							if(count($categories) == 1)
							{
								break;
							}
						?>
					@endforeach
				</tbody>
			</table>
			<?php //echo $patients->links(); 
			Session::put('SOURCE_URL', URL::full());?>
		</div>
	</div>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>