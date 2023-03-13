@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{ "Sample Receiving" }}</li>
	</ol>
</div>

<div class='container-fluid' >
	<div class='row col-md-offset-2 col-md-8' >
            <div class="panel panel-info"> <!-- Specimen Details -->
				<div class="panel-heading">
					<h3 class="panel-title">{{"Sample Receiving"}}</h3>
			    </div>
				<div class="panel-body">
                    {{ Form::open(array('route' => array('test.receiveSample'), 'class'=>'form-inline',
                        'role'=>'form', 'method'=>'GET')) }}
                        <div class="form-group">

                            {{ Form::label('search', "search", array('class' => 'sr-only')) }}
                            {{ Form::text('trackingNumber', Input::get('trackingNumber'), array('class' => 'form-control test-search barcode')) }}
                        </div> 
                        <div class="form-group">
                            {{ Form::button("<span class='glyphicon glyphicon-thumbs-up'></span> "."receive sample", 
                                array('class' => 'btn btn-primary', 'type' => 'submit')) }}
                        </div>
                    {{ Form::close() }}
                    @if (Session::has('message'))
                        <div class="alert alert-info" style="margin-top:5%;">{{ trans(Session::get('message')) }}</div>
                    @endif
                </div>
            </div>
	</div>
</div>

@stop
