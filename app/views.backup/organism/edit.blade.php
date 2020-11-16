@extends("layout")
@section("content")

	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li>
		  	<a href="{{ URL::route('organism.index') }}">{{ Lang::choice('messages.organism',1) }}</a>
		  </li>
		  <li class="active">{{ trans('messages.edit-organism') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{ trans('messages.edit-organism') }}
		</div>
		<div class="panel-body">
			{{ Form::model($organism, array(
				'route' => array('organism.update', $organism->id), 'method' => 'PUT',
				'id' => 'form-edit-organism'
			)) }}

				@if($errors->all())
					<div class="alert alert-danger">
						{{ HTML::ul($errors->all()) }}
					</div>
				@endif
				
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
					{{ Form::label('drugs', trans("messages.compatible-drugs")) }}
					<div class="form-pane panel panel-default">
						<div class="container-fluid">
							<?php 
								$cnt = 0;
								$zebra = "";
							?>
						@foreach($drugs as $key=>$value)
							{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
							<?php
								$cnt++;
								$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
							?>
							<div class="col-md-3">
								<label  class="checkbox">
									<input type="checkbox" name="drugs[]" value="{{ $value->id}}" 
										{{ in_array($value->id, $organism->drugs->lists('id'))?"checked":"" }} />
										{{$value->name }}
								</label>
							</div>
							{{ ($cnt%4==0)?"</div>":"" }}
						@endforeach
						</div>
					</div>
				</div>
                <div class="form-group">
                    {{ Form::label('hl7_identifier', trans('messages.hl7_identifier')) }}
                    {{ Form::textarea('hl7_identifier', Input::old('hl7_identifier'),
                        array('class' => 'form-control', 'rows' => '1')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('hl7_text', trans('messages.hl7_text')) }}
                    {{ Form::textarea('hl7_text', Input::old('hl7_text'),
                        array('class' => 'form-control', 'rows' => '1')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('hl7_coding_system', trans('messages.hl7_coding_system')) }}
                    {{ Form::textarea('hl7_coding_system', Input::old('hl7_coding_system'),
                        array('class' => 'form-control', 'rows' => '1')) }}
                </div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'), 
						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
					{{ Form::button(trans('messages.cancel'), 
						['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
					) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	