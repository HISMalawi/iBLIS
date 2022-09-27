@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.malaria-microscopy', 2) }}</li>
	</ol>
</div>
    @if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
	@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
	@endif

{{ Form::open(array('route' => array('reports.malariaMicroscopy'), 'method' => 'post')) }}
    <div class="container-fluid">
        <div class="row report-filter">
            <div class="col-md-3">
                <div class="col-md-2">
                    {{ Form::label('start_date', trans("messages.from")) }}
                </div>
                <div class="col-md-10">
                    {{ Form::text('start_date', isset($input['start_date'])?$input['start_date']:date('Y-m-d'), 
                        array('class' => 'form-control standard-datepicker')) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-2">
                    {{ Form::label('end_date', trans("messages.to")) }}
                </div>
                <div class="col-md-10">
                    {{ Form::text('end_date', isset($input['end_date'])?$input['end_date']:date('Y-m-d'), 
                        array('class' => 'form-control standard-datepicker')) }}
                </div>
            </div>
            <div class="col-md-2">
                {{Form::submit(trans('messages.view'), 
                    array('class' => 'btn btn-info', 'id'=>'filter', 'name'=>'filter'))}}
            </div>
            <div class="col-sm-3">
			    {{ Form::button("Export", array('class' => 'btn btn-info',
				        	'id' => "btnExport1")) }}
			</div>
        </div>
    </div>
{{ Form::close() }}

<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<div class="container-fluid">
			<div class="row less-gutter">
				<div class="col-md-8">
					<span class="glyphicon glyphicon-user"></span>
					{{ trans('messages.malaria-report') }}
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		@include("reportHeader")
	</div>

    @if($malariaData['size'] > 0)
    <div id=tableData>
        <table class="table table-bordered text-center" id="ttableData">
            <caption class="font-weight-bold"><strong>Malaria Report for a period of {{$startDate}} to {{$endDate}}</strong></caption>
            <tbody>
              <tr>
                <td colspan="2" rowspan="2"></td>
                <th colspan="2" scope="colgroup" class='text-center'>MRDT</th>
                <th colspan="2" scope="colgroup" class='text-center'>Microscopy</th>
              </tr>
              <tr>
                <th scope="col" class='text-center'>Under 5 years</th>
                <th scope="col" class='text-center'>Over 5 years</th>
                <th scope="col" class='text-center'>Under 5 years</th>
                <th scope="col" class='text-center'>Over 5 years</th>
              </tr>
              @foreach($malariaData['WARDS'] as $ward)
                <tr>
                    <th rowspan="3" scope="rowgroup" class='text-center'>{{$ward}}</th>
                    <th scope="row" class='text-center'>Positive</th>
                    <td>{{$malariaData['MRDT']['wards']['POS_U5'][$ward]}}</td>
                    <td>{{$malariaData['MRDT']['wards']['POS_O5'][$ward]}}</td>
                    <td>{{$malariaData['MICRO']['wards']['POS_U5'][$ward]}}</td>
                    <td>{{$malariaData['MICRO']['wards']['POS_O5'][$ward]}}</td>
                </tr>
                <tr>
                    <th scope="row" class='text-center'>Negative</th>
                    <td>{{$malariaData['MRDT']['wards']['NEG_U5'][$ward]}}</td>
                    <td>{{$malariaData['MRDT']['wards']['NEG_O5'][$ward]}}</td>
                    <td>{{$malariaData['MICRO']['wards']['NEG_U5'][$ward]}}</td>
                    <td>{{$malariaData['MICRO']['wards']['NEG_O5'][$ward]}}</td>
                </tr>
                <tr>
                    <th scope="row" class='text-center'>Invalid</th>
                    <td>{{$malariaData['MRDT']['wards']['INV_U5'][$ward]}}</td>
                    <td>{{$malariaData['MRDT']['wards']['INV_O5'][$ward]}}</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
              @endforeach
              <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
              <tr>
                <th rowspan="2" scope="rowgroup" class='text-center'>IN PATIENT</th>
                <th scope="row" class='text-center'>Positive</th>
                <td>{{$malariaData['MRDT']['visit']['POS_U5']}}</td>
                <td>{{$malariaData['MRDT']['visit']['POS_O5']}}</td>
                <td>{{$malariaData['MICRO']['visit']['POS_U5']}}</td>
                <td>{{$malariaData['MICRO']['visit']['POS_O5']}}</td>
            </tr>
            <tr>
                <th scope="row" class='text-center'>Negative</th>
                <td>{{$malariaData['MRDT']['visit']['NEG_U5']}}</td>
                <td>{{$malariaData['MRDT']['visit']['NEG_O5']}}</td>
                <td>{{$malariaData['MICRO']['visit']['NEG_U5']}}</td>
                <td>{{$malariaData['MICRO']['visit']['NEG_O5']}}</td>
            </tr>
             @foreach($malariaData['gList'] as $gender)
                <tr>
                    <th rowspan="2" scope="rowgroup" class='text-center'>{{strtoupper($gender)}}</th>
                    <th scope="row" class='text-center'>Positive</th>
                    <td>{{$malariaData['MRDT']['gender'][$gender]['POS_U5']}}</td>
                    <td>{{$malariaData['MRDT']['gender'][$gender]['POS_O5']}}</td>
                    <td>{{$malariaData['MICRO']['gender'][$gender]['POS_U5']}}</td>
                    <td>{{$malariaData['MICRO']['gender'][$gender]['POS_O5']}}</td>
                </tr>
                <tr>
                    <th scope="row" class='text-center'>Negative</th>
                    <td>{{$malariaData['MRDT']['gender'][$gender]['NEG_U5']}}</td>
                    <td>{{$malariaData['MRDT']['gender'][$gender]['NEG_O5']}}</td>
                    <td>{{$malariaData['MICRO']['gender'][$gender]['NEG_U5']}}</td>
                    <td>{{$malariaData['MICRO']['gender'][$gender]['NEG_O5']}}</td>
                </tr>
            @endforeach
            <tr>
                <th rowspan="2" scope="rowgroup" class='text-center'>FEMALE PREGNANT</th>
                <th scope="row" class='text-center'>Positive</th>
                <td></td>
                <td>{{$malariaData['MRDT']['pregnant']['POS_O5']}}</td>
                <td></td>
                <td>{{$malariaData['MICRO']['pregnant']['POS_O5']}}</td>
            </tr>
            <tr>
                <th scope="row" class='text-center'>Negative</th>
                <td></td>
                <td>{{$malariaData['MRDT']['pregnant']['NEG_O5']}}</td>
                <td></td>
                <td>{{$malariaData['MICRO']['pregnant']['NEG_O5']}}</td>
            </tr>
            </tbody>
          </table>
          <table class="table table-bordered text-center">
            <h1>Summary</h1>
            <tbody>
                <tr>
                    <th></th>
                    <th>Total Tested</th>
                    <th>Total Positive</th>
                    <th>Total Negative</th>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Female Pregnant</th>
                    <th>In Patients</th>
                </tr>
                <tr>
                    <th>Microscopy Over 5yrs</th>
                    <td>{{$malariaData['total_tested']['micro_o5']}}</td>
                    <td>{{$malariaData['total_positives']['micro_o5']}}</td>
                    <td>{{$malariaData['total_negatives']['micro_o5']}}</td>
                    <td>{{$malariaData['gender']['male']['micro_o5']}}</td>
                    <td>{{$malariaData['gender']['female']['micro_o5']}}</td>
                    <td>{{$malariaData['pregnant']['micro_o5']}}</td>
                    <td>{{$malariaData['visit_type']['in_patient']['micro_o5']}}</td>

                </tr>
                <tr>
                    <th>Microscopy Under 5yrs</th>
                    <td>{{$malariaData['total_tested']['micro_u5']}}</td>
                    <td>{{$malariaData['total_positives']['micro_u5']}}</td>
                    <td>{{$malariaData['total_negatives']['micro_u5']}}</td>
                    <td>{{$malariaData['gender']['male']['micro_u5']}}</td>
                    <td>{{$malariaData['gender']['female']['micro_u5']}}</td>
                    <td></td>
                    <td>{{$malariaData['visit_type']['in_patient']['micro_u5']}}</td>

                </tr>
                <tr>
                    <th>MRDT Over 5yrs</th>
                    <td>{{$malariaData['total_tested']['mrdt_o5']}}</td>
                    <td>{{$malariaData['total_positives']['mrdt_o5']}}</td>
                    <td>{{$malariaData['total_negatives']['mrdt_o5']}}</td>
                    <td>{{$malariaData['gender']['male']['mrdt_o5']}}</td>
                    <td>{{$malariaData['gender']['female']['mrdt_o5']}}</td>
                    <td>{{$malariaData['pregnant']['mrdt_o5']}}</td>
                    <td>{{$malariaData['visit_type']['in_patient']['mrdt_o5']}}</td>

                </tr>
                <tr>
                    <th>MRDT Under 5yrs</th>
                    <td>{{$malariaData['total_tested']['mrdt_u5']}}</td>
                    <td>{{$malariaData['total_positives']['mrdt_u5']}}</td>
                    <td>{{$malariaData['total_negatives']['mrdt_u5']}}</td>
                    <td>{{$malariaData['gender']['male']['mrdt_u5']}}</td>
                    <td>{{$malariaData['gender']['female']['mrdt_u5']}}</td>
                    <td></td>
                    <td>{{$malariaData['visit_type']['in_patient']['mrdt_u5']}}</td>

                </tr>
            </tbody>
          </table>
    </div>
    @else
    <h1>NO DATA FOUND</h1>
    @endif


</div>
<script type="text/javascript">

	$("#btnExport1").click(function(e) {
    let table = document.getElementById('tableData');
    let html = table.outerHTML;
    window.open('data:application/vnd.ms-excel;base64,' + btoa(html));
    e.preventDefault();
})
</script>
@stop