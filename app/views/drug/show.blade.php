@extends("layout")
@section("content")

@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('drug.index') }}">{{ Lang::choice('messages.drug',1) }}</a></li>
		  <li class="active">{{ trans('messages.drug-details') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary ">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{ trans('messages.drug-details') }}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::route('drug.edit', array($drug->id)) }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{ trans('messages.edit') }}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ Lang::choice('messages.name',1) }}:</strong>{{ $drug->name }} </h3>
				<p class="view-striped"><strong>{{ trans('messages.description') }}:</strong>
					{{ $drug->description }}</p>
				<p class="view-striped"><strong>{{ trans('messages.hl7_identifier') }}:</strong>
					{{ $drug->hl7_identifier }}</p>
				<p class="view-striped"><strong>{{ trans('messages.hl7_text') }}:</strong>
					{{ $drug->hl7_text }}</p>
				<p class="view-striped"><strong>{{ trans('messages.hl7_coding_system') }}:</strong>
					{{ $drug->hl7_coding_system }}</p>
				
			</div>
		</div>
	</div>
@stop