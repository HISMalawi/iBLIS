@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li>
	  	<a href="{{ URL::route('specimentype.index') }}">{{ Lang::choice('messages.specimen-type',2) }}</a>
	  </li>
	  <li class="active">{{trans('messages.edit-specimen-type')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('messages.edit-specimen-type')}}
	</div>
	<div class="panel-body">
		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif
		{{ Form::model($specimentype, array(
				'route' => array('specimentype.update', $specimentype->id), 'method' => 'PUT',
				'id' => 'form-edit-specimentype'
			)) }}

			<div class="form-group">
				{{ Form::label('name', Lang::choice('messages.name',1)) }}
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('description', trans('messages.description')) }}
				{{ Form::textarea('description', Input::old('description'), 
					array('class' => 'form-control', 'rows' => '2')) }}
			</div>
			<div class="form-group">
				{{ Form::label('hl7_identifier', trans('messages.hl7_identifier')) }}
				{{ Form::text('hl7_identifier', Input::old('hl7_identifier'),
					array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('hl7_text', trans('messages.hl7_text')) }}
				{{ Form::textarea('hl7_text', Input::old('hl7_text'),
					array('class' => 'form-control', 'rows' => '2')) }}
			</div>
			<div class="form-group">
				{{ Form::label('hl7_coding_system', trans('messages.hl7_coding_system')) }}
				{{ Form::text('hl7_coding_system', Input::old('hl7_coding_system'),
					array('class' => 'form-control')) }}
			</div>
			<div class="form-group actions-row">
				{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
					['class' => 'btn btn-primary', 'onclick' => 'submit()']
				) }}
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop