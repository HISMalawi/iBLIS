<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/ui-lightness/jquery-ui-min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dataTables.bootstrap.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/layout.css') }}" />
        <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery-ui-min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/dataTables.bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/script.js?v=2') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/spin.js') }} "></script>
        <script type="text/javascript" src="{{ URL::asset('highcharts/highcharts.js') }} "></script>
        <script type="text/javascript" src="{{ URL::asset('highcharts/exporting.js') }} "></script>
        <title>{{ Config::get('kblis.name') }} {{ Config::get('app.version') }}</title>
    </head>
    <body>
        <div id="wrap" class="no-select">
            @include("header")
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 sidebar">
                        @include("sidebar")
                    </div>
                    <div class="col-md-10 col-md-offset-2 main" id="the-one-main" style="width:85% !important;margin-left: 15% !important;
                        padding-left: 5px !important;padding-right: 5px !important;">
                        <div id="countdown" class="pull-right mb-3 text-danger font-size-28"></div>
                        @yield("content")
                    </div>
                </div>
            </div>
        </div>
        @include("footer")
    </body>

    <script>
        // Set the inactivity duration in milliseconds
        var minutes = "{{Config::get('app.defaultAutoLogOutTime')}}"
        if(minutes.trim().length === 0){
            minutes = 15;
        }else{
            minutes = parseInt(minutes);
            if (isNaN(minutes)) {
                minutes = 15;
            } else {
                minutes = minutes;
            }
        }
        var inactivityDuration = minutes * 60 * 1000; // 5 minutes

        // Initialize the timer variables
        var inactivityTimer;
        var countdownTimer;

        // Get the countdown element from the DOM
        var countdownElement = document.getElementById('countdown');

        // Function to update the countdown display
        function updateCountdownDisplay(countdown) {
            countdownElement.textContent = countdown;
        }

        // Function to reset the timers
        function resetTimers() {
            // Clear the previous timers
            clearTimeout(inactivityTimer);
            clearInterval(countdownTimer);

            // Start a new inactivity timer
            inactivityTimer = setTimeout(function() {
                // Perform the logout action here
                // You can redirect the user to the logout page or trigger a logout AJAX request
                window.location.href = '/logout'; // Example: Redirect to the logout page
            }, inactivityDuration);

            // Start a new countdown timer
            var countdownStart = Date.now();
            countdownTimer = setInterval(function() {
                var elapsedTime = Date.now() - countdownStart;
                var remainingTime = inactivityDuration - elapsedTime;

                // Calculate the remaining minutes and seconds
                var minutes = Math.floor(remainingTime / 60000);
                var seconds = Math.floor((remainingTime % 60000) / 1000);

                // Format the countdown display
                var countdown = `You will be logged out in ${minutes}m ${seconds}s if no activity`;

                // Update the countdown display
                updateCountdownDisplay(countdown);

                // Stop the countdown when the remaining time reaches 0
                if (remainingTime <= 0) {
                    clearInterval(countdownTimer);
                }
            }, 1000);
        }

        // Function to handle user activity
        function handleUserActivity() {
            resetTimers();
        }

        // Add event listeners for user activity events
        document.addEventListener('mousemove', handleUserActivity);
        document.addEventListener('keydown', handleUserActivity);
        document.addEventListener('click', handleUserActivity);

        // Start the initial timers
        resetTimers();

    </script>
</html>