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
	<div>
		<p align='center'>
			
			<b>{{$category->name}} Department Report </b>
		</p>
		<?php $wards = array_unique($wards);?>
		<div>
			@include("reportHeader")
			<b>{{'As of'.' '.date('d-m-Y')}}</b>

			
				@if(count($wards))
				<table class="datatable table table-bordered table-condensed">
					<thead>
						<tr>
							<td><b>TESTS</b></td><td align='center' colspan="{{count($wards)}}"><b>WARDS</b></td>
							<td>&nbsp;</td>
						</tr>
					</thead>
					<tbody>
						@foreach($period as $dt)
								<tr>
									<td ><b>{{$dt->format('F')}}</b></td>
									@foreach($wards as $ward)
										<td align='center'><b>{{$ward}}</b></td>
									@endforeach
									<td align='center'><b>TOTAL</b></td>
								</tr>
							@foreach($category->testTypes as $test_type)
								<tr>
									<td>{{$test_type->name}}</td>
									<?php $total = 0;?>
									@foreach($wards as $ward)
										<td align='center'>{{$data[$test_type->name][$dt->format('M')][$ward]}}</td>
										<?php $total +=$data[$test_type->name][$dt->format('M')][$ward];?>
									@endforeach
									<td align='center'><b>{{$total}}</b></td>
								</tr>
							@endforeach
						@endforeach	
					</tbody>
				</table>
			
			

				@else
					<p align='center'>There are no tests in the {{$category->name}} Lab Section to display.</p>
				@endif
	
			<br>
				
			<!--table for critical values-->
			@if(count($critical_wards))
				<p align='center'><b>CRITICAL VALUES</b></p>
					
					<table class="table table-bordered">
						
							<tr>
								<td>&nbsp;</td>
								@foreach($critical_wards as $critical_ward)
									<td align='center'><b>{{$critical_ward}}</b></td>
								@endforeach
								<td align='center'><b>TOTAL</b></td>
							</tr>
						</thead>
						<tbody>
						
							@foreach($critical_measures as $critical_measure)

								<tr>
									<td>
										<b>{{$critical_measure}}</b>
									</td>
									<td colspan="{{count($critical_wards)+1}}">&nbsp;</td>
								</tr>
								<tr>
									<td>- High</td>
									<?php 
										$total_high = 0;
										$total_low = 0;
									?>
									@foreach($critical_wards as $critical_ward)
										<td align='center'>{{isset($critical_values[$critical_measure][$critical_ward]['high'])?$critical_values[$critical_measure][$critical_ward]['high']:0}}</td>
										<?php if(isset($critical_values[$critical_measure][$critical_ward]['high'])){ $total_high += $critical_values[$critical_measure][$critical_ward]['high'];}?>
									@endforeach
									<td align='center'><b>{{$total_high}}</b></td>
								</tr>
								<tr>
									<td>- Low</td>
									@foreach($critical_wards as $critical_ward)
										<td align='center'>{{isset($critical_values[$critical_measure][$critical_ward]['low'])?$critical_values[$critical_measure][$critical_ward]['low']:0}}</td>
										<?php if(isset($critical_values[$critical_measure][$critical_ward]['low'])){ $total_low += $critical_values[$critical_measure][$critical_ward]['low'];}?>
									@endforeach
									<td align='center'><b>{{$total_low}}</b></td>
								</tr>
							@endforeach
						</tbody>	
					</table>
			@endif
			<!--end table for critical values-->
			
			
		</div>
	</div>

</body>
</html>