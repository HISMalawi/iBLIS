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
@if(count($rejected_wards) > 0)
<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Rejected Samples
		</div>
	
		<div class="panel-body">
			@include("reportHeader")
			<?php $from = isset($input['start'])?$input['start']:date('d-m-Y'); ?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');
				$to = new Datetime($to);
				$from = new Datetime($from);
				 ?>
			<b>{{trans('messages.from').' '.$from->format('d F, Y').' '.trans('messages.to').' '.$to->format('d F, Y')}}</b>
		
			<!--table for rejected samples-->
			@if(count($rejected_wards))
				<p align='center'><b>REJECTED SAMPLES</b></p>
				<div class="table-responsive" style="width: 100%; overflow-x: scroll;">	
					<table class="table table-striped table-hover table-condensed table-sm">
						
						<tbody>
							
							<?php $count = count($rejected_wards)+2; ?>		
							@foreach($rejection_reasons as $rejection_reason)
							
								<tr>
									<td colspan={{$count}}><b>{{$rejection_reason}}</b></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									@foreach($rejected_wards as $rejected_ward)
										<td align='center'>{{$rejected_ward}}</td>
									@endforeach
									<td align='center'><b>TOTAL</b></td>
								</tr>
									
									@foreach($test_types as $test_type)
										<?php $total = 0;?>
										<tr>
											<td>{{$test_type}}</td>
												@foreach($rejected_wards as $rejected_ward)
													<td align='center'>
														{{isset($rejected_specimens[$rejection_reason][$rejected_ward][$test_type])?$rejected_specimens[$rejection_reason][$rejected_ward][$test_type]:0}}
													</td>
													<?php if(isset($rejected_specimens[$rejection_reason][$rejected_ward][$test_type])){$total += $rejected_specimens[$rejection_reason][$rejected_ward][$test_type];}?>
												@endforeach
											<td align='center'><b>{{$total}}</b></td>
										</tr>
									@endforeach
							@endforeach
						</tbody>
					</table>
				</div>
			
				<!--end of table for rejected samples-->
			@else
				<p>There are no rejected samples for the period selected</p>
			@endif
			<?php //echo $patients->links(); 
			Session::put('SOURCE_URL', URL::full());?>
		</div>
	</div>
@else
	<p>There are no rejected samples for the period selected</p>
@endif
</body>
</html>