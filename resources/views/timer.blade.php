<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>TEST TEST</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
            <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script>
           document.addEventListener("DOMContentLoaded", function () {
            let countdownTime = {{$time}} * 60 * 60; // Countdown time in seconds (2 hours)
            const countdownDisplay = document.getElementById("countdown");
            const form = document.getElementById("autoSubmitForm");

            // Function to update the countdown and submit the form
            function updateCountdown() {
                let hours = Math.floor(countdownTime / 3600);
                let minutes = Math.floor((countdownTime % 3600) / 60);
                let seconds = countdownTime % 60;

                // Format the time to display as HH:MM:SS
                hours = hours < 10 ? '0' + hours : hours;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                countdownDisplay.textContent = `${hours}:${minutes}:${seconds}`;

                if (countdownTime > 0) {
                    countdownTime--;
                } else {
                    form.submit();
                }
            }

            // Update countdown every second
            setInterval(updateCountdown, 1000);
        });
    </script>
</head>
<body>
    <h1 align="right">
    <p id="countdown">0{{$time}}:00:00</p>
    <form id="autoSubmitForm" action="submit_form.php" method="post">
        <!-- Form fields go here -->
        <input type="hidden" name="exampleField" value="exampleValue">
    </form>
</body>
</html>
