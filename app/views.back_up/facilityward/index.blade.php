@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{Lang::choice('messages.wards',2)}}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-adjust"></span>
		{{ trans('messages.list-wards') }}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("facilityward/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.add-ward') }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ Lang::choice('messages.name', 1) }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($wards as $ward)
				<tr @if(Session::has('activeward'))
                            {{(Session::get('activeward') == $ward->id)?"class='info'":""}}
                        @endif
                    >
					<td>{{ $ward->name }}</td>
					<td>
					<!-- edit this facility (uses edit method found at GET /facility/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::to("facilityward/" . $ward->id . "/edit") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{ trans('messages.edit') }}
						</a>
					<!-- delete this facility (uses delete method found at GET /facility/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"
							data-id='{{ URL::to("facilityward/" . $ward->id . "/delete") }}'>
							<span class="glyphicon glyphicon-trash"></span>
							{{ trans('messages.delete') }}
						</button>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{ Session::put('SOURCE_URL', URL::full()) }}
	</div>
</div>
@stop