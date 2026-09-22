<div class="session-expire-alert d-none" id="session-alert-box">
    <div class="alert alert-dismissible bg-light-primary d-flex flex-column p-0 mb-10 position-relative">

        <!-- Progress Bar -->
        <div class="progress" style="height: 5px;">
            <div id="session-progress-bar" class="progress-bar bg-primary" role="progressbar" style="width: 100%;"
                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="d-flex flex-column flex-sm-row p-5">
            <i class="ki-duotone ki-notification-bing fs-2hx text-primary me-4 mb-5 mb-sm-0">
                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
            </i>

            <div class="d-flex flex-column pe-0 pe-sm-10 flex-grow-1">
                <h4 class="fw-semibold">Session Expiring Soon</h4>
                <span id="session-countdown-text">
                    Your session is about to expire. Please take action to continue your work without interruption.
                </span>

                <div class="mt-4">
                    <button id="restore-session-btn" class="btn btn-sm btn-primary me-2">Restore</button>
                    <button id="logout-session-btn" class="btn btn-sm btn-light-danger">Logout</button>
                </div>
            </div>

            <button type="button"
                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                data-bs-dismiss="alert">
                <i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span
                        class="path2"></span></i>
            </button>
        </div>
    </div>
</div>




<style>
    .session-expire-alert {
        position: fixed;
        top: 0;
        right: 0;
        z-index: 9999;
        width: 100%;
        max-width: 500px;
        margin: 20px;
    }
</style>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let expireInMinutes = 120;
        let sessionStart = new Date();
        let sessionExpire = new Date(sessionStart.getTime() + expireInMinutes * 60000);

        let sessionAlertShown = false;
        let alertDuration = 60; // seconds to keep alert visible (1 minute)
        let alertCountdown = alertDuration;

        let interval = setInterval(function() {
            let now = new Date();
            let diffInSeconds = Math.floor((sessionExpire - now) / 1000);

            if (diffInSeconds <= 60 && !sessionAlertShown) {
                sessionAlertShown = true;
                $('#session-alert-box').removeClass('d-none');
            }

            // If alert is showing, update progress bar
            if (sessionAlertShown && diffInSeconds <= 60 && diffInSeconds >= 0) {
                let percent = (diffInSeconds / alertDuration) * 100;
                $('#session-progress-bar').css('width', percent + '%');
                $('#session-progress-bar').attr('aria-valuenow', percent);

                let minutes = Math.floor(diffInSeconds / 60);
                let seconds = diffInSeconds % 60;
                let timeLeftMsg = `Your session is expiring in ${minutes} min ${seconds} sec. ` +
                    `Click "Restore" to continue your session or "Logout" to end it.`;

                $('#session-countdown-text').text(timeLeftMsg);
            }

            if (diffInSeconds <= 0) {
                clearInterval(interval);
                $.post("{{ route('admin.logout') }}", {}, function(res) {
                    console.log('Session restored');
                });
                location.reload();
            }
        }, 1000);

        // Restore button click
        $('#restore-session-btn').on('click', function() {
            // Example: Reset timer
            sessionStart = new Date();
            sessionExpire = new Date(sessionStart.getTime() + expireInMinutes * 60000);
            sessionAlertShown = false;
            alertCountdown = alertDuration;
            $('#session-alert-box').addClass('d-none');

            $.post("{{ route('session.restore') }}", {}, function(res) {
                console.log('Session restored');
            });
        });

        $('#logout-session-btn').on('click', function() {
            // window.location.href = '/logout'; // your logout route
            $.post("{{ route('admin.logout') }}", {}, function(res) {
                console.log('Session restored');
            });
            location.reload();
        });
    });
</script>
