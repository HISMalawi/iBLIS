@extends('layout')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/viral-wizard.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/jquery-steps/jquery.steps.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/plugins.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/select2/css/select2.css') }}" />

    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
          <li class="active">{{ "Sample Entry" }}</li>
          <li class="active">{{ "Viral Load" }}</li>
        </ol>
    </div>
    <div class="card">
        <div class="card-body">

        @if (Session::has('message'))
            <div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
        @endif

                    {{-- {{ Form::open(array('route' => array('test.index'), 'method' => 'GET')) }}
                        <div class="row">
                            <div class="form-group col-lg-12" style="margin-bottom: -50px;">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-lg-6 ec">
                                                <label class="mt-2" for="small-barcode-one">Scan Barcode : &nbsp; </label>
                                            <input  type="text" class="form-control bar-item barcode" name="search" id="small-barcode">
    
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    {{ Form::close() }} --}}
            <!--Wizard-->
            <!--  form id="wizard7" class="wizard needs-validation" data-style="1" novalidate action="test.saveNewTest" method="post" -->
            {{ Form::open(array('route' => 'test.createOrderRetrospective',  'method' => 'POST', 'id' => 'wizard7', 'class' => "wizard needs-validation", 'data-style'=>"1",'novalidate')) }}

                <!--Step 1-->
                <!--Step 1-->
                <h3>Health Facility Information</h3>
                <div class="wizard-content">

                    <div class="row">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-10 mb-5">
                              <div class="input-group required text-right">
                                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></span>
                                <input type="text" class="form-control" placeholder="Scan barcode" name="small-barcode" id="small_barcode" aria-describedby="basic-addon1">
                              </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="card">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <strong>Section 1:</strong> Health Facility Information
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-lg-6 ec">
                                            <label for="district">District : &nbsp; </label>
                                            <select  class="form-control required" name="district" id="district">
                                                <option value="" selected="selected">-- Select / Search --</option>
                                                <option value="Lilongwe">Lilongwe</option>
                                            </select>
                                        

                                        </div>

                                        <div class="form-group col-lg-6 ec">
                                            <label for="facility">Facility Name : &nbsp;</label>
                                            <select class="form-control required" name="facility" id="facility">
                                                <option value="" selected="selected">-- Select / Search --</option>
                                                <option value="KCH" >KCH</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div class="card">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <strong>Section 2:</strong> Patient Information
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-lg-6">
                                            <label for="surname">Patient Surname : &nbsp; </label>
                                            <input type="text" class="form-control required" name="surname" id="p_surname">
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="firstname">Patient First Name : &nbsp; </label>
                                            <input type="text" class="form-control required" name="firstname" id="p_first_name">
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group required col-lg-6">
                                            <label for="id">Patient ID : &nbsp; </label>
                                            <div class="row">
                                                <div class="col-md-2" style="margin-left: -1px !important; padding: 0px !important;">
                                                    <input type="text" style="width: 50px;" class="form-control required" name="id" id="p_id">
                                                </div>
                                                <div class="col-md-2 text-center" style="width: 10px;">
                                                    <p class="text-center pt-2">-</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <input style="width: 175px;" type="text" class="form-control required" name="id" id="p_id">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="dob">Date of Birth : &nbsp; </label>
                                            <input type="date" class="form-control required" name="dob" id="p_dob">
                                        </div>
                                    </div>

                                    <fieldset class="row mb-4">
                                        <label class="d-block mb-3" for="dob">Gender / Preg / Bf (tick one) :</label>

                                        <div class="form-check d-block">
                                            <input class="form-check-input required mx-3" type="radio" name="gender"
                                                id="gridRadios1" value="Male">
                                            <label class="form-check-label" for="gridRadios1">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check d-block">
                                            <input class="form-check-input required mx-3" type="radio" name="gender"
                                                id="gridRadios2" value="Female Non-Preg./ Bf.">
                                            <label class="form-check-label" for="gridRadios2">
                                                Female Non-Preg./ Bf.
                                            </label>
                                        </div>

                                        <div class="form-check d-block">
                                            <input class="form-check-input required mx-3" type="radio" name="gender"
                                                id="gridRadios3" value="Female Pregnant">
                                            <label class="form-check-label" for="gridRadios3">
                                                Female Pregnant
                                            </label>
                                        </div>

                                        <div class="form-check d-block">
                                            <input class="form-check-input required mx-3" type="radio" name="gender"
                                                id="gridRadios4" value="Female Breastfeeding">
                                            <label class="form-check-label" for="gridRadios4">
                                                Female Breastfeeding
                                            </label>
                                        </div>

                                    </fieldset>
                                    <?php //var_dump(Input::get('printTracking'));exit; ?>
                                    <div class="row">

                                        <div class="form-group col-lg-6">
                                            <label for="phone">Patient/Guardian Phone Number : &nbsp; </label>
                                            <input type="text" class="form-control required" name="phone" id="p_phone">
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="sample-date">Date Sample Drawn : &nbsp; </label>
                                            <input type="date" class="form-control required" name="sample-date"
                                                id="sample_date">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div>    
                        @if(Input::get('printTracking') != null)
						<div class="">
							<a class="btn btn-sm btn-success"
							   href="{{URL::route('test.print_tracking_number', array(Input::get('printTracking')))}}"
							   data-toggle="modal" >
								<span class="glyphicon glyphicon-print"></span>
								Print Tracking Number
							</a>
						</div>
                        @endif
                    </div> 
                    </div>

                </div>
                <!--end: Step 1-->


                <!--Step 2-->
                <h3>Test Type</h3>
                <div class="wizard-content">

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div class="card">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <strong>Section 3:</strong> Reason for Test
                                    </div>
                                </div>
                                <div class="card-body">
                                    <fieldset class="row mb-4">
                                        <label class="d-block mb-3" for="dob">Select reason :</label>

                                        <div class="form-check d-block">
                                            <input class="form-check-input required mx-3" type="radio" name="reason"
                                                id="gridRadios5" value="Routine">
                                            <label class="form-check-label" for="gridRadios5">
                                                Routine
                                            </label>
                                        </div>
                                        <div class="form-check d-block">
                                            <input class="form-check-input required mx-3" type="radio" name="reason"
                                                id="gridRadios6" value="Targeted">
                                            <label class="form-check-label" for="gridRadios6">
                                                Targeted
                                            </label>
                                        </div>

                                        <div class="form-check d-block">
                                            <input class="form-check-input mx-3 required" type="radio" name="reason"
                                                id="gridRadios7" value="Follow-up after high VL">
                                            <label class="form-check-label" for="gridRadios7">
                                                Follow-up after high VL
                                            </label>
                                        </div>

                                        <div class="form-check d-block">
                                            <input class="form-check-input mx-3 required" type="radio" name="reason"
                                                id="gridRadios8" value="Repeat (reject / lost / missing)">
                                            <label class="form-check-label" for="gridRadios8">
                                                Repeat (reject / lost / missing)
                                            </label>
                                        </div>

                                    </fieldset>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end: Step 2-->


                <!--Step 3-->
                <h3>Patient and Sample Details</h3>
                <div class="wizard-content">

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div class="card">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <strong>Section 4:</strong> Patient and Sample Details
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-lg-6">
                                            <label for="art-init-date">ART Initiation Date : &nbsp; </label>
                                            <input type="date" class="form-control required" name="art-init-date"
                                                id="art-init-date">
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <fieldset class="row mb-4">
                                                <label class="d-block mb-3" for="dob">Sample Type : &nbsp; </label>

                                                <div class="form-check d-block">
                                                    <input class="form-check-input mx-3" type="radio"
                                                        name="sample-type" id="gridRadios9"
                                                        value="DBS (using capillary tube)">
                                                    <label class="form-check-label" for="gridRadios9">
                                                        DBS (using capillary tube)
                                                    </label>
                                                </div>
                                                <div class="form-check d-block">
                                                    <input class="form-check-input mx-3" type="radio"
                                                        name="sample-type" id="gridRadios10" value="Plasma">
                                                    <label class="form-check-label" for="gridRadios10">
                                                        Plasma
                                                    </label>
                                                </div>

                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-lg-6">
                                            <fieldset class="row">
                                                <label class="d-block mb-3">Current ART regimen :</label>
                                                <div class="col cus-col">
                                                    <div class="form-check cus-check purple">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios11" value="0P">
                                                        <label class="form-check-label" for="gridRadios11">
                                                            0P
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check purple">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios12" value="2P">
                                                        <label class="form-check-label" for="gridRadios12">
                                                            2P
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check purple">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios13" value="4P">
                                                        <label class="form-check-label" for="gridRadios13">
                                                            4P
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check purple">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios14" value="9P">
                                                        <label class="form-check-label" for="gridRadios14">
                                                            9P
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check purple">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios15" value="11P">
                                                        <label class="form-check-label" for="gridRadios15">
                                                            11P
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check purple">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios16" value="14P">
                                                        <label class="form-check-label" for="gridRadios16">
                                                            14P
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check purple">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios17" value="15P">
                                                        <label class="form-check-label" for="gridRadios17">
                                                            15P
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check purple">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios18" value="16P">
                                                        <label class="form-check-label" for="gridRadios18">
                                                            16P
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios19" value="0A">
                                                        <label class="form-check-label" for="gridRadios19">
                                                            0A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios20" value="2A">
                                                        <label class="form-check-label" for="gridRadios20">
                                                            2A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios21" value="4A">
                                                        <label class="form-check-label" for="gridRadios21">
                                                            4A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios22" value="5A">
                                                        <label class="form-check-label" for="gridRadios22">
                                                            5A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios23" value="6A">
                                                        <label class="form-check-label" for="gridRadios23">
                                                            6A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios24" value="7A">
                                                        <label class="form-check-label" for="gridRadios24">
                                                            7A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios25" value="8A">
                                                        <label class="form-check-label" for="gridRadios25">
                                                            8A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios26" value="9A">
                                                        <label class="form-check-label" for="gridRadios26">
                                                            9A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios27" value="10P">
                                                        <label class="form-check-label" for="gridRadios27">
                                                            10P
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios28" value="11A">
                                                        <label class="form-check-label" for="gridRadios28">
                                                            11A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios29" value="12A">
                                                        <label class="form-check-label" for="gridRadios29">
                                                            12A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios30" value="13A">
                                                        <label class="form-check-label" for="gridRadios30">
                                                            13A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios31" value="14A">
                                                        <label class="form-check-label" for="gridRadios31">
                                                            14A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios32" value="15A">
                                                        <label class="form-check-label" for="gridRadios32">
                                                            15A
                                                        </label>
                                                    </div>
                                                    <div class="form-check cus-check">
                                                        <input class="form-check-input mx-3" type="radio"
                                                            name="regimen" id="gridRadios33" value="NS">
                                                        <label class="form-check-label" for="gridRadios33">
                                                            NS
                                                        </label>
                                                    </div>
                                                </div>


                                            </fieldset>
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end: Step 3-->


                <!--Step 4-->
                <h3>Details of Person Collecting Sample</h3>
                <div class="wizard-content">

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div class="card">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <strong>Section 5:</strong> Details of Person Collecting Sample
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-lg-6">
                                            <label for="surname">Surname : &nbsp; </label>
                                            <input type="text" class="form-control required" name="pcs-surname"
                                                id="pcs-surname">
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="firstname">First Name : &nbsp; </label>
                                            <input type="text" class="form-control required" name="pcs-firstname"
                                                id="pcs-firstname">
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-lg-6">
                                            <label for="phone">Phone Number : &nbsp; </label>
                                            <input type="text" class="form-control required" name="pcs-phone" id="pcs-phone">
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="id">HTC Provider ID : &nbsp; </label>
                                            <input type="text" class="form-control required" name="htc-provider-id"
                                                id="htc-provider-id">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end: Step 4-->


                <!--Step 5-->
                <!-- Confirmation section -->
                <h3>Confirmation</h3>
                <div class="wizard-content">
                    
                    <div class="row">
                        <div class="col-md-2 col-md-offset-10 mb-5">
                            <div class="input-group required text-right">
                              <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></span>
                              <input type="text" class="form-control" placeholder="Scan barcode" name="small-barcode" id="small_barcode" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="input-group" style="width: 300px; justify-self:end;">
                            
                        </div>
                    </div>
    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><strong>Confirmation</strong></h4>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-info" role="alert">
                                Please make sure you have entered the correct informationas their appear on the <strong>EID & Viral Load Request Form</strong>
                            </div>
                        </div>
                        
                    </div>
    
                    <div>
                        <div class="wizard-content mt-5">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                  <h3 class="panel-title"><strong>Section 1: Health Facility Information</strong></h3>
                                </div>
                                <div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><label for="district">District : &nbsp; </label>
                                            <p id="confi-district-name">--</p>
                                        </li>
                                        <li class="list-group-item"><label for="facility">Facility Name : &nbsp; </label>
                                            <p id="confi-facility-name">--</p>
                                        </li>
    
                                    </ul>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                  <h3 class="panel-title"><strong>Section 2: Patient Information </strong></h3>
                                </div>
                                <div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><label for="surname">Patient Surname : &nbsp; </label>
                                            <p id="confi-patient-surname">--</p>
                                        </li>
                                        <li class="list-group-item"><label for="firstname">Patient First Name : &nbsp;
                                            </label>
                                            <p id="confi-patient-firstname">--</p>
                                        </li>
                                        <li class="list-group-item"><label for="id">Patient ID : &nbsp; </label>
                                            <p id="confi-patient-id">--</p>
                                        </li>
                                        <li class="list-group-item"><label for="dob">Date of Birth : &nbsp; </label>
                                            <p id="confi-patient-dob">--</p>
                                        </li>
                                        <li class="list-group-item"><label for="id">Gender / Preg / Bf : &nbsp; </label>
                                            <p id="confi-patient-gender">--</p>
                                        </li>
                                        <li class="list-group-item"><label for="id">Date Sample Drawn : &nbsp; </label>
                                            <p id="confi-sample-date">--</p>
                                        </li>
                                        <li class="list-group-item"><label for="id">Patient/Guardian Phone Number :
                                                &nbsp; </label>
                                            <p id="confi-patient-phone">--</p>
                                        </li>
    
                                    </ul>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                  <h3 class="panel-title"><strong>Section 3: Test Type</strong></h3>
                                </div>
                                <div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><label for="id">Reason : &nbsp; </label>
                                            <p id="confi-test-reason">--</p>
                                        </li>
    
                                    </ul>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                  <h3 class="panel-title"><strong>Section 4: Specimen Information for Early Infant Diagnosis ONLY</strong></h3>
                                </div>
                                <div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><label for="district">District : &nbsp; </label>
                                            <p id="confi-district-name">--</p>
                                        </li>
                                        <li class="list-group-item"><label for="facility">Facility Name : &nbsp; </label>
                                            <p id="confi-facility-name">--</p>
                                        </li>
    
                                    </ul>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                  <h3 class="panel-title"><strong>Section 5: Patient and Sample Details for Viral Load ONLY</strong></h3>
                                </div>
                                <div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><label for="id">ART Initiation Date : &nbsp;
                                            </label>
                                            <p id="confi-art-init-date">--</p>
                                        </li>
                                        <li class="list-group-item"><label for="id">Sample Type : &nbsp; </label>
                                            <p id="confi-sample-type">--</p>
                                        </li>
    
                                        <li class="list-group-item"><label for="id">Current ART Regimen : &nbsp;
                                            </label>
                                            <p id="confi-curr-art-regimen">--</p>
                                        </li>
                                        <li class="list-group-item">
                                        </li>
    
                                    </ul>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                  <h3 class="panel-title"><strong>Section 6: Details of Person Collecting Sample</strong></h3>
                                </div>
                                <div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><label for="surname">Surname : &nbsp; </label>
                                            <p id="confi-pcs-surname">--</p>
                                        </li>
    
                                        <li class="list-group-item"><label for="firstname">First Name : &nbsp; </label>
                                            <p id="confi-pcs-firstname">--</p>
                                        </li>
    
                                        <li class="list-group-item"><label for="phone">Phone Number : &nbsp; </label>
                                            <p id="confi-pcs-phone">--</p>
                                        </li>
    
                                        <li class="list-group-item"><label for="id">HTC Provider ID : &nbsp; </label>
                                            <p id="confi-htc-provider-id">--</p>
                                        </li>
    
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--end: Step 5-->
            
			{{ Form::close() }}
            <!-- /form -->
            <!--end:Wizard-->
            <style>
                .wizard > .steps > ul > li {
                    display: none;
                }
            </style>
        </div>
    </div>

    <script src="{{ URL::asset('plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/validate/validate.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/select2/js/select2.js') }}"></script>
    <script>
        //Advanced - with validation
        var wizard7 = $('#wizard7');
        wizard7.steps({
            headerTag: "h3",
            bodyTag: '.wizard-content',
            autoFocus: true,
            enableAllSteps: true,
            titleTemplate: '<span class="number">#index#</span><span class="title">#title#</span>',
            onStepChanging: function(event, currentIndex, newIndex) {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }

                wizard7.validate().settings.ignore = ":disabled,:hidden";
                return wizard7.valid();
            },
            onStepChanged: function(event, currentIndex, priorIndex) {

                if (currentIndex == 4 || currentIndex == 5) {

                    var district = $('#district').val();
                    var facility = $('#facility').val();

                    var p_surname = $('#p_surname').val();
                    var p_first_name = $('#p_first_name').val();

                    var p_id = $('#p_id').val();
                    var p_dob = $('#p_dob').val();

                    var p_gender = $("input[name='gender']:checked").val();

                    var p_phone = $('#p_phone').val();
                    var sample_date = $('#sample_date').val();

                    var test_reason = $("input[name='reason']:checked").val();

                    var art_init_date = $('#art-init-date').val();
                    var sample_type = $("input[name='sample-type']:checked").val();

                    var current_art_regimen = $("input[name='regimen']:checked").val();

                    var pcs_surname = $('#pcs-surname').val();
                    var pcs_firstname = $('#pcs-firstname').val();
                    var pcs_phone = $('#pcs-phone').val();
                    var htc_provider_id = $('#htc-provider-id').val();

                    $('#confi-district-name').text(district);
                    $('#confi-facility-name').text(facility);

                    $('#confi-patient-surname').text(p_surname);
                    $('#confi-patient-firstname').text(p_first_name);

                    $('#confi-patient-id').text(p_id);
                    $('#confi-patient-dob').text(p_dob);

                    $('#confi-patient-gender').text(p_gender);

                    $('#confi-patient-phone').text(p_phone);
                    $('#confi-sample-date').text(sample_date);

                    $('#confi-test-reason').text(test_reason);

                    $('#confi-art-init-date').text(art_init_date);
                    $('#confi-sample-type').text(sample_type);

                    $('#confi-curr-art-regimen').text(current_art_regimen);
                    $('#confi-pcs-surname').text(pcs_surname);
                    $('#confi-pcs-firstname').text(pcs_firstname);
                    $('#confi-pcs-phone').text(pcs_phone);
                    $('#confi-htc-provider-id').text(htc_provider_id);

                }
            },
            onFinishing: function(event, currentIndex) {
                return wizard7.valid();            
            },
            onCanceled: function(event, currentIndex){
                console.log("Cancel");
            },
            onReject: function(event, currentIndex){
                console.log("Cancel1");
                document.getElementById('action_checker').value = "rejected";
                $('#wizard7').submit();   
            },
            onFinished: function(event, currentIndex) {
                console.log("done");
                document.getElementById('action_checker').value = "accepted";
                $('#wizard7').submit();                
            }
        });

        // Validation
        wizard7.validate({
            errorClass: 'is-invalid text-danger mt-2',
            validClass: 'is-valid',
            errorElement: "div",
            ignore: ":hidden",
            rules: {
                // Step 1 - Account information
                username: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    minlength: 8
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength: 12
                },
                password2: {
                    required: true,
                    minlength: 5,
                    maxlength: 12
                },
                // Step 4 - Confirmation
                reminders: {
                    required: true
                },
                terms_conditions: {
                    required: true
                },
            },
            errorPlacement: function(error, element) {
                $(element).parents(".form-group").append(error);
            }
        });
        $('.wizard').find(".actions ul > li > a").addClass("btn bg-primary");
        
        $('.wizard').find(".actions ul > li:nth-child(3) > a").addClass("btn bg-danger");

        $('.wizard').find(".actions ul > li:nth-child(4) > a").addClass("btn bg-success");
    </script>
    <script>
        $(document).ready(function() {

            var data = [
                {
                    id: 0,
                    text: 'enhancement'
                },
                {
                    id: 1,
                    text: 'bug'
                },
                {
                    id: 2,
                    text: 'duplicate'
                },
                {
                    id: 3,
                    text: 'invalid'
                },
                {
                    id: 4,
                    text: 'wontfix'
                }
            ];

            $('.district-select').select2({
                theme: 'bootstrap4',
                data: data,
            });

            $('.facility-select').select2({
                theme: 'bootstrap4',
                data: data,
            });
        });
    </script>
@stop
