@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li class="active">{{ Lang::choice('',2) }}</li>
		</ol>
	</div>

	<div class='container-fluid'>
		<div class='row'>
			<div class='col-lg-12'>
				{{ Form::open(array('route' => array('reports.department'), 'class' => 'form-inline', 'role' => 'form', 'method' => 'GET', 'style' => 'display:inline')) }}
					<div class='row'>
						<div class="col-sm-4">
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
						<div class="col-sm-4">
					    	<div class="row">
								<div class="col-sm-2">
								    {{ Form::label('lab_section', 'Lab Section') }}
								</div>
								<div class="col-sm-2">
								    {{ Form::select('lab_section', $category_names, isset($input['lab_section'])?$input['lab_section']:$category->name, array('class' => 'form-control')) }}
						        </div>
							</div>
						</div>
						<div class="col-sm-4">
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
			Departmental Reports
		</div>
		<div class="panel-body">
			<table class="table table-striped table-hover table-condensed">
				<tbody>
						@if(strtoupper($category->name) != 'LAB RECEPTION')
							<tr>
								<td align='center'>{{$category->name}}</td>
							</tr>
							<tr>
								<td>TESTS</td>
								
								@foreach($wards as $ward)
									<td>
										{{$ward}}
									</td>
								@endforeach
								<td align='center'><b>Total</b></td>
							</tr>
							@foreach($period as $month)
								<tr>
									<td>{{$month->format('M')}}</td>
								</tr>
								@foreach($category->testTypes as $test_type)
								<tr>
									<td>{{$test_type->name}}</td>
									<?php $total = 0;?>
									
										@foreach($wards as $ward)
											<td align='center'>
												{{$data[$test_type->name][$month->format('M')][$ward]}}
												<?php $total += [$test_type->name][$month->format('M')][$ward];?>
											</td>
										@endforeach
									@endforeach
									<td align='center'>{{$total}}</td>
								</tr>
								@endforeach
						@endif
				</tbody>
			</table>
			<?php //echo $patients->links(); 
			Session::put('SOURCE_URL', URL::full());?>
		</div>
	</div>
@stop