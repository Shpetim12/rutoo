jQuery(document).ready(function($) {
    let roomUrl = window.location.pathname.split('/').pop();
    let videoPlayer = document.getElementById('watch-player');

    // Handle "Join Room" button click to redirect to the video page
    $('.join-room-btn').on('click', function() {
        let roomUrl = $(this).data('room-url');
        window.location.href = `https://www.rutoo.us/watch/${roomUrl}/`; // Adjust the URL to match your site structure
    });

    // Existing code for admin-only start and syncing (from Step F) remains here...
    // (e.g., handling "Start Episode," checking room status, syncing playback)

    if (videoPlayer && videoPlayer.tagName === 'IFRAME') {
        let player;
        if (videoPlayer.src.includes('youtube.com')) {
            player = new YT.Player('watch-player', {
                events: {
                    'onReady': onPlayerReady
                }
            });
        } else {
            player = videoPlayer; // Assume direct control or use a custom API
        }

        function onPlayerReady(event) {
            if (myAjax.isAdmin) {
                $('#start-episode').on('click', function() {
                    let roomId = $(this).data('room-id');
                    $.post(myAjax.ajaxurl, {
                        action: 'start_watch_room',
                        room_id: roomId,
                        nonce: myAjax.nonce
                    }, function(response) {
                        if (response.success) {
                            player.playVideo(); // Use appropriate method for your player
                            syncPlayback();
                        }
                    });
                });
            } else {
                checkRoomStatus(roomUrl, function(status) {
                    if (status === 'live') {
                        player.playVideo(); // Use appropriate method
                    } else {
                        player.pauseVideo(); // Use appropriate method
                    }
                });
            }
        }
    } else if (videoPlayer && videoPlayer.tagName === 'VIDEO') {
        // Handle HTML5 video (similar logic as above, adjusted for HTML5 methods)
        if (myAjax.isAdmin) {
            $('#start-episode').on('click', function() {
                let roomId = $(this).data('room-id');
                $.post(myAjax.ajaxurl, {
                    action: 'start_watch_room',
                    room_id: roomId,
                    nonce: myAjax.nonce
                }, function(response) {
                    if (response.success) {
                        videoPlayer.play();
                        syncPlayback();
                    }
                });
            });
        } else {
            checkRoomStatus(roomUrl, function(status) {
                if (status === 'live') {
                    videoPlayer.play();
                } else {
                    videoPlayer.pause();
                }
            });
        }
    }

    function syncPlayback() {
        setInterval(() => {
            $.get(myAjax.ajaxurl, {
                action: 'get_room_playback',
                room_id: roomUrl,
                nonce: myAjax.nonce
            }, function(data) {
                if (data.success && player) {
                    player.seekTo(data.currentTime, true); // Use appropriate method
                }
            });
        }, 1000);
    }

    function checkRoomStatus(roomUrl, callback) {
        $.get(myAjax.ajaxurl, {
            action: 'get_room_status',
            room_id: roomUrl,
            nonce: myAjax.nonce
        }, function(response) {
            if (response.success) {
                callback(response.status);
            }
        });
    }
});

function enqueue_watch_scripts() {
    if (is_page_template('page-watch-room.php') || is_page_template('page-watch-together.php')) {
        wp_enqueue_script('watch-together', get_template_directory_uri() . '/js/watch-together.js', array('jquery'), '1.0.0', true);
        wp_localize_script('watch-together', 'myAjax', array(
            'nonce' => wp_create_nonce('watch_room_nonce'),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'isAdmin' => current_user_can('manage_options') ? 1 : 0
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_watch_scripts');

jQuery(document).ready(function($) {
    // Handle "Join Room" button click (as above)
    $('.join-room-btn').on('click', function() {
        let roomUrl = $(this).data('room-url');
        window.location.href = `https://www.rutoo.us/watch/${roomUrl}/`; // Adjust the URL
    });

    // Handle filter buttons
    $('.filter-btn').on('click', function() {
        let filter = $(this).data('filter');
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        if (filter === 'all') {
            $('.watch-room-card').show();
        } else {
            $('.watch-room-card').hide();
            $('.watch-room-card.' + filter).show();
        }
    });
});