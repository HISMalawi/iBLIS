@extends("layout")
@section("content")
    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
          <li class="active">{{ "Worksheets" }}</li>
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
                        <span class="glyphicon glyphicon-filter"></span>{{"Worksheets"}}
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
                        <th class="col-md-2" style="width: 13.5% !important;"> {{"Worksheet No."}}</th>
                        <th class="col-md-2" >{{"Date Created"}}</th>
                        <th class="col-md-1" >{{"Device Used"}}</th>
                        <th class="col-md-1" >{{"Status"}}</th>
                        <th class="col-md-1" >{{"Total Tests"}}</th>
                        <th class="col-md-1">{{"Started At"}}</th>
                        <th class="col-md-1">{{"Completed At"}}</th>
                        <th class="col-md-1">{{"Verified At"}}</th>
                        <th class="col-md-3">{{trans('messages.actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($worksheets as $worksheet)
                        <?php 
                            $worksheetID = $worksheet->id;
                            $res = DB::SELECT("SELECT count(*) AS total FROM tests WHERE worksheet_id='$worksheetID'");
                            if(count($res)>0){
                                $total = $res[0]->total;
                            }
                        ?>
                        @if($total >0)
                            <tr>    
                                <td> {{$worksheet->id}}</td>
                                <td> {{$worksheet->created_at}}</td>
                                <td> {{$worksheet->device_name}}</td>
                                @if(isset($worksheet->verified_at))
                                    <td>Verified</td>
                                @else 
                                    <td>Completed</td>
                                @endif
                                <td> {{$total}}</td>
                                <td> {{$worksheet->started_at}}</td>
                                <td> {{$worksheet->completed_at}}</td>
                                <td> {{$worksheet->verified_at}}</td>
                                <td>
                                        
                                        

                                    @if(isset($worksheet->verified_at))
                                        <a class="main-view main-view-{{'1'}} btn btn-sm btn-success"
                                        href="{{ URL::route('test.viewDetails', '1') }}"
                                        id="view-details-{{'1'}}-link"
                                        title="{{trans('messages.view-details-title')}}">
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                            {{'print results'}}
                                        </a>

                                    @endif
                                    @if(!isset($worksheet->verified_at) && isset($worksheet->completed_at))
                                        <a class="main-view main-view-{{$worksheet->id}} btn btn-sm btn-success" id="verify-{{$worksheet->id}}-link"
                                            href="{{ URL::route('worksheet.viewWorksheetTests', array($worksheet->id)) }}"
                                            title="{{trans('messages.verify-title')}}">
                                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                                {{'verify results'}}
                                        </a>
                                    @else

                                        <a class="main-view main-view-{{$worksheet->id}} btn btn-sm btn-success" id="verify-{{$worksheet->id}}-link"
                                            href="{{ URL::route('worksheet.viewWorksheetTests', array($worksheet->id)) }}"
                                            title="{{trans('messages.verify-title')}}">
                                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                                {{'view tests'}}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                           
                </tbody>
            </table>

           
        {{ Session::put('SOURCE_URL', URL::full()) }}
        {{ Session::put('TESTS_FILTER_INPUT', Input::except('_token')); }}
        
        </div>
    </div>

    <!-- MODALS -->
    <div class="modal fade" id="new-test-modal">
      <div class="modal-dialog">
        <div class="modal-content">
        {{ Form::open(array('route' => 'test.create')) }}
          <input type="hidden" id="patient_id" name="patient_id" value="0" />
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">{{trans('messages.close')}}</span>
            </button>
            <h4 class="modal-title">{{trans('messages.create-new-test')}}</h4>
          </div>
          <div class="modal-body">
            <h4>{{ trans('messages.first-select-patient') }}</h4>
            <div class="row">
              <div class="col-lg-12">
                <div class="input-group">
                  <input type="text" class="form-control search-text" 
                    placeholder="{{ trans('messages.search-patient-placeholder') }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default search-patient" type="button">
                        {{ trans('messages.patient-search-button') }}</button>
                  </span>
                </div><!-- /input-group -->
                <div class="patient-search-result form-group">
                    <table class="table table-condensed table-striped table-bordered table-hover hide">
                      <thead>
                        <th> </th>
                        <th>{{ trans('messages.patient-id') }}</th>
                        <th>{{ Lang::choice('messages.name',2) }}</th>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                </div>
              </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                {{trans('messages.close')}}</button>
            <button type="button" class="btn btn-primary next" onclick="submit();" disabled>
                {{trans('messages.next')}}</button>
          </div>
        {{ Form::close() }}
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="change-specimen-modal">
      <div class="modal-dialog">
        <div class="modal-content">
        {{ Form::open(array('route' => 'test.updateSpecimenType')) }}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">{{trans('messages.close')}}</span>
            </button>
            <h4 class="modal-title">
                <span class="glyphicon glyphicon-transfer"></span>
                {{trans('messages.change-specimen-title')}}</h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'),
                array('class' => 'btn btn-primary', 'data-dismiss' => 'modal', 'onclick' => 'submit()')) }}
            <button type="button" class="btn btn-default" data-dismiss="modal">
                {{trans('messages.close')}}</button>
          </div>
        {{ Form::close() }}
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal /#change-specimen-modal-->

    <!-- OTHER UI COMPONENTS -->
    <div class="hidden pending-test-not-collected-specimen">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-info'>
                        {{trans('messages.pending')}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-default'>
                        {{trans('messages.specimen-not-collected-label')}}</span>                
                </div>
            </div>
        </div>
    </div> <!-- /. pending-test-not-collected-specimen -->

    <div class="hidden pending-test-accepted-specimen">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-info'>
                        {{trans('messages.pending')}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-success'>
                        {{trans('messages.specimen-accepted-label')}}</span>
                </div>
            </div>
        </div>
    </div> <!-- /. pending-test-accepted-specimen -->

    <div class="hidden started-test-accepted-specimen">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-warning'>
                        {{trans('messages.started')}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-success'>
                        {{trans('messages.specimen-accepted-label')}}</span>
                </div>
            </div>
        </div>
    </div> <!-- /. started-test-accepted-specimen -->

    <div class="hidden accept-button">
        <a class="btn btn-sm btn-info accept-specimen" href="javascript:void(0)"
            title="{{trans('messages.accept-specimen-title')}}"
            data-url="{{ URL::route('test.acceptSpecimen') }}">
            <span class="glyphicon glyphicon-thumbs-up"></span>
            {{trans('messages.accept-specimen')}}
        </a>
    </div> <!-- /. accept-button -->

    <div class="hidden reject-start-buttons">
        <a class="btn btn-sm btn-danger reject-specimen" href="#" title="{{trans('messages.reject-title')}}">
            <span class="glyphicon glyphicon-thumbs-down"></span>
            {{trans('messages.reject')}}</a>
        <a class="btn btn-sm btn-warning start-test" href="javascript:void(0)"
            data-url="{{ URL::route('test.start') }}" title="{{trans('messages.start-test-title')}}">
            <span class="glyphicon glyphicon-play"></span>
            {{trans('messages.start-test')}}</a>
    </div> <!-- /. reject-start-buttons -->

    <div class="hidden enter-result-buttons">
        <a class="btn btn-sm btn-info enter-result">
            <span class="glyphicon glyphicon-pencil"></span>
            {{trans('messages.enter-results')}}</a>
    </div> <!-- /. enter-result-buttons -->

    <div class="hidden start-refer-button">
        <a class="btn btn-sm btn-info refer-button" href="#">
            <span class="glyphicon glyphicon-edit"></span>
            {{trans('messages.refer-sample')}}
        </a>
    </div> <!-- /. referral-button -->
    <?php
        Session::forget('activeTest');
        Session::forget('search_string');
    ?>
@stop
