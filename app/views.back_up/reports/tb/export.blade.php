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
										<td align='center'><b>{{$percentage}}</b></td>
									@endforeach
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
				
				@else
					<p align='center'>There are no tb results to display for the period selected.</p>
				@endif
			</div>
		</div>
	</div>
	</body>
</html>