<script>
    createjs.Sound.registerSound("{{ asset('core/sound/chatnotification.wav') }}", "notification");
    $(function() {
        $(document).on("click", "#kt_menu_item_wow", function() {
            $('#kt_menu_notifications .tab-content .scroll-y .load').show();
            $('#kt_menu_notifications .tab-content .scroll-y .data').hide();
            $('#kt_menu_notifications .tab-content .view-all').hide();
            document.querySelector(".notificationBubble").style.display = "none";
            getNewNotifications();
        });
    });

    function getNewNotifications() {
        axios.post("{{ route('notifications') }}", {}, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(function(response) {
                $('#kt_menu_notifications .tab-content .scroll-y .data').html(response.data.list);
                $('#kt_menu_notifications .tab-content .scroll-y .load').hide();
                $('#kt_menu_notifications .tab-content .scroll-y .data').show();
                if (response.data.counter > 0) {
                    $('#kt_menu_notifications .tab-content .view-all').show();
                }
            })
            .catch(function(error) {
                showErrorMessage("Something went wrong");
            });
    }
</script>
@include('common.firebase')
