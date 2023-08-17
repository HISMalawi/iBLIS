@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">Blood Donor Register</li>
	</ol>
</div>

<div class='container-fluid'>
	<div class='row'>
		<div class='col-md-12'>
			{{ Form::open(array('route' => array('reports.bloodDonorRegister'), 'class'=>'form-inline',
				'role'=>'form', 'method'=>'GET')) }}
				<div class="form-group">

				    {{ Form::label('search', "search", array('class' => 'sr-only')) }}
		            {{ Form::text('search', Input::get('search'), array('class' => 'form-control test-search barcode')) }}
				</div>
				<div class="form-group">
					{{ Form::button("<span class='glyphicon glyphicon-search'></span> ".trans('messages.search'), 
				        array('class' => 'btn btn-primary', 'type' => 'submit')) }}
				</div>
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
		Blood Donor Register
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>Date</th>
					<th>Lab Accession No.</th>
					<th>Name of Blood Donor</th>
					<th>Age</th>
					<th>Sex(M/F)</th>
          <th>Donor's Full Address</th>
          <th>Blood Group</th>
          <th>Hb(g/dl)</th>
          <th>HIV</th>
          <th>Hep C</th>
          <th>Hep B</th>
          <th>Syphilis</th>
          <th>Malaria</th>
          <th>Donation Status</th>
			</thead>
			<tbody>
        @foreach($donors as $donor)
          <?php
            $test_results = DB::select(DB::raw("SELECT  m.name, tr.result FROM test_results tr INNER JOIN measures m ON tr.measure_id = m.id WHERE tr.test_id = $donor->id"));
            $resultDict = [];
            foreach ($test_results as $item) {
                $resultDict[strtolower($item->name)] = $item->result;
            }
          ?>
          <tr>
          <td>{{$donor->time_created}}</td>
          <td>{{$donor->getSpecimenId()}}</td>
          <td>{{$donor->visit->patient->name}}</td>
          <td>{{$donor->visit->patient->getAge()}}</td>
          <td>{{$donor->visit->patient->getGender(true)}}</td>
          <td>{{$donor->visit->patient->address}}</td>
          <td>{{$resultDict["blood group"] ?? ""}}</td>
          <td>{{$resultDict["hb"] ?? ""}}</td>
          <td>{{$resultDict["hiv"] ?? ""}}</td>
          <td>{{$resultDict["hep c"] ?? ""}}</td>
          <td>{{$resultDict["hep b"] ?? ""}}</td>
          <td>{{$resultDict["syphilis"] ?? ""}}</td>
          <td>{{$resultDict["malaria"] ?? ""}}</td>
          <td>{{$resultDict["donation status"] ?? ""}}</td>
          </tr>
        @endforeach
			</tbody>
		</table>
		
	</div>
</div>
@stop
