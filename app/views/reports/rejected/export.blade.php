@if(count($rejected_wards) > 0)
			
	<table class="table table-striped table-hover table-condensed table-sm">
		
		<tbody>
			
			<?php $count = count($rejected_wards)+2; ?>
			<tr>
					<td colspan={{$count}} align='center'><b>REJECTED SAMPLES</b></td>
				</tr>		
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
@else
	<p>There are no rejected samples for the period selected</p>
@endif