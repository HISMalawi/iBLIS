@extends("layout")
@section("content")

	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li>
		  	<a href="{{ URL::route('testnotdone.index') }}">{{ trans('messages.test-not-done') }}</a>
		  </li>
		  <li class="active">{{ trans('messages.edit-test-not-done-reason') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{ trans('messages.edit-test-not-done-reason') }}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($id, array(
                'route' => array('testnotdone.update', $id), 'method' => 'PUT',
                'id' => 'form-edit-rejection-reason')) }}
				<div class="form-group">
					{{ Form::label('reason', trans('messages.rejection-reason')) }}
					{{ Form::text('reason', Input::old('reason'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	
