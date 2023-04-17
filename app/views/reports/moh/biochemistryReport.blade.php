@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
			<li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		 	<li><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
		  	<li class="active">{{ $heading }}</li>
		</ol>
	</div>

	<div class='container-fluid'>
		<div class='row'>
			<div class='col-lg-12'>
				{{ Form::open(array('class' => 'form-inline', 'role' => 'form', 'id' => 'form-patientreport-filter', 'style' => 'display:inline')) }}
					<div class='row'>
						<div class="col-sm-3">
					    	<div class="row">
								<div class="col-sm-2">
								    {{ Form::label('start', trans('messages.report-year')) }}
								</div>
								<div class="col-sm-2">
									<select id="yr" class="form-control" name="year"> 
										@foreach($years AS $year)
												<option value="<?php echo $year; ?>">{{$year}} </option>
										@endforeach
									</select>
						    </div>
							</div>
						</div>					                     
						
						<div class="col-sm-3">
							<div class="row">
								<div class="col-sm-3">
						  			{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
				                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'button', 'onclick' => 'retrieveData();')) }}
				                </div>
					       
					            <div class="col-sm-3">
							  		{{ Form::button("<span class='glyphicon glyphicon-file'></span> Export", array('class' => 'btn btn-info',
				        	'id' => "btnExport")) }}
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


	<div class="panel panel-primary">
		
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			{{ $heading }}
		</div>
		<div class="panel-body">
			
			<b></b>
			<div id='dvData'>
			<table class="table table-striped table-hover table-condensed" >
				<tbody>
                @include("reportHeader")
								<h3 hidden id="title">MoH Biochemistry Department Report</h3>
								<h4 style="color:green">Data for the Year: <span id='data_year'></span> </h4>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Laboratory Service</th>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th style="background-color:skyblue";>Total <br/> Q1</th>
                            <th>Apr</th>
                            <th>May</th>
                            <th>Jun</th>
                            <th style="background-color:skyblue";>Total <br/>Q2</th>
                            <th>Jul</th>
                            <th>August</th>
                            <th>Sep</th>
                            <th style="background-color:skyblue";>Total <br/> Q3</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dec</th>
                            <th style="background-color:skyblue";>Total <br/> Q4</th>
                            <th style="background-color:darkgreen";>Total</th>
                        </tr>
                        <tr>
						<?php  
							$counter = "1";		
							$count = 1;
						?>
                        @foreach($indicators as $indicator)
							
                                <td>{{$indicator}} </td>
                                <td id='<?php echo $counter."-1" ?>'  style="color:red">!</td>
                                <td id='<?php echo $counter."-2" ?>' style="color:red">!</td>
                                <td id='<?php echo $counter."-3" ?>'  style="color:red">!</td>
                                <td id='<?php echo $counter."-4" ?>' style="background-color:skyblue";>0</td>
                                <td id='<?php echo $counter."-5" ?>'  style="color:red">!</td>
                                <td id='<?php echo $counter."-6" ?>' style="color:red">!</td>
                                <td id='<?php echo $counter."-7" ?>'  style="color:red">!</td>
                                <td id='<?php echo $counter."-8" ?>' style="background-color:skyblue">0</td>
                                <td id='<?php echo $counter."-9" ?>' style="color:red">!</td>
                                <td id='<?php echo $counter."-10" ?>'  style="color:red">!</td>
                                <td id='<?php echo $counter."-11" ?>' style="color:red">!</td>
                                <td id='<?php echo $counter."-12" ?>'style="background-color:skyblue">0</td>
                                <td id='<?php echo $counter."-13" ?>' style="color:red">!</td>
                                <td id='<?php echo $counter."-14" ?>' style="color:red">!</td>
                                <td id='<?php echo $counter."-15" ?>' style="color:red">!</td>
                                <td id='<?php echo $counter."-16" ?>'style="background-color:skyblue">0</td>
                                <td id='<?php echo $counter."-17" ?>' style="background-color:darkgreen">0</td>
                            </tr>

							<?php  
								$count = $count +1;
								$counter = $count;		
							?>
                        @endforeach
                                                
                        </tr>
                    </tbody>
                </table>
		
				</tbody>
			</table>
			</div>
			<?php //echo $patients->links(); 
			Session::put('SOURCE_URL', URL::full());?>
		</div>
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
<!--CONFIRMATION POPUP END -->

<script type="text/javascript">

	function slugify(title) {
		return title
			.toLowerCase()
			.replace(/[^\w\s]/g, '')
			.replace(/\s+/g, '_')
			.trim()
	}


	$("#btnExport").click(function(e) {
			
			let table = document.getElementById('dvData');
			let html = table.outerHTML;

			var originalText = $('#data_year').text();

			var fileName = slugify(`${$('#title').text()} ${originalText}`);

			var downloadLink = document.createElement('a');
			downloadLink.setAttribute('href', 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,' + btoa(html));
			downloadLink.setAttribute('download', fileName);

			downloadLink.click();

			e.preventDefault();
    })

	function retrieveData(){
		reportShowSpinerDisableBtn();
		var year = document.getElementById("yr").value;
		var indicators = JSON.parse('<?php echo json_encode($indicators); ?>');
		var counter = 1;
		var quarters = ["Quarter 1","Quarter 2","Quarter 3","Quarter 4"];
		mohReportProcessData(year, indicators, counter, quarters, 'bio')
	}
</script>
@stop