<?php
/*
Template Name: Watch Room
*/

get_header();

// Get the room URL from the URL (e.g., /watch/solo-leveling/)
$room_url = get_query_var('pagename'); // Adjust based on your permalink structure

// Use WP_Query to find the room by room_url meta
$args = array(
    'post_type' => 'watch_room',
    'meta_query' => array(
        array(
            'key' => 'room_url',
            'value' => $room_url,
            'compare' => '='
        )
    ),
    'posts_per_page' => 1
);

$room_query = new WP_Query($args);

if ($room_query->have_posts()) {
    while ($room_query->have_posts()) : $room_query->the_post();
        $room_id = get_the_ID();
        $episode_id = get_post_meta($room_id, 'episode_id', true); // This could be a URL or ID
        $room_status = get_post_meta($room_id, 'room_status', true);
        $schedule_time = get_post_meta($room_id, 'schedule_time', true);
        ?>

        <div class="watch-room-container" style="background-color: #1a1a2e; color: #fff; padding: 20px; min-height: 100vh;">
            <div class="watch-room-card" style="background-color: #16213e; border-radius: 10px; padding: 20px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                <h2 style="color: #fff;"><?php echo get_the_title($room_id); ?></h2>
                <p style="color: #b5b5b5;">Episode: Episode 1</p> <!-- Adjust dynamically if needed -->
                <p style="color: #b5b5b5;">Scheduled: <?php echo $schedule_time; ?></p>
                <p style="color: #b5b5b5;">Status: <?php echo $room_status; ?>...</p>
                <?php if (is_user_logged_in() && current_user_can('manage_options')) : ?>
                    <button id="start-episode" data-room-id="<?php echo $room_id; ?>" style="background-color: #ff69b4; border: none; color: #fff; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 10px;">Start Episode</button>
                <?php endif; ?>
                <div class="video-container" style="margin-top: 20px;">
                    <!-- Embed your custom video player here using the episode_id -->
                    <?php if (strpos($episode_id, 'http') === 0) { // If episode_id is a URL ?>
                        <iframe id="watch-player" src="<?php echo esc_url($episode_id); ?>" width="640" height="360" frameborder="0" allowfullscreen style="border-radius: 10px;"></iframe>
                    <?php } else { // If episode_id is an attachment ID or other format, adjust as needed ?>
                        <video id="watch-player" controls width="640" height="360">
                            <source src="<?php echo wp_get_attachment_url($episode_id); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php
    endwhile;
    wp_reset_postdata();
} else {
    echo '<p>Room not found. Please check the URL or ensure the room exists and the room_url is correctly set in the admin.</p>';
}

get_footer();