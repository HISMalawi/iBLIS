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
		</div>
	</div>
	</body>
</html>