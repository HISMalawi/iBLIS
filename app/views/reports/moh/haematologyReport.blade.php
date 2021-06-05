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
				<hr/>
				<h4 id="data_y" style="color:green">Data for the Year: </h4>
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
                            <th>Nev</th>
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

	$("#btnExport").click(function(e) {
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#dvData').html()));
		e.preventDefault();
    })

    function retrieveData(){
		var year = document.getElementById("yr").value;
		document.getElementById("data_y").innerHTML = "Data for the Year: " + year;
		var quarter = "Quarter 1";
        var indicators = JSON.parse('<?php echo json_encode($indicators); ?>');
		var counter = 1;
		var quarters = ["Quarter 1","Quarter 2","Quarter 3","Quarter 4"];
		for(var i = 0;i <indicators.length;i++){
			var slotCounter = 0;
			var total =0;
			
			for(var q = 0; q < quarters.length; q ++){
				slotCounter++;
				var quarter = quarters[q];
				
				var url = "/moh_diagnostic_stats?indicator=" + indicators[i] +"&department=haema" + "&year="+year + "&quarter="+quarter;
				jQuery.ajax({
					url: url,
					async: false,
					success: function(res){
						console.log(res);
						if (slotCounter == 1){
							id = counter+"-1";
							var jan = document.getElementById(id);
							jan.innerHTML = res[0][1];
							jan.style.color = "green";

							id = counter+"-2";
							var feb = document.getElementById(id);
							feb.innerHTML = res[1][1];
							feb.style.color = "green";

							id = counter+"-3";
							var mar = document.getElementById(id);
							mar.innerHTML = res[2][1];
							mar.style.color = "green";

							id = counter+"-4";
							var mar = document.getElementById(id);
							mar.innerHTML = parseInt(res[0][1]) + parseInt(res[1][1]) + parseInt(res[2][1]);
							mar.style.color = "white";
							total = parseInt(total) + parseInt(res[0][1]) + parseInt(res[1][1]) + parseInt(res[2][1]);

						}else if (slotCounter == 2){
							id = counter+"-5";
							var apr = document.getElementById(id);
							apr.innerHTML = res[0][1];
							apr.style.color = "green";

							id = counter+"-6";
							var may = document.getElementById(id);
							may.innerHTML = res[1][1];
							may.style.color = "green";

							id = counter+"-7";
							var jun = document.getElementById(id);
							jun.innerHTML = res[2][1];
							jun.style.color = "green";

							id = counter+"-8";
							var mar = document.getElementById(id);
							mar.innerHTML =  parseInt(res[0][1]) + parseInt(res[1][1]) + parseInt(res[2][1]);
							mar.style.color = "white";

							total = parseInt(total) + parseInt(res[0][1]) + parseInt(res[1][1]) + parseInt(res[2][1]);
						}else if (slotCounter == 3){
							id = counter+"-9";
							var jul = document.getElementById(id);
							jul.innerHTML = res[0][1];
							jul.style.color = "green";

							id = counter+"-10";
							var aug = document.getElementById(id);
							aug.innerHTML = res[1][1];
							aug.style.color = "green";

							id = counter+"-11";
							var sep = document.getElementById(id);
							sep.innerHTML = res[2][1];
							sep.style.color = "green";

							id = counter+"-12";
							var mar = document.getElementById(id);
							mar.innerHTML =  parseInt(res[0][1]) + parseInt(res[1][1]) + parseInt(res[2][1]);
							mar.style.color = "white";

							total = parseInt(total) + parseInt(res[0][1]) + parseInt(res[1][1]) + parseInt(res[2][1]);
						}else if (slotCounter == 4){
							id = counter+"-13";
							var oct = document.getElementById(id);
							oct.innerHTML = res[0][1];
							oct.style.color = "green";

							id = counter+"-14";
							var nov = document.getElementById(id);
							nov.innerHTML = res[1][1];
							nov.style.color = "green";

							id = counter+"-15";
							var dec = document.getElementById(id);
							dec.innerHTML = res[2][1];
							dec.style.color = "green";

							id = counter+"-16";
							var mar = document.getElementById(id);
							mar.innerHTML =  parseInt(res[0][1]) + parseInt(res[1][1]) + parseInt(res[2][1]);
							mar.style.color = "white";

							total = parseInt(total) + parseInt(res[0][1]) + parseInt(res[1][1]) + parseInt(res[2][1]);

							id = counter+"-17";
							var mar = document.getElementById(id);
							mar.innerHTML =  total;
							mar.style.color = "white";
						}
							
					},
					error: function(err){
						console.log(err.responseText);
					}
				})


			}
			counter = counter + 1;
		}
	
        
    }
</script>
@stop