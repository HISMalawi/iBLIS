<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" type="text/css" href="http://localhost:8001/css/ui-lightness/jquery-ui-min.css" />
      <link rel="stylesheet" type="text/css" href="http://localhost:8001/css/bootstrap.min.css" />
      <link rel="stylesheet" type="text/css" href="http://localhost:8001/css/bootstrap-theme.min.css" />
      <link rel="stylesheet" type="text/css" href="http://localhost:8001/css/dataTables.bootstrap.css" />
      <link rel="stylesheet" type="text/css" href="http://localhost:8001/css/layout.css" />
      <script type="text/javascript" src="http://localhost:8001/js/jquery.js"></script>
      <script type="text/javascript" src="http://localhost:8001/js/jquery-ui-min.js"></script>
      <script type="text/javascript" src="http://localhost:8001/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="http://localhost:8001/js/jquery.dataTables.js"></script>
      <script type="text/javascript" src="http://localhost:8001/js/dataTables.bootstrap.js"></script>
      <script type="text/javascript" src="http://localhost:8001/js/script.js "></script>
      <title>BLIS v2.5</title>
   </head>
   <body>
      <div class="panel panel-primary" id="patientReport" style="border: none; font-size: 1em !important;">
         <div class="panel-heading ">
            <span class="glyphicon glyphicon-user"></span>
            Patient Report
         </div>
         <div class="panel-body">
            <div id="report_content">
              @include("reportHeader")
               <strong>
                  <p>
                    {{trans('messages.patient-report').' - '.date('d-m-Y')}}
                     <b style="padding-left: 10%;"> No. Printed:  {{$printTimes}}</b> 
                     <b style="padding-left: 10%;"> Date Sample Collected: {{$specimen->date_sample_collected}} </b>
                  </p>
               </strong>
               <table class="table table-bordered">
                  <tbody>
                     <tr>
                      <th>{{ trans('messages.patient-name')}}</th>
                      <td>{{ $patient->name }}</td>
                      <th>{{ trans('messages.gender')}}</th>
                      <td>{{ $patient->getGender(false) }}</td>
                      <th>{{ trans('messages.age')}}</th>
                      <td>{{ $patient->getAge("YY/MM")}}</td>
                     </tr>
                     <tr>
                      <th>{{trans('messages.patient-id')}}</th>
                      <td>{{ $patient->external_patient_number }}</td>
                      <th>{{ trans('messages.patient_arv_number')}}</th>
                      <td>{{ $patient_on_art->arv_number }}</td>
                      <th>{{ trans('messages.patient_art_init_date')}}</th>
                      <td>{{ $patient_on_art->art_initiation_date }}</td>
                     </tr>
                     <tr>
                      <th>{{ trans('messages.sending_facility')}}</th>
                      <td>{{ $sending_facility }}</td>
                      <th colspan="2">Physical Address</th>
                      <td colspan="2">{{ $patient->address }}</td>
                     </tr>
                  </tbody>
               </table>
               <div class="panel panel-success">
                  <div class="panel-heading ">
                     <span class="glyphicon glyphicon-tint"></span>
                     <span>
                      <strong>{{Lang::choice('messages.specimen-id', 1)}}</strong>&nbsp;:&nbsp;  
                      <strong> {{ $specimen->accession_number }}</strong>
                    </span>
                     <span class="pull-right"><strong>Requested By </strong>&nbsp;:&nbsp;  
                      <strong> {{ $test->requested_by }}({{$location}})</strong>
                    </span>
                  </div>
                  <div class="panel-body">
                     <table class="table table-bordered rspecimen">
                        <tbody>
                          <tr>
                            <td><strong>{{Lang::choice('messages.specimen-type', 1)}}</strong></td>
                            <td>{{ $specimen->specimenType->name }}</td>
                            <td><strong>{{Lang::choice('messages.date-ordered', 1)}}</strong></td>
                            <td>{{	$test->isExternal()?$test->external()->request_date:$test->time_created }}</td>
                          </tr>
                          <tr>
                            <td><strong>{{Lang::choice('messages.specimen-tests-ordered', 1)}}</strong></td>
                            <td>{{ $specimen->testTypes() }}</td>
                            <td><strong>{{Lang::choice('messages.test-category', 2)}}</strong></td>
                            <td>{{ $specimen->labSections() }}</td>
                          </tr>
                          <tr>
                            <td><strong>{{trans('messages.ordered-specimen-status')}}</strong></td>
                            @if($specimen->specimen_status_id == Specimen::NOT_COLLECTED)
                              <td>{{trans('messages.specimen-not-collected')}}</td>
                            @elseif($specimen->specimen_status_id == Specimen::ACCEPTED)
                              <td>{{trans('messages.specimen-accepted')}}</td>
                            @elseif($specimen->specimen_status_id == Specimen::REJECTED)
                              <td>{{trans('messages.specimen-rejected')}}</td>
                            @endif
                            @if($specimen->specimen_status_id == Specimen::ACCEPTED)
                              <td><strong>{{ trans('messages.collected-by') }}</strong></td>
                            @elseif($specimen->specimen_status_id == Specimen::REJECTED)
                              <td><strong>{{ trans('messages.rejected-by') }}</strong></td>
                            @endif
                            @if($specimen->specimen_status_id == Specimen::NOT_COLLECTED)
                              <td></td>
                            @elseif($specimen->specimen_status_id == Specimen::ACCEPTED)
                              <td>{{$specimen->acceptedBy->name}}</td>
                            @elseif($specimen->specimen_status_id == Specimen::REJECTED)
                              <td>{{$specimen->rejectedBy->name}}</td>
                            @endif
                          </tr>
                        </tbody>
                     </table>
                     <table class="table table-bordered rtest">
                        <tbody>
                              <th>{{Lang::choice('messages.test-type', 1)}}</th>
                              <th>{{trans('messages.test-results')}}</th>
                              <th >{{trans('messages.test-remarks')}}</th>
                              <th>{{" "}} </th>
                            </tr>
                           <tr>
                              <td width="160px">{{ $test->testType->name}}</td>
                              <td width="370px">
                                 <p>
                                  @if (count($test->testResults) > 0)
                                    {{$test->testResults[0]->result}}
                                  @endif
                                 </p>
                              </td>
                              <td width="10px">
                                {{ $test->interpretation == '' ? 'N/A' : $test->interpretation }}
                              </td>
                              <td style="width: 100px;">
                                <b>Test Status </b> <br />
                                @if ($test->test_status->name == "verified")
                                  {{"Authorised"}}
                                @elseif ($test->test_status->name == "completed")
                                  {{"Authorization Pending"}}
                                @else
                                  {{"Testing Pending"}}
                                @endif
                                 <br />
                                 By: {{$test->verifiedBy['name']}}
                                 <br />
                                 On: {{ $test->time_verified }}
                                 <br /> <br /> <br />
                                 <b>Performed By</b> <br />
                                 {{ $test->testedBy['name']}} 
                                <br />
                                 On: {{ $test->time_completed }}
                                 @if($test->resultDevices())
                                <br /><br />
                                <b><i> {{ 'Using:  '.$test->resultDevices() }}</i></b>
                                @endif
                                 <br /><br />
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
   </body>
</html>