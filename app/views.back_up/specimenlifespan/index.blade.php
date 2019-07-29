@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.specimen-lifespan',1) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('messages.list-specimen-lifespan')}}

	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ Lang::choice('messages.specimen-type',1) }}</th>
					<th>{{ Lang::choice('messages.test-type',1) }}</th>
					<th>{{ Lang::choice('messages.specimen-lifespan',1) }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($specimenlifespan as $key => $value)
				<tr @if(Session::has('activespecimenlifespan'))
                            {{(Session::get('activespecimenlifespan') == $value->id)?"class='info'":""}}
                        @endif
                        >
					<td>{{ DB::table('specimen_types')->where("id", $value->specimen_type_id)->first()->name}}</td>
					<td>{{ DB::table('test_types')->where("id", $value->test_type_id)->first()->name }}</td>
					<?php $lifespan = DB::table('specimen_lifespan')
					->whereRaw("specimen_type_id = $value->specimen_type_id AND test_type_id = $value->test_type_id")->first() ?>
					<td>{{ $lifespan ? "$lifespan->lifespan hrs" : "8 hrs" }}</td>
					<td>
						<a class="btn btn-sm btn-info" href="{{ URL::to("specimenlifespan/" . $value->specimen_type_id . "/edit?test_type_id=$value->test_type_id") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
						</a>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{ Session::put('SOURCE_URL', URL::full()) }}
	</div>
</div>
@stop