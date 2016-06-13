@extends("layout")
@section("content")

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
				{{ Form::open(array('route' => array('reports.tb'), 'class' => 'form-inline', 'role' => 'form', 'method' => 'POST', 'style' => 'display:inline')) }}
					<div class='row'>
						<div class="col-sm-3">
					    	<div class="row">
								<div class="col-sm-2">
								    {{ Form::label('year', 'Year') }}
								</div>
								<div class="col-sm-2">
								    {{ Form::select('year', $years, isset($input['year'])?$input['year']:date('Y'), 
							                array('class' => 'form-control')) }}
						        </div>
							</div>
						</div>
						
						<div class="col-sm-2">
						  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
				                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
				        </div>
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
			<span class="glyphicon glyphicon-u"></span>
			{{trans('messages.tb-report')}}
		</div>
		<div class="panel-body">
			<div class="table-responsive" style="width: 100%; overflow: auto;">
				@if(count($years))
				<table class="table table-striped table-hover table-condensed table-sm">
					<thead>
						<tr>
							<td colspan="13" align='center'><b>TB MICROSCOPY</b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							@foreach($period as $dt)
								<td align='center'><b>{{$dt->format('F')}}</b></td>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>TOTAL NUMBER POSITIVE</b></td>
							@foreach($period as $month)
								<td align='center'>{{$microscopy_positives[$month->format('F')]}}</td>
							@endforeach
						</tr>
						<tr>
							<td><b>TOTAL NUMBER NEGATIVE</b></td>
							@foreach($period as $month)
								<td align='center'>{{$microscopy_negatives[$month->format('F')]}}</td>
							@endforeach
						</tr>
						
						<tr>
							<td><b>TOTAL NUMBER EXAMINED</b></td>
							@foreach($period as $month)
								<td align='center'>{{$microscopy_negatives[$month->format('F')] + $microscopy_positives[$month->format('F')]}}</td>
							@endforeach
						</tr>
						<tr>
							<td colspan='13'>&nbsp;</td>	
						</tr>
						<tr>
							<td colspan="13" align='center'><b>INDICATION FOR GENEXPERT TEST</b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							@foreach($period as $dt)
								<td align='center'><b>{{$dt->format('F')}}</b></td>
							@endforeach
						</tr>
						<tr>
							<td><b>TOTAL NUMBER POSITIVE</b></td>
							@foreach($period as $month)
								<td align='center'>{{$genex_positives[$month->format('F')]}}</td>
							@endforeach
						</tr>
						<tr>
							<td><b>TOTAL NUMBER NEGATIVE</b></td>
							@foreach($period as $month)
								<td align='center'>{{$genex_negatives[$month->format('F')]}}</td>
							@endforeach
						</tr>
						<tr>
							<td><b>TOTAL NUMBER EXAMINED</b></td>
							@foreach($period as $month)
								<td align='center'>{{$genex_positives[$month->format('F')] + $genex_negatives[$month->format('F')]}}</td>
							@endforeach
						</tr>
					</tbody>
				</table>
				@else
					<p align='center'>There are no tb results to display</p>
				@endif
			</div>
			<?php //echo $patients->links(); 
			Session::put('SOURCE_URL', URL::full());?>
		</div>
	</div>
@stop