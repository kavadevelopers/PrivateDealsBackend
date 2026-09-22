<link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" />
<div class="modal  fade" id="modalVideoPlayer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight:bold;"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <video id="video-player" class="video-js vjs-big-play-centered vjs-16-9" controls preload="auto">
                </video>
            </div>
        </div>
    </div>
</div>
<script src="https://vjs.zencdn.net/7.18.1/video.min.js"></script>

<script type="text/javascript">
    var player;
    $(function() {
        $(document).on('click', '.btn-open-video-player', function(e) {
            e.preventDefault();
            $('#modalVideoPlayer').modal('show');
            player = videojs(document.querySelector('#video-player'));
            player.reset();
            player.src({
                src: $(this).data('video')
            });
            $("#video-player video").get(0).play();
            //$("#modalVideoPlayer #video-player").html('<source src="'+$(this).data('video')+'" type="video/mp4"></source>' );
        });
        $(document).on('hide.bs.modal', '#modalVideoPlayer', function() {
            if ($("#video-player video").get(0)) {
                $("#video-player video").get(0).pause();
            }

        });
    })
</script>
