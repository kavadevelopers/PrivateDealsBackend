@include('common.firebase')
<script>
    createjs.Sound.registerSound("{{ asset('core/sound/chatnotification.wav') }}", "notification");
    $(function() {
        $(".notifications .icon").click(function() {
            $(this).toggleClass("notify_icon_active");
            $(".notifications .notification_box").toggleClass("notify_active");

            $(".notifications .notification_box .close").removeClass("notify_active");
            hideNotificationBar();
            getNewNotifications();
        });
        $(".notifications .notification_box .close").click(function() {
            $(".notifications .notification_box").removeClass("notify_active");
            $(".notifications .icon").toggleClass("notify_icon_active");
            hideNotificationBar();
        });
    });

    function hideNotificationBar() {
        $("#notificationList").html(
            '<div class="notification"><div class="name_info" style="width:100%;"><div class="ajaxLoad-spinner"><span class="ajaxLoad-spinner-round"></span></div></div></div>'
        );
        $(".notifications .notify_box_footer").hide();
    }

    function getNewNotifications() {
        axios.post("{{ route('notifications') }}", {}, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(function(response) {
                $('#notificationList').html(response.data.list);
                $('.notiKavaCounter').hide();
                if (response.data.counter > 0) {
                    $('.notifications .notify_box_footer').show();
                }
            })
            .catch(function(error) {
                showErrorMessage("Something went wrong");
            });
    }
</script>
