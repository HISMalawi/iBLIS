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
                            <input type="text" class="form-control" name="district">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="facility">Facility Name :</label>
                            <input type="text" class="form-control" name="facility">
                        </div>
                    </div>
                    <h3><strong>Section 2:</strong> Patient Information</h3>
                    <hr>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="surname">Patient Surname :</label>
                            <input type="text" class="form-control" name="surname">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="firstname">Patient First Name :</label>
                            <input type="text" class="form-control" name="firstname">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="id">Patient ID :</label>
                            <input type="text" class="form-control" name="id">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="dob">Date of Birth :</label>
                            <input type="date" class="form-control" name="dob">
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
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="sample-date">Date Sample Drawn :</label>
                            <input type="date" class="form-control" name="sample-date">
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
                            <input type="date" class="form-control" name="art-init-date">
                        </div>
                        <div class="form-group col-lg-6">
                            <fieldset class="row mb-4">
                                <label class="d-block mb-3" for="dob">Sample Type :</label>
                                
                                <div class="form-check d-block">
                                    <input class="form-check-input mx-3" type="radio" name="sample-type" id="gridRadios9"
                                        value="DBS (using capillary tube)">
                                    <label class="form-check-label" for="gridRadios9">
                                        DBS (using capillary tube)
                                    </label>
                                </div>
                                <div class="form-check d-block">
                                    <input class="form-check-input mx-3" type="radio" name="sample-type" id="gridRadios10"
                                        value="Plasma">
                                    <label class="form-check-label" for="gridRadios10">
                                        Plasma
                                    </label>
                                </div>
        
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-lg-6">
                            <fieldset class="row mb-4">
                                <label class="d-block mb-3">Current ART regimen :</label>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input mx-3" type="radio" name="sample-type" id="gridRadios9"
                                            value="DBS (using capillary tube)">
                                        <label class="form-check-label" for="gridRadios9">
                                            0P
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input mx-3" type="radio" name="sample-type" id="gridRadios10"
                                            value="Plasma">
                                        <label class="form-check-label" for="gridRadios10">
                                            5A
                                        </label>
                                    </div>
                                </div>
                                
        
                            </fieldset>
                        </div>

                    </div>
                </div>
                <!--end: Step 3-->


                <!--Step 4-->
                <h3>Confirmation</h3>
                <div class="wizard-content">
                    <div class="h5 mb-4">Confimration</div>
                    <p>Customize your experience by confirming your personalization settings and the data stored with your
                        account. You can always learn more about these options, adjust them, and review your activity in
                        your Account</p>
                    <p>These settings apply wherever you are signed in to your new Account.</p>
                    <div class="form-check mb-1 mt-5">
                        <input type="checkbox" name="reminders" id="reminders" class="form-check-input">
                        <label class="custom-control-label" for="reminders">Send me occasional
                            reminders
                            about these settings</a></label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="terms_conditions" id="terms_conditions" class="form-check-input">
                        <label class="custom-control-label" for="terms_conditions">By checking
                            this
                            option, you agree to acceot with the <a href="#">Terms and
                                Conditions</a>.</label>
                    </div>
                    <!--end: Step 4-->
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
            onStepChanged: function(event, currentIndex, priorIndex) {},
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
