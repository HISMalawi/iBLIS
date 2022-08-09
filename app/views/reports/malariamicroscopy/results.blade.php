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
					{{ trans('messages.malaria-microscopy') }}
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		@include("reportHeader")
	</div>

    <div id="test_records_div">
            <table class="table table-bordered" id="tableData">
                <tbody>
                    <tr>
                        <th></th>
                        <td>Total Tested</td>
                        <td>Total Positive</td>
                        <td>Total Negative</td>
                        <td>OPD</td>
                        <td>Female Ward</td>
                        <td>Male Ward</td>
                        <td>Paediatric Ward</td>
                    </tr>
                    <tr>
                        <th>Malaria Microscopy under 5yrs</th>
                        <td>{{ $total_tests_under5->total_tests}}</td>
                        <td>{{ $total_positives_under5->total}}</td>
                        <td>{{ $total_negatives_under5->total}}</td>
                        <td>{{ $totals_per_ward_under5['OPD'] }}</td>
                        <td>{{ $totals_per_ward_under5['Female Ward'] }}</td>
                        <td>{{ $totals_per_ward_under5['Male Ward'] }}</td>
                        <td>{{ $totals_per_ward_under5['Paediatric'] }}</td>
                    </tr>
                    <tr>
                        <th>Malaria Microscopy over 5yrs</th>
                        <td>{{ $total_tests_over5->total_tests}}</td>
                        <td>{{ $total_positives_over5->total}}</td>
                        <td>{{ $total_negatives_over5->total}}</td>
                        <td>{{ $totals_per_ward_over5['OPD'] }}</td>
                        <td>{{ $totals_per_ward_over5['Female Ward'] }}</td>
                        <td>{{ $totals_per_ward_over5['Male Ward'] }}</td>
                        <td>{{ $totals_per_ward_over5['Paediatric'] }}</td>
                    </tr>
                </tbody>
            </table>
    </div>
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