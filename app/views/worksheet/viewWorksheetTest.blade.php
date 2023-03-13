@extends("layout")
@section("content")
    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
          <li class="active">{{ "Worksheets" }}</li>
          <li class="active">{{ "Tests" }}</li>
        </ol>
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
    @endif

    <div class='container-fluid'>
        {{ Form::open(array('route' => array('test.index'), 'method' => 'GET')) }}
            <div class='row'>
               
                <div class='col-md-9'>
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
                        <span class="glyphicon glyphicon-filter"></span>{{"Tests For Worksheet No: $worksheetNumber"}}
                      

                                @if(isset($worksheet->verified_at))
                                    {{ Form::open(array('url' => 'vlprint/eid_vl_results/'.$worksheet->id, 'class' => 'pull-right', 'id'=>'form-vlpatientreport-filter', 'method'=>'POST')) }}
                                    {{ Form::hidden('printer_name', '', array('id' => 'printer_name')) }}
                              
                                    <button type="button" style="margin-top:1.5%;" class="btn btn-sm btn-default" onclick="selectPrinter()"/>
                                                    <span class="glyphicon glyphicon-print">Print results</span>
                                                </button>
                                    {{Form::close()}}
                                @endif

                                <a class="pull-right btn btn-sm btn-success start-test" 
                                        href="javascript:void(0)" 
                                        data-test-id="{{$worksheetNumber}}" data-url="{{ URL::route('worksheet.worksheetVerified') }}"
                                        title="{{trans('messages.start-test-title')}}"
                                        onClick="window.location.reload()"
                                        style="margin-right:1.5%"
                                        >
                                        
                                        <span class="glyphicon glyphicon-thumbs-up"></span>
                                        {{"Verify Worksheet"}}
                                </a>                       
                           
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
                        <th class="col-md-1" style="width: 13.5% !important;"> {{"Tracking Number."}}</th>
                        <th class="col-md-1"> {{"Patient Name."}}</th>
                        <th class="col-md-1" >{{"Arv Number"}}</th>
                        <th class="col-md-1" >{{"Test Type"}}</th>
                        <th class="col-md-1">{{"Specimen Type"}}</th>
                        <th class="col-md-1">{{"Date Created"}}</th>
                        <th class="col-md-1">{{"Sending Facility"}}</th>
                        <th class="col-md-1">{{"Test Status"}}</th>
                        <th class="col-md-1">{{"Test Result"}}</th>
                        <th class="col-md-4">{{trans('messages.actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tests as $test)
                        <?php 
                            $sending_facility = $test->sending_facility;
                            
                            if(is_numeric($sending_facility) == true){                                
                                $rs = DB::SELECT("SELECT * FROM facilities WHERE id='$sending_facility'");                                
                                if(count($rs) > 0){
                                    $sending_facility = $rs[0]->name;
                                }
                            }
                            $testStatus = TestStatus::find($test->testStatus)->name;                           
                        ?>

                        <tr>    
                            <td> {{$test->trackingNumber}}</td>
                            <td> {{$test->name}}</td>
                            <td> {{$test->arv_number}}</td>                        
                            <td> {{$test->test_type}}</td>                            
                            <td> {{$test->specimen_type}}</td>
                            <td> {{$test->time_created}}</td>
                            <td> {{$sending_facility}}</td>
                            <td> {{$testStatus }}</td>
                            <td> {{$test->result}}</td>
                            <td>
                               
                            @if($test->result != "collect new sample")
                             
                                <a class="{{(!$test->tstID) ? 'main-view main-view-'.$test->tstID : ''}}  btn btn-sm btn-danger start-test" 
                                        href="javascript:void(0)" 
                                        data-test-id="{{$test->tstID}}" data-url="{{ URL::route('worksheet.rerunTest') }}"
                                        title="{{trans('messages.start-test-title')}}"
                                        onClick="window.location.reload()"
                                        >
                                        <span class="glyphicon glyphicon-thumbs-down"></span>
                                        {{'re-run test'}}
                                </a>
                            @endif
                            @if($test->result != "collect new sample")
                               
                                <a class="btn btn-sm btn-warning" id="reject-{{1}}-link"
                                    href="{{URL::route('worksheet.collectNewSample', array($test->specimenID))}}"
                                    title="{{trans('messages.reject-title')}}">
                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                    {{'collect new sample'}}
                                </a>
                            @endif
                                

                            </td>
                        </tr>
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
<div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">

		<!-- - content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel" style="text-align: left;">
					Select Printer
				</h4>
			</div>
			<div class="modal-body">
        <span style="text-align:center;">
          <table align="center" id="printers">
			   @foreach($available_printers AS $printer)
			  <tr onmousedown="updateValue(this)" value="{{$printer}}">
				  <td><input type="radio" class="printer_radio_button" value="{{$printer}}" name="printer_name"/></td>
				  <td style="text-align: left; padding-left:50px;">{{$printer}}</td>
			  </tr>
			  @endforeach
		  </table>
        </span>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" 
						onclick="submitVlPrintForm()">Okay</button>
					<button type="button" class="btn" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
