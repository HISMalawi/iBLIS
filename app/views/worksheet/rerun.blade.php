@extends("layout")
@section("content")
    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
          <li class="active">{{ "Test Re-runs" }}</li>
        </ol>
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
    @endif

    <div class='container-fluid'>
        {{ Form::open(array('route' => array('test.index'), 'method' => 'GET')) }}
            <div class='row'>
                <div class='col-md-3'>
                    <div class='col-md-2'>
                        {{ Form::label('date_from', trans('messages.from')) }}
                    </div>
                    <div class='col-md-10'>
                        {{ Form::text('date_from', Input::get('date_from'), 
                            array('class' => 'form-control standard-datepicker')) }}
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class='col-md-2'>
                        {{ Form::label('date_to', trans('messages.to')) }}
                    </div>
                    <div class='col-md-10'>
                        {{ Form::text('date_to', Input::get('date_to'), 
                            array('class' => 'form-control standard-datepicker')) }}
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class='col-md-5'>
          
                    </div>
                                  </div>
                <div class='col-md-2'>
                        {{ Form::label('search', trans('messages.search'), array('class' => 'sr-only')) }}
                        {{ Form::text('search', Input::get('search'),
                            array('class' => 'form-control barcode', 'placeholder' => 'Search')) }}
                </div>
                <div class='col-md-1'>
                        {{ Form::submit(trans('messages.search'), array('class'=>'btn btn-primary')) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>

    <br>

    <div class="panel panel-primary tests-log">
        <div class="panel-heading ">
            <div class="container-fluid">
                <div class="row less-gutter">
                    <div class="col-md-11">
                        <span class="glyphicon glyphicon-filter"></span>{{"Tests To Re-Run"}}
                        @if(Auth::user()->can('request_test'))
                    	{{$request_test = false}}
			<div class="panel-btn">
                        	@if($request_test == true)
			    		<a class="btn btn-sm btn-info" href="javascript:void(0)"
                        	        	data-toggle="modal" data-target="#new-test-modal">
                                		<span class="glyphicon glyphicon-plus-sign"></span>
                                		{{trans('messages.new-test')}}
                            		</a>
				@endif
                        </div>
                        @endif
                    </div>
                    <div class="col-md-1">
                        <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
                            <span class="glyphicon glyphicon-backward"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th class="col-md-2" >{{"ARV-Number"}}</th>
                        <th class="col-md-1" >{{"Patient Name"}}</th>
                        <th class="col-md-1" >{{"Gender"}}</th>
                        <th class="col-md-1" >{{"Test To Re-Run"}}</th>
                        <th class="col-md-1">{{"Sample Type"}}</th>
                        <th class="col-md-1">{{"Sending Facility"}}</th>
                        <th class="col-md-1">{{"Accession Number"}}</th>
                        <th class="col-md-3">{{trans('messages.actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tests as $test)   
                    <?php $gender = $test->gender;
                        if($gender == 1){
                            $gender = "Male";
                        }else{
                            $gender = "Female";
                        }
                    ?>                  
                            <tr>    
                                <td> {{$test->arv_number}}</td>
                                <td> {{$test->name}}</td>
                                <td> {{$gender}}</td>
                                <td> {{$test->test_type}}</td>                            
                                <td> {{$test->specimen_type}}</td>
                                <td> {{$test->sending_facility}}</td>
                                <td> {{$test->trackingNumber}}</td>
                                <td>
                                        
                                    <a class="btn btn-sm btn-success"
                                        href="{{URL::route('test.print_tracking_number', array($test->specimenID))}}"
                                        data-toggle="modal" >
                                        <span class="glyphicon glyphicon-print"></span>
                                        Print Tracking Number
                                    </a>

                                
                                </td>
                            </tr>
                    @endforeach
                           
                </tbody>
            </table>

           
        {{ Session::put('SOURCE_URL', URL::full()) }}
        {{ Session::put('TESTS_FILTER_INPUT', Input::except('_token')); }}
        
        </div>
    </div>


  
   
    <?php
        Session::forget('activeTest');
        Session::forget('search_string');
    ?>
@stop
