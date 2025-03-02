jQuery(document).ready(function ($) {
    $(".watch-video").on("ended", function () {
        let animeId = $(this).data("anime-id");
        let episodeNumber = $(this).data("episode-number");

        $.ajax({
            url: ajaxurl.ajax_url, // AJAX URL from PHP
            type: "POST",
            data: {
                action: "save_watch_progress",
                anime_id: animeId,
                episode_number: episodeNumber,
            },
            success: function (response) {
                if (response.success) {
                    console.log("Progress saved!");
                } else {
                    console.log("Error saving progress:", response.data.message);
                }
            },
        });
    });
});

jQuery(document).ready(function($) {
    $(window).on('beforeunload', function() {
        var video_id = $('#video-player').data('video-id');
        var progress = $('#video-player').data('progress'); // Get progress from the video player

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'save_video_progress',
                video_id: video_id,
                progress: progress,
                user_id: <?php echo get_current_user_id(); ?>
            }
        });
    });
});

