@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('testpanel.index') }}">{{ Lang::choice('messages.test-panel',1) }}</a></li>
		  <li class="active">{{trans('messages.test-panel-details')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-cog"></span>
			{{trans('messages.test-panel-details')}}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to("testpanel/". $testpanel->id ."/edit") }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{trans('messages.edit')}}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ Lang::choice('messages.name',1) }}</strong>{{ $testpanel->name }} </h3>
				<p class="view-striped"><strong>{{trans('messages.short-name')}}</strong>
					{{$testpanel->short_name}}</p>
				<p class="view-striped"><strong>{{trans('messages.test-type')}}</strong>
					{{ implode(", ", $testtypes->lists('name')) }}</p>

			</div>
		</div>
	</div>
@stop