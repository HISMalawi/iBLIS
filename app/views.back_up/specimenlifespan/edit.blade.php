@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('specimenlifespan.index') }}">{{ Lang::choice('messages.specimen-lifespan',1) }}</a></li>
	  <li class="active">{{trans('messages.edit-specimen-lifespan')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('messages.edit-specimen-lifespan')}}
	</div>
	{{ Form::model($specimenlifespan, array(
			'route' => array('specimenlifespan.update', $specimenlifespan->specimen_type_id), 'method' => 'PUT',
			'id' => 'form-edit-specimenlifespan'
		)) }}
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::hidden('test_type_id', $specimenlifespan->test_type_id)}}

			<div class="form-group">
				{{ Form::label('specimen', Lang::choice('messages.specimen-type',1)) }}
				{{ Form::label('specimen', DB::table('specimen_types')->where("id", $specimenlifespan->specimen_type_id)->first()->name) }}
			</div>
			<div class="form-group">
				{{ Form::label('test_type', Lang::choice('messages.test-type',1)) }}
				{{ Form::label('test_type', DB::table('test_types')->where("id", $specimenlifespan->test_type_id)->first()->name) }}
			</div>
			<div class="form-group">
				{{ Form::label('lifespan', Lang::choice('messages.specimen-lifespan',1)) }}
				{{ Form::text('lifespan', Input::old('lifespan'), array('class' => 'form-control')) }}
			</div>
		</div>

		<div class="panel-footer">
			<div class="form-group actions-row">
				{{ Form::button(
					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
					['class' => 'btn btn-primary', 'onclick' => 'submit()']
				) }}
				{{ Form::button(trans('messages.cancel'), 
					['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
				) }}
			</div>
		</div>
	{{ Form::close() }}
</div>
@stop
