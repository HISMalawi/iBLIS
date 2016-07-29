@extends("layout")
@section("content")
	<style>
		.datatable> tbody > tr > td:first-child
		{
		    position: absolute;
		    display: block;
		    background-color: #F2F2F2;
		    /*height:100%;*/
		    width: 170px!important;
		    border: 0px!important;
		

		}
				.datatable>thead:first-child>tr:first-child>td:first-child
		{
		    position: absolute;
		    display: inline-block;
		    background-color:#F2F2F2;
		    /*height:100%;8*/
		    width: 170px!important;
		
		}

		.datatable>thead>tr:last-child>td:last-child
		{
		    width: 170px!important;
		}
		.datatable>tbody>tr:last-child>td:last-child
		{
		    width: 170px!important;
		}
		
		.datatable> tbody > tr > td:nth-child(2)
		{
		    padding-left:170px !important;


		}
		.datatable> thead > tr > td:nth-child(2)
		{
		    padding-left:170px !important;


		}

		
	</style>
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
		  <li class="active">{{trans('messages.departmental-report')}}</li>
		</ol>
	</div>

	<div class='container-fluid'>
		<div class='row'>
			<div class='col-lg-12'>
				{{ Form::open(array('route' => array('reports.department'), 'class' => 'form-inline', 'role' => 'form', 'method' => 'POST', 'id' => 'form-patientreport-filter', 'style' => 'display:inline')) }}
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
								<div class="col-sm-2">
								    {{ Form::label('lab_section', 'Section') }}
								</div>
								<div class="col-sm-3">
								    {{ Form::select('lab_section', $category_names, isset($input['lab_section'])?$input['lab_section']:$category->name, array('class' => 'form-control')) }}
						        </div>
							</div>
						</div>
						<div class="col-sm-3">
					    	<div class="row">
								<div class="col-sm-3">
								  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
						                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
						        </div>
						        @if(count($wards))
							        <div class="col-sm-2">
										{{ Form::button(trans('messages.print'), array('class' => 'btn btn-success',
							        	'onclick' => "selectPrinter()")) }}
								   	</div>
								   	<div class="col-sm-3">
								  		{{ Form::button('Export', array('class' => 'btn btn-info',
					        			'id' => "btnExport")) }}
						            </div>
					            @endif
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
			{{trans('messages.department-report')}}
		</div>
		<?php $wards = array_unique($wards);?>
		<div class="panel-body">
			@include("reportHeader")
			<?php 
				$from = isset($input['start'])?$input['start']:date('d-m-Y');
			 	$to = isset($input['end'])?$input['end']:date('d-m-Y');
				$to = new Datetime($to);
				$from = new Datetime($from);
			?>
			<b>{{trans('messages.from').' '.$from->format('d F, Y').' '.trans('messages.to').' '.$to->format('d F, Y')}}</b>
			
			
			@if(count($wards))
				@if(count($wards) > 20)
					<div class="table-responsive" style="overflow-x: scroll;" id='dvData'>
				@else
					<div class="table-responsive" id='dvData'>
				@endif

					<table class="datatable table table-striped table-hover table-condensed">
						<thead>
							<tr>
								<td><b>TESTS</b></td><td align='center' colspan="{{count($wards)}}"><b>WARDS</b></td>
							</tr>
						</thead>
						<tbody>
							@foreach($period as $dt)
									<tr>
										<td ><b>{{$dt->format('F')}}</b></td>
										@foreach($wards as $ward)
											<?php $ward = str_replace(' ', '', $ward);?>
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
				</div>
			@else
				<p>
					There are no tests in the {{$category->name}} Lab Section for the period selected to display.
				</p>
			@endif
			<br>

			<!--table for blood products-->
			<?php $count_product_wards = count($product_wards);?>
			@if($count_product_wards)
				<p align='center'><b>BLOOD PRODUCTS ISSUED</b></p>
				@if($count_product_wards > 8)
					<div class="table-responsive" style="overflow-x: scroll;" id='dvData3'>
				@else
					<div class="table-responsive" id='dvData3'>
				@endif
					
					<table class="table table-bordered table-hover table-condensed table-sm datatable">
						<thead>
							<tr>
								<th>Blood Product</th>
								<th>&nbsp;</th>
								<th colspan="{{$count_product_wards}}">Wards</th>
							</tr>
						</thead>
						<tbody>
						
							@foreach($product_ranges as $range)
								<tr>
									<td style="width:200px!important;">{{$range->alphanumeric}}</td>
									<td>&nbsp;</td>
									@foreach($product_wards as $product_ward)
										<td colspan='3' valign='bottom' align='center'>{{$product_ward}}</td>	
									@endforeach
								</tr>
						
								<tr>
									<td style="width:200px!important;">&nbsp;</td>
									<td>Age-Ranges</td>
									@foreach($product_wards as $product_ward)
										@foreach($product_age_ranges as $age_rage => $title)
											<td>{{$age_rage}}</td>
										@endforeach	
									@endforeach
								</tr>
								<tr>
									<td style="width:200px!important;">&nbsp;</td>
									<td>Female</td>
									@foreach($product_wards as $product_ward)
										@foreach($product_age_ranges as $age_rage => $title)
											<td>{{isset($product_data[$range->alphanumeric][$product_ward]['FEMALE'][$age_rage])?$product_data[$range->alphanumeric][$product_ward]['FEMALE'][$age_rage]:0}}</td>
										@endforeach	
									@endforeach
								</tr>
								<tr>
									<td style="width:200px!important;">&nbsp;</td>
									<td>Male</td>
									@foreach($product_wards as $product_ward)
										@foreach($product_age_ranges as $age_rage => $title)
											<td>{{isset($product_data[$range->alphanumeric][$product_ward]['MALE'][$age_rage])?$product_data[$range->alphanumeric][$product_ward]['MALE'][$age_rage]:0}}</td>
										@endforeach	
									@endforeach
								</tr>
								
							@endforeach
						</tbody>	
					</table>
				</div>
			@endif
			<!--end table for blood products-->

				
			<!--table for critical values-->
			@if(count($critical_wards))
				<p align='center'><b>CRITICAL VALUES</b></p>
				@if(count($critical_wards) > 20)
					<div class="table-responsive" style="overflow-x: scroll;" id='dvData2'>
				@else
					<div class="table-responsive" id='dvData2'>
				@endif
					
					<table class="datatable table table-striped table-hover table-condensed table-sm">
						
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
				</div>
			@endif
			<!--end table for critical values-->

			<?php //echo $patients->links(); 
			Session::put('SOURCE_URL', URL::full());?>



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
						<button type="button" class="btn" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--CONFIRMATION POPUP END -->


<script type="text/javascript">

	$("#btnExport").click(function(e) {
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#dvData').html()));

	 <?php
	 	if(count($critical_wards))
	 	{
	   		echo "window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#dvData2').html()));";
		}
		
   
    	if($count_product_wards)
    	{
    		echo "window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#dvData3').html()));";
    	}
    ?>
    e.preventDefault();
})
</script>
@stop