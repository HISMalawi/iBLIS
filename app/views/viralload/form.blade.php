@extends('layout')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/viral-wizard.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/jquery-steps/jquery.steps.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/plugins.css') }}" />

    <div class="card">
        <div class="card-body">
            <!--Wizard-->
            <form id="wizard7" class="wizard needs-validation" data-style="1" novalidate>


                <!--Step 1-->
                <h3>Health Facility Information</h3>
                <div class="wizard-content">
                    <h3><strong>Section 1:</strong> Health Facility Information</h3>
                    <hr>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="district">District :</label>
                            <input type="text" class="form-control" name="district" id="district">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="facility">Facility Name :</label>
                            <input type="text" class="form-control" name="facility" id="facility">
                        </div>
                    </div>
                    <h3><strong>Section 2:</strong> Patient Information</h3>
                    <hr>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="surname">Patient Surname :</label>
                            <input type="text" class="form-control" name="surname" id="p_surname">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="firstname">Patient First Name :</label>
                            <input type="text" class="form-control" name="firstname" id="p_first_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="id">Patient ID :</label>
                            <input type="text" class="form-control" name="id" id="p_id">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="dob">Date of Birth :</label>
                            <input type="date" class="form-control" name="dob" id="p_dob">
                        </div>
                    </div>
                    <fieldset class="row mb-4">
                        <label class="d-block mb-3" for="dob">Gender / Preg / Bf (tick one) :</label>

                        <div class="form-check d-block">
                            <input class="form-check-input mx-3" type="radio" name="gender" id="gridRadios1"
                                value="Male">
                            <label class="form-check-label" for="gridRadios1">
                                Male
                            </label>
                        </div>
                        <div class="form-check d-block">
                            <input class="form-check-input mx-3" type="radio" name="gender" id="gridRadios2"
                                value="Female Non-Preg./ Bf.">
                            <label class="form-check-label" for="gridRadios2">
                                Female Non-Preg./ Bf.
                            </label>
                        </div>

                        <div class="form-check d-block">
                            <input class="form-check-input mx-3" type="radio" name="gender" id="gridRadios3"
                                value="Female Pregnant">
                            <label class="form-check-label" for="gridRadios3">
                                Female Pregnant
                            </label>
                        </div>

                        <div class="form-check d-block">
                            <input class="form-check-input mx-3" type="radio" name="gender" id="gridRadios4"
                                value="Female Breastfeeding">
                            <label class="form-check-label" for="gridRadios4">
                                Female Breastfeeding
                            </label>
                        </div>

                    </fieldset>

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="phone">Patient/Guardian Phone Number :</label>
                            <input type="text" class="form-control" name="phone" id="p_phone">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="sample-date">Date Sample Drawn :</label>
                            <input type="date" class="form-control" name="sample-date" id="sample_date">
                        </div>
                    </div>

                </div>
                <!--end: Step 1-->


                <!--Step 2-->
                <h3>Test Type</h3>
                <div class="wizard-content">
                    <h3><strong>Section 3: </strong>Reason for Test</h3>
                    <hr>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <fieldset class="row mb-4">
                                <label class="d-block mb-3" for="dob">Select reason :</label>

                                <div class="form-check d-block">
                                    <input class="form-check-input mx-3" type="radio" name="reason" id="gridRadios5"
                                        value="Routine">
                                    <label class="form-check-label" for="gridRadios5">
                                        Routine
                                    </label>
                                </div>
                                <div class="form-check d-block">
                                    <input class="form-check-input mx-3" type="radio" name="reason" id="gridRadios6"
                                        value="Targeted">
                                    <label class="form-check-label" for="gridRadios6">
                                        Targeted
                                    </label>
                                </div>

                                <div class="form-check d-block">
                                    <input class="form-check-input mx-3" type="radio" name="reason" id="gridRadios7"
                                        value="Follow-up after high VL">
                                    <label class="form-check-label" for="gridRadios7">
                                        Follow-up after high VL
                                    </label>
                                </div>

                                <div class="form-check d-block">
                                    <input class="form-check-input mx-3" type="radio" name="reason" id="gridRadios8"
                                        value="Repeat (reject / lost / missing)">
                                    <label class="form-check-label" for="gridRadios8">
                                        Repeat (reject / lost / missing)
                                    </label>
                                </div>

                            </fieldset>
                        </div>
                    </div>

                </div>
                <!--end: Step 2-->


                <!--Step 3-->
                <h3>Patient and Sample Details</h3>
                <div class="wizard-content">
                    <h3><strong>Section 5:</strong> Patient and Sample Details</h3>
                    <hr>

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="art-init-date">ART Initiation Date :</label>
                            <input type="date" class="form-control" name="art-init-date" id="art-init-date">
                        </div>
                        <div class="form-group col-lg-6">
                            <fieldset class="row mb-4">
                                <label class="d-block mb-3" for="dob">Sample Type :</label>

                                <div class="form-check d-block">
                                    <input class="form-check-input mx-3" type="radio" name="sample-type"
                                        id="gridRadios9" value="DBS (using capillary tube)">
                                    <label class="form-check-label" for="gridRadios9">
                                        DBS (using capillary tube)
                                    </label>
                                </div>
                                <div class="form-check d-block">
                                    <input class="form-check-input mx-3" type="radio" name="sample-type"
                                        id="gridRadios10" value="Plasma">
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
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios11" value="0P">
                                        <label class="form-check-label" for="gridRadios11">
                                            0P
                                        </label>
                                    </div>
                                    <div class="form-check cus-check purple">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios12" value="2P">
                                        <label class="form-check-label" for="gridRadios12">
                                            2P
                                        </label>
                                    </div>
                                    <div class="form-check cus-check purple">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios13" value="4P">
                                        <label class="form-check-label" for="gridRadios13">
                                            4P
                                        </label>
                                    </div>
                                    <div class="form-check cus-check purple">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios14" value="9P">
                                        <label class="form-check-label" for="gridRadios14">
                                            9P
                                        </label>
                                    </div>
                                    <div class="form-check cus-check purple">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios15" value="11P">
                                        <label class="form-check-label" for="gridRadios15">
                                            11P
                                        </label>
                                    </div>
                                    <div class="form-check cus-check purple">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios16" value="14P">
                                        <label class="form-check-label" for="gridRadios16">
                                            14P
                                        </label>
                                    </div>
                                    <div class="form-check cus-check purple">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios17" value="15P">
                                        <label class="form-check-label" for="gridRadios17">
                                            15P
                                        </label>
                                    </div>
                                    <div class="form-check cus-check purple">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios18" value="16P">
                                        <label class="form-check-label" for="gridRadios18">
                                            16P
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios19" value="0A">
                                        <label class="form-check-label" for="gridRadios19">
                                            0A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios20" value="2A">
                                        <label class="form-check-label" for="gridRadios20">
                                            2A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios21" value="4A">
                                        <label class="form-check-label" for="gridRadios21">
                                            4A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios22" value="5A">
                                        <label class="form-check-label" for="gridRadios22">
                                            5A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios23" value="6A">
                                        <label class="form-check-label" for="gridRadios23">
                                            6A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios24" value="7A">
                                        <label class="form-check-label" for="gridRadios24">
                                            7A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios25" value="8A">
                                        <label class="form-check-label" for="gridRadios25">
                                            8A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios26" value="9A">
                                        <label class="form-check-label" for="gridRadios26">
                                            9A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios27" value="10P">
                                        <label class="form-check-label" for="gridRadios27">
                                            10P
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios28" value="11A">
                                        <label class="form-check-label" for="gridRadios28">
                                            11A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios29" value="12A">
                                        <label class="form-check-label" for="gridRadios29">
                                            12A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios30" value="13A">
                                        <label class="form-check-label" for="gridRadios30">
                                            13A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios31" value="14A">
                                        <label class="form-check-label" for="gridRadios31">
                                            14A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios32" value="15A">
                                        <label class="form-check-label" for="gridRadios32">
                                            15A
                                        </label>
                                    </div>
                                    <div class="form-check cus-check">
                                        <input class="form-check-input mx-3" type="radio" name="regimen"
                                            id="gridRadios33" value="NS">
                                        <label class="form-check-label" for="gridRadios33">
                                            NS
                                        </label>
                                    </div>
                                </div>


                            </fieldset>
                        </div>

                    </div>
                </div>
                <!--end: Step 3-->


                <!--Step 4-->
                <h3>Details of Person Collecting Sample</h3>
                <div class="wizard-content">
                    <h3><strong>Section 6:</strong> Details of Person Collecting Sample</h3>
                    <hr>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="surname">Surname :</label>
                            <input type="text" class="form-control" name="pcs-surname">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="firstname">First Name :</label>
                            <input type="text" class="form-control" name="pcs-firstname">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="phone">Phone Number :</label>
                            <input type="text" class="form-control" name="pcs-phone">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="id">HTC Provider ID :</label>
                            <input type="text" class="form-control" name="htc-provider-id">
                        </div>
                    </div>

                </div>
                <!--end: Step 4-->


                <!--Step 5-->
                <h3>Confirmation</h3>
                <div class="wizard-content">
                    <h3><strong>Confirmation</strong></h3>
                    <hr>
                    <h4><strong>Section 1:</strong> Health Facility Information</h4>
                    <br>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="district">District :</label>
                            <p id="confi-district-name">--</p>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="facility">Facility Name :</label>
                            <p id="confi-facility-name">--</p>
                        </div>
                    </div>
                    <h4><strong>Section 2:</strong> Patient Information</h4>
                    <br>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="surname">Patient Surname :</label>
                            <p id="confi-patient-surname">--</p>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="firstname">Patient First Name :</label>
                            <p id="confi-patient-firstname">--</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="id">Patient ID :</label>
                            <p id="confi-patient-id">--</p>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="dob">Date of Birth :</label>
                            <p id="confi-patient-dob">--</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="id">Gender / Preg / Bf :</label>
                            <p id="confi-patient-gender">--</p>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="id">Patient/Guardian Phone Number :</label>
                            <p id="confi-patient-phone">--</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="id">Date Sample Drawn :</label>
                            <p id="confi-sample-date">--</p>
                        </div>
                    </div>
                    <h4><strong>Section 3:</strong> Reason for Test</h4>
                    <br>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="id">Reason :</label>
                            <p id="confi-test-reason">--</p>
                        </div>
                    </div>
                    <h4><strong>Section 5:</strong> Patient and Sample Details</h4>
                    <br>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="id">ART Initiation Date :</label>
                            <p id="confi-art-init-date">--</p>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="id">Sample Type :</label>
                            <p id="confi-sample-type">--</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="id">Current ART Regimen :</label>
                            <p id="confi-curr-art-regimen">--</p>
                        </div>
                        
                    </div>

                </div>
                <!--end: Step 5-->

            </form>
            <!--end:Wizard-->
        </div>
    </div>

    <script src="{{ URL::asset('plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/validate/validate.min.js') }}"></script>
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
                return wizard7.valid();
            },
            onStepChanged: function(event, currentIndex, priorIndex) {
                
                if (currentIndex == 4 || currentIndex == 5 ) {

                  var district =   $('#district').val();
                  var facility =   $('#facility').val();

                  var p_surname =   $('#p_surname').val();
                  var p_first_name =   $('#p_first_name').val();

                  var p_id =   $('#p_id').val();
                  var p_dob =   $('#p_dob').val();

                  var p_gender = $("input[name='gender']:checked").val();

                  var p_phone =   $('#p_phone').val();
                  var sample_date =   $('#sample_date').val();

                  var test_reason = $("input[name='reason']:checked").val();

                  var art_init_date =  $('#art-init-date').val();
                  var sample_type =  $("input[name='sample-type']:checked").val();

                  var current_art_regimen =  $("input[name='regimen']:checked").val();

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

                }
            },
            onFinishing: function(event, currentIndex) {
                return wizard7.valid();
            },
            onFinished: function(event, currentIndex) {
                INSPIRO.elements.notification("Submited",
                    "Thank you, your account has been registed successfully", "success");
            }
        });
        //Validation
        // wizard7.validate({
        //     errorClass: 'is-invalid',
        //     validClass: 'is-valid',
        //     errorElement: "div",
        //     rules: {
        //         // Step 1 - Account information
        //         username: {
        //             required: true
        //         },
        //         email: {
        //             required: true,
        //             email: true,
        //             minlength: 8
        //         },
        //         password: {
        //             required: true,
        //             minlength: 5,
        //             maxlength: 12
        //         },
        //         password2: {
        //             required: true,
        //             minlength: 5,
        //             maxlength: 12
        //         },
        //         // Step 4 - Confirmation
        //         reminders: {
        //             required: true
        //         },
        //         terms_conditions: {
        //             required: true
        //         },
        //     },
        //     errorPlacement: function(error, element) {
        //         $(element).parents(".form-group").append(error);
        //     }
        // });
        $('.wizard').find(".actions ul > li > a").addClass("btn");
    </script>
@stop
