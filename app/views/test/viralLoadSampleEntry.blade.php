@extends('layout')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/viral-wizard.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/jquery-steps/jquery.steps.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/plugins.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/select2/css/select2.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datepicker.css') }}" />

    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
          <li class="active">{{ "Sample Registration" }}</li>
          <li class="active">{{ "Viral Load" }}</li>
        </ol>
    </div>
    <div class="container-fluid">
        <div class="row no-gutters">					
            <div class="">
    <div>
        <div class="card-body">

        @if (Session::has('message'))
            <div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
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
        @endif


            {{ Form::open(array('route' => array('test.viralLoadSampleEntry'), 'method' => 'GET', 'id' => 'barcodeForm', 'class' => 'hidden')) }}
                <div class="row">
                    <div class="form-group col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-6 ec">
                                        {{-- <label class="mt-2" for="small-barcode-one">Scan Barcode : &nbsp; </label> --}}
                                        <input type="search" class=" form-control bar-item barcode" name="search" id="small-barcode">
                                        
                                    </div>
                                </div>
                                
                            
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            {{ Form::close() }}
           
            <!--  form id="wizard7" class="wizard needs-validation" data-style="1" novalidate action="test.saveNewTest" method="post" -->
            {{ Form::open(array('route' => 'test.createOrderRetrospective',  'method' => 'POST', 'id' => 'wizard7', 'class' => "wizard needs-validation", 'data-style'=>"1",'novalidate')) }}

                <!--Step 1-->
                <!--Step 1-->
                <h3>Health Facility Information</h3>
                <div class="wizard-content">

                    <div class="row">
                        <div class="col-md-3 col-md-offset-9 mb-5">
                            <div class="input-group text-right">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></span>
                              <input class="form-control bar-item barcode_" type="text" type="search" class="form-control" placeholder="Scan tracking number" name="barcode" id="barcode" aria-describedby="basic-addon1">
                            </div>
                          </div>
                        <div class="form-group col-lg-12">
                            <div class="card">
                                <div class="panel panel-default panel-info">
                                    <div class="panel-heading">
                                        <strong>Section 1:</strong> Health Facility Information
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6 ec">
                                            <label for="district">District : &nbsp; </label>
                                            <select  class="form-control required district-select" style="float: none;" name="district" id="district">
                                                <option value="">-- Select district ---</option>
                                                @foreach ($districts as $district)
                                                <option value="{{$district->name}}">{{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        
                                            <div style="text-align: center; margin-left: -35px;" id="district-error"></div>

                                        </div>

                                        <div class="form-group col-lg-6 ec">
                                            <label for="facility">Facility Name : &nbsp;</label>
                                            <select  class="form-control required facility-select" style="float: none;" name="facility" id="facility">
                                                <option value="">-- Select facility ---</option>
                                                @foreach ($facilities as $facility)
                                                <option value="{{$facility->name}}">{{ $facility->name }}</option>
                                                @endforeach
                                            </select>
                                            <div style="text-align: center; margin-left: -35px;" id="facility-error"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div class="card">
                                <div class="panel panel-default panel-info">
                                    <div class="panel-heading">
                                        <strong>Section 2:</strong> Patient Information
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-lg-6">
                                            <label for="surname">Patient Surname : &nbsp; </label>
                                            <input type="text" style="float: none;" class="form-control" name="surname" id="p_surname">
                                            <div style="text-align: center; margin-left: -35px;" id="surname-error"></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="firstname">Patient First Name : &nbsp; </label>
                                            <input type="text" style="float: none;" class="form-control" name="firstname" id="p_first_name">
                                            <div style="text-align: center; margin-left: -35px;" id="firstname-error"></div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-lg-6"> 
                                          
                                            <label for="id">Patient ID : &nbsp; </label>                                                    
                                            <input style="float: none;"  type="text" class="form-control" name="id" id="p_id">
                                            <div style="text-align: center; margin-left: -80px !important;" id="id-error"></div>
                                        </div>

                                        <div class="col-lg-6">
                                            <label for="dob">Date of Birth : &nbsp; </label>
                                            <div class="input-group text-right date" style="margin-left: 200px;">
                                                <input style="" placeholder="yyyy/mm/dd" type="text" type="search" class="form-control" id="dob" name="dob">
                                            </div>
                                            <div style="text-align: left; margin-left: 200px !important;" id="dob-error"></div>
                                        </div>

                                    </div>

                                    <fieldset class="row mb-4">
                                        <label class="d-block mb-3" for="dob">Gender / Preg / Bf (tick one) :</label>
                                            
                                            <div class="form-check d-block">
                                                <input class="form-check-input mx-3" type="radio" name="gender"
                                                    id="gridRadios1" value="Male">
                                                <label class="form-check-label" for="gridRadios1">
                                                    Male
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input mx-3" type="radio" name="gender"
                                                    id="gridRadios2" value="Female Non-Preg./ Bf.">
                                                <label class="form-check-label" for="gridRadios2">
                                                    Female Non-Preg./ Bf.
                                                </label>
                                            </div>

                                            <div class="form-check d-block">
                                                <input class="form-check-input mx-3" type="radio" name="gender"
                                                    id="gridRadios3" value="Female Pregnant">
                                                <label class="form-check-label" for="gridRadios3">
                                                    Female Pregnant
                                                </label>
                                            </div>

                                            <div class="form-check d-block">
                                                <input class="form-check-input mx-3" type="radio" name="gender"
                                                    id="gridRadios4" value="Female Breastfeeding">
                                                <label class="form-check-label" for="gridRadios4">
                                                    Female Breastfeeding
                                                </label>
                                            </div>

                                            <div style="text-align: left; margin-left: 0px;" id="gender-error"></div>
                                    </fieldset>
                                    
                                    <?php //var_dump(Input::get('printTracking'));exit; ?>
                                    <div class="row">

                                        <div class="form-group col-lg-6">
                                            <label for="phone">Patient/Guardian Phone Number : &nbsp; </label>
                                            <input type="text" minlength="10" style="float: none;" class="form-control" name="phone" id="p_phone">
                                            <div id="phone-error"></div>
                                        </div>

                                        <div class="col-lg-6">
                                            <label for="dob">Date Sample Drawn : &nbsp; </label>
                                            <div class="input-group text-right date" id='sample-drawn-date' style="margin-left: 200px;">
                                                <input type='text' placeholder="yyyy/mm/dd" class="form-control" id="sample_date" name="sampledate" aria-describedby="sample-drawn-addon" />
                                            </div>
                                            <div style="text-align: left; margin-left: 200px !important;" id="sample-date-error"></div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div>    
                        
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
                                <div class="panel panel-default panel-info">
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

                                        <div id="reason-error"></div>

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
                                <div class="panel panel-default panel-info">
                                    <div class="panel-heading">
                                        <strong>Section 4:</strong> Patient and Sample Details
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <label for="dob">ART Initiation Date : &nbsp; </label>
                                            <div class="input-group text-right date" id='sample-drawn-date' style="margin-left: 200px;">
                                                <input type='text' placeholder="yyyy/mm/dd" class="form-control" name="artinitdate"
                                                id="artinitdate" aria-describedby="sample-drawn-addon" />
                                            </div>
                                            <div style="text-align: left;" id="art-init-error"></div>
                                        </div>

                                        <div class="form-group  col-lg-6">
                                            <fieldset class="row mb-4">
                                                <label class="d-block mb-3" for="dob">Sample Type : &nbsp; </label>

                                                <div class="form-check d-block">
                                                    <input class="form-check-input mx-3" type="radio"
                                                        name="sampletype" id="gridRadios9"
                                                        value="DBS (using capillary tube)">
                                                    <label class="form-check-label" for="gridRadios9">
                                                        DBS (using capillary tube)
                                                    </label>
                                                </div>
                                                <div class="form-check d-block">
                                                    <input class="form-check-input mx-3" type="radio"
                                                        name="sampletype" id="gridRadios10" value="Plasma">
                                                    <label class="form-check-label" for="gridRadios10">
                                                        Plasma
                                                    </label>
                                                </div>

                                            </fieldset>
                                            <div style="text-align: left;" id="sample-type-error"></div>
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

                                            <div style="text-align: left;" id="regimen-error"></div>
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
                                <div class="panel panel-default panel-info">
                                    <div class="panel-heading">
                                        <strong>Section 5:</strong> Details of Person Collecting Sample
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="surname">Surname : &nbsp; </label>
                                                <div>
                                                    <input style="float: none;" type="text" class="form-control" name="pcssurname" id="pcs-surname">
                                                    <div style="text-align: left;" id="pcssurname-error"></div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="firstname">First Name : &nbsp; </label>
                                                <input type="text" class="form-control" name="pcsfirstname"
                                                    id="pcs-firstname">
                                            </div>
                                            <div style="text-align: left;" id="pcsfirstname-error"></div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="phone">Phone Number : &nbsp; </label>
                                                <input type="text" minlength="10" class="form-control" name="pcsphone" id="pcs-phone">
                                            </div>
                                            <div style="text-align: left;" id="pcsphone-error"></div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="id">HTC Provider ID : &nbsp; </label>
                                                <input type="text" class="form-control" name="htcproviderid"
                                                    id="htc-provider-id">
                                            </div>
                                            <div style="text-align: left;" id="htcproviderid-error"></div>
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
                            <div class="col-md-3 col-md-offset-9 mb-3">
                                <div class="input-group required text-right">
                                  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></span>
                                  <input class="form-control bar-item barcode_" type="text" type="search" class="form-control" placeholder="Scan barcode" name="small-barcode" id="small-barcode" aria-describedby="basic-addon1">
                                </div>
                              </div>
                        </div>
                        <div class="mt-1">
                            <div class="panel panel-info">
                                
                                <div class="panel panel-heading">
                                  <strong>Confirmation: </strong>Please make sure you have entered the correct information as they appear on the EID & Viral Load Requisition Form
                                </div>

                                <!-- Section 2 confirmation -->

                                <div style="margin-top: -20px;">
                                    <div style="background-color: #ececec !important; padding: 5px !important;">
                                        <strong>Section 1: Health Facility Information</strong>
                                    </div>
    
                                    <div>
                                        <div class="row">
                                            <div class="col-md-4 custom-padding" style="margin-left: 20px !important; margin-bottom: 0px !important;">
                                                <div class="mt-1">
                                                    <label for="surname">District : &nbsp; </label>
                                                    <p id="confi-district-name">--</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 custom-padding">
                                                <div class="mt-1">
                                                    <label for="firstname">Facility : &nbsp;
                                                    </label>
                                                    <p id="confi-facility-name">--</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2 confirmation -->

                                <div>
                                    <div style="background-color: #ececec !important; padding: 5px !important;">
                                        <strong>Section 2: Patient Information</strong>
                                    </div>
    
                                    <div>
                                        <div class="row " style="padding: 20px;">
                                            <div class="col-md-4">
                                                <label for="surname">Patient Surname : &nbsp; </label>
                                                <p id="confi-patient-surname">--</p>
                                            </div>

                                            <div class="col-md-4 pb-3">
                                                <label for="firstname">Patient First Name : &nbsp;
                                                </label>
                                                <p id="confi-patient-firstname">--</p>
                                            </div>

                                            <div class="col-md-4" >
                                                <label for="id">Patient ID : &nbsp; </label>
                                                <p id="confi-patient-id">--</p>
                                            </div>

                                            <div class="col-md-4 pt-3">
                                                <label for="dob">Date of Birth : &nbsp; </label>
                                                <p id="confi-patient-dob">--</p>
                                            </div>

                                            <div class="col-md-4 pt-3" >
                                                <label for="id">Gender / Preg / Bf : &nbsp; </label>
                                                <p id="confi-patient-gender">--</p>
                                            </div>

                                            <div class="col-md-4 pt-3">
                                                <label for="id">Date Sample Drawn : &nbsp; </label>
                                                <p id="confi-sample-date">--</p>
                                            </div>
                                            
                                            <div class="col-md-4 pt-3" >
                                                <label for="id">Patient/Guardian Phone Number : &nbsp; </label>
                                                <p id="confi-patient-phone">--</p>
                                            </div>
                                            
        
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 3 confirmation -->

                                <div>
                                    <div style="background-color: #ececec !important; padding: 5px !important;">
                                        <strong>Section 3: Test Type</strong>
                                    </div>
    
                                    <div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><label for="surname">Reason : &nbsp; </label>
                                                <p id="confi-test-reason">--</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Section 4 confirmation -->

                                <div>
                                    <div style="background-color: #ececec !important; padding: 5px !important;">
                                        <strong>Section 4: Patient and Sample Details for Viral Load ONLY</strong>
                                    </div>
    
                                    <div class="row" style="padding-left: 20px;">
                                        <div class="col-md-4 custom-padding" >
                                            <div class="mt-1"><label for="id">ART Initiation Date : &nbsp; </label>
                                                <p id="confi-art-init-date">--</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 custom-padding" >
                                            <div class="mt-1"><label for="id">Sample Type : &nbsp; </label>
                                                <p id="confi-sample-type">--</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 custom-padding" >
                                            <div class="mt-1"><label for="id">Current ART Regimen : &nbsp; </label>
                                                <p id="confi-curr-art-regimen">--</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 5 confirmation -->
                                <div>
                                    <div style="background-color: #ececec !important; padding: 5px !important;">
                                        <strong>Section 5: Details of Person Collecting Sample</strong>
                                    </div>

                                    <div class="row" style="padding-left: 20px;">
                                        <div class="col-md-3 custom-padding" >
                                            <div class="mt-1"><label for="id">Surname : &nbsp; </label>
                                                <p id="confi-pcs-surname">--</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 custom-padding" >
                                            <div class="mt-1"><label for="id">First name : &nbsp; </label>
                                                <p id="confi-pcs-firstname">--</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 custom-padding" >
                                            <div class="mt-1"><label for="id">Phone number : &nbsp; </label>
                                                <p id="confi-pcs-phone">--</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 custom-padding" >
                                            <div class="mt-1"><label for="id">HTC Provider ID : &nbsp; </label>
                                                <p id="confi-htc-provider-id">--</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <input type="text" hidden  id="action_checker" name="checker">
                                <input type="text" hidden  id="action_checker" name="test_type" value="Viral Load">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                  Session::flash('message', null);  
                ?>
            </div>
        </div>
    </div> 
    </div></div>
    <script src="{{ URL::asset('plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/validate/validate.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/select2/js/select2.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.js') }} "></script>
    <script>

        $(document).ready(function() {

            $('#dob').datepicker({
                format: 'yyyy/mm/dd',
                endDate: new Date(),
                autoclose: true,
                todayHighlight: true
            }).on('change', function(e) {
                $('#sample_date').datepicker('setStartDate', $('#dob').val());
                $('#artinitdate').datepicker('setStartDate', $('#dob').val());
            });

            $('#sample_date').datepicker({
                format: 'yyyy/mm/dd',
                startDate: new Date(),
                endDate: new Date(),
                autoclose: true,
                todayHighlight: true
            })
            
            $('#artinitdate').datepicker({
                format: 'yyyy/mm/dd',
                endDate: new Date(),
                autoclose: true,
                todayHighlight: true
            });

            $('#barcode').keyup(function() {
                var value = $(this).val();

                $('#small-barcode').val(value);

            });


        });

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

                // return true;
            },
            onInit: function (event, currentIndex) {
                // If current step is the first step
                if (currentIndex === 0) {
                    // Hide previous button
                    $('.wizard').find(".actions ul > li:nth-child(1) > a").hide();
                }
            },
            onStepChanged: function(event, currentIndex, priorIndex) {
                if (currentIndex === 0) {
                    // Hide previous button
                    $('.wizard').find(".actions ul > li:nth-child(1) > a").hide();
                } else {
                    // Show previous button
                    $('.wizard').find(".actions ul > li:nth-child(1) > a").addClass("btn btn-primary previous-btn").show();

                    $('.wizard').find(".actions ul > li:nth-child(1)").addClass(" actions-container");
                }
                
                if (currentIndex == 4 || currentIndex == 5) {

                    var district = $('#district').val();
                    var facility = $('#facility').val();

                    var p_surname = $('#p_surname').val();
                    var p_first_name = $('#p_first_name').val();

                    var side_code = $('#side_code').val();
                    var p_id = $('#p_id').val();
                    var p_dob = $('#dob').val();

                    var p_gender = $("input[name='gender']:checked").val();

                    var p_phone = $('#p_phone').val();
                    var sample_date = $('#sample_date').val();

                    var test_reason = $("input[name='reason']:checked").val();

                    var art_init_date = $('#artinitdate').val();
                    var sample_type = $("input[name='sampletype']:checked").val();

                    var current_art_regimen = $("input[name='regimen']:checked").val();

                    var pcs_surname = $('#pcs-surname').val();
                    var pcs_firstname = $('#pcs-firstname').val();
                    var pcs_phone = $('#pcs-phone').val();
                    var htc_provider_id = $('#htc-provider-id').val();

                    $('#confi-district-name').text(district);
                    $('#confi-facility-name').text(facility);

                    $('#confi-patient-surname').text(p_surname);
                    $('#confi-patient-firstname').text(p_first_name);

                    $("#confi-side-code").text(side_code)
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
            errorClass: 'error-class text-danger mt-2',
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
                // Step 1
                district: {
                    required: true
                },
                facility: {
                    required: true
                },
                firstname: {
                    required: true
                },
                surname: {
                    required: true
                },
                id: {
                    required: true
                },
                dob: {
                    required: true
                },
                gender: {
                    required: true
                },
                sampledate: {
                    required: true
                },
                // Step 3 
                reason: {
                    required: true
                },
                // Step 4
                regimen: {
                    required: true
                },
                artinitdate: {
                    required: true
                },
                sampletype: {
                    required: true
                },
                // Step 5
                pcsfirstname: {
                    required: true
                },
                pcssurname: {
                    required: true
                },
                pcsphone: {
                    required: true,
                    maxlength: 10,
                },
                htcproviderid: {
                    required: true
                }
            },
            messages: { 
                barcode: "Please scan the form barcode", 
                facility: "Please select a facility", 
                district: "Please select a district",
                firstname: "Enter patient first name",
                surname: "Enter patient surname",
                id: "Enter patient ID",
                dob: "Please select patient date of birth",
                gender: "Please select patient gender",
                sampledate: "Please select the date when the sample was taken",
                reason: "Select reason for this test",
                regimen: "Please select the ART Regimen",
                artinitdate: "Please the date of art start",
                sampletype: "Please select the sample type",
                pcsfirstname: "Please enter sample collector first name",
                pcssurname: "Please enter sample collector last name",
                pcsphone: "Please sample collector phone number",
                htcproviderid: "Please enter the HTC provider id"
            }, 

            errorPlacement: function(error, element) {
                
                if (element.attr("name") === "barcode") {
                    error.appendTo("#barcode-error");
                } else if (element.attr("name") === "district") {
                    error.appendTo("#district-error");
                }
                else if (element.attr("name") === "facility") {
                    error.appendTo("#facility-error");
                }

                else if (element.attr("name") === "surname") {
                    error.appendTo("#surname-error");
                }
                else if (element.attr("name") === "firstname") {
                    error.appendTo("#firstname-error");
                }
                else if (element.attr("name") === "id") {
                    error.appendTo("#id-error");
                }
                else if (element.attr("name") === "dob") {
                    error.appendTo("#dob-error");
                }
                else if (element.attr("name") === "gender") {
                    error.appendTo("#gender-error");
                }
                else if (element.attr("name") === "phone") {
                    error.appendTo("#phone-error");
                }
                else if (element.attr("name") === "sampledate") {
                    error.appendTo("#sample-date-error");
                }

                else if (element.attr("name") === "reason") {
                    error.appendTo("#reason-error");
                }

                else if (element.attr("name") === "sampletype") {
                    error.appendTo("#sample-type-error");
                }
                else if (element.attr("name") === "regimen") {
                    error.appendTo("#regimen-error");
                }
                else if (element.attr("name") === "artinitdate") {
                    error.appendTo("#art-init-error");
                }

                else if (element.attr("name") === "pcsfirstname") {
                    error.appendTo("#pcsfirstname-error");
                }
                else if (element.attr("name") === "pcssurname") {
                    error.appendTo("#pcssurname-error");
                }
                else if (element.attr("name") === "pcsphone") {
                    error.appendTo("#pcsphone-error");
                }
                else if (element.attr("name") === "htcproviderid") {
                    error.appendTo("#htcproviderid-error");
                }

                else {
                    error.insertAfter(element);
                }
            }    
        });

        $('.wizard').find(".actions ul > li:nth-child(2) > a").addClass("btn btn-primary");
        
        $('.wizard').find(".actions ul > li:nth-child(3) > a").addClass("btn btn-danger");

        $('.wizard').find(".actions ul > li:nth-child(4) > a").addClass("btn btn-success");

    </script>
    
    <script>

        $(document).ready(function() {

            $('.facility-select').select2({
                theme: 'bootstrap4',
            });

            $($('.facility-select').data('select2').$container).addClass('form-control')

            $('.district-select').on('change', function() {
                
                $.ajax({
                    url: `/filter-facilities/${$('.district-select').val()}`,
                    async: true,
                    type: 'GET',
                    success: function (response) {
                        var select2 = $('.facility-select');
                        select2.empty();
                        select2.append('<option value="">--- Select a facility ---</option>');
                        $.each(response.data, function (index, value) {
                            select2.append('<option value="' + value.name + '">' + value.name + '</option>');
                        });
                    }
                });


            })
            

        });
    </script>
@stop
