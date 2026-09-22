<!DOCTYPE html>
<html lang="en">

<head>
    <title>Coming Soon 8</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="coming_soon/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="coming_soon/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="coming_soon/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="coming_soon/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="coming_soon/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="coming_soon/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="coming_soon/css/util.css">
    <link rel="stylesheet" type="text/css" href="coming_soon/css/main.css">
    <!--===============================================================================================-->
</head>

<body>


    <div class="bg-img1 overlay1 size1 flex-w flex-c-m p-t-55 p-b-55 p-l-15 p-r-15"
        style="background-image: url('coming_soon/images/bg01.jpg');">
        <div class="wsize1">
            <p class="txt-center p-b-23">
                <img src="{{ asset('website-assets/images/logo.svg') }}" alt="ShuruUp" class="logo">
            </p>

            <h3 class="l1-txt1 txt-center p-b-22">
                Coming Soon
            </h3>

            <p class="txt-center m2-txt1 p-b-67">
                Exciting things are coming soon! We're creating something amazing just for you. Stay
                tuned for updates, and be the first to know when we launch!
            </p>

            <div class="flex-w flex-sa-m cd100 bor1 p-t-42 p-b-22 p-l-50 p-r-50 respon1">
                <div class="flex-col-c-m wsize2 m-b-20">
                    <span class="l1-txt2 p-b-4 days">0</span>
                    <span class="m2-txt2">Days</span>
                </div>

                <span class="l1-txt2 p-b-22">:</span>

                <div class="flex-col-c-m wsize2 m-b-20">
                    <span class="l1-txt2 p-b-4 hours">17</span>
                    <span class="m2-txt2">Hours</span>
                </div>

                <span class="l1-txt2 p-b-22 respon2">:</span>

                <div class="flex-col-c-m wsize2 m-b-20">
                    <span class="l1-txt2 p-b-4 minutes">30</span>
                    <span class="m2-txt2">Minutes</span>
                </div>

                <span class="l1-txt2 p-b-22">:</span>

                <div class="flex-col-c-m wsize2 m-b-20">
                    <span class="l1-txt2 p-b-4 seconds">0</span>
                    <span class="m2-txt2">Seconds</span>
                </div>
            </div>

            {{-- <form class="flex-w flex-c-m contact100-form validate-form p-t-70">
                <div class="wrap-input100 validate-input where1" data-validate = "Email is required: ex@abc.xyz">
                    <input class="s1-txt1 placeholder0 input100" type="text" name="email"
                        placeholder="Email Address">
                    <span class="focus-input100"></span>
                </div>

                <button class="flex-c-m s1-txt1 size2 how-btn trans-04 where1">
                    Notify Me
                </button>
            </form> --}}
        </div>
    </div>





    <!--===============================================================================================-->
    <script src="coming_soon/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="coming_soon/vendor/bootstrap/js/popper.js"></script>
    <script src="coming_soon/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="coming_soon/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="coming_soon/vendor/countdowntime/moment.min.js"></script>
    <script src="coming_soon/vendor/countdowntime/moment-timezone.min.js"></script>
    <script src="coming_soon/vendor/countdowntime/moment-timezone-with-data.min.js"></script>
    <script src="coming_soon/vendor/countdowntime/countdowntime.js"></script>
    <script>
        $('.cd100').countdown100({
            /*Set Endtime here*/
            /*Endtime must be > current time*/
            endtimeYear: 2024,
            endtimeMonth: 11,
            endtimeDate: 11,
            endtimeHours: 17,
            endtimeMinutes: 30,
            endtimeSeconds: 0,
            timeZone: "Asia/Kolkata"
            // ex:  timeZone: "America/New_York"
            //go to " http://momentjs.com/timezone/ " to get timezone
        });
    </script>
    <!--===============================================================================================-->
    <script src="coming_soon/vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <!--===============================================================================================-->
    <script src="coming_soon/js/main.js"></script>

</body>

</html>
