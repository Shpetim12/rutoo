<?php
/*
Template Name: Watch Together
*/

get_header();
?>

<style>
.watch-rooms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
    padding: 20px;
}

.watch-room-card {
    position: relative;
    background: #15172b;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 15px;
}

.watch-room-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.5);
}

.room-thumbnail {
    position: relative;
    width: 100%;
    height: 160px;
    background-size: cover;
    background-position: center;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.room-thumbnail img {
    width: 80px;
    height: auto;
    border-radius: 5px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
}

.status-indicator {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(255, 206, 86, 0.9);
    color: #222;
    font-size: 12px;
    font-weight: bold;
    padding: 3px 8px;
    border-radius: 5px;
}

.sub-indicator {
    position: absolute;
    top: 10px;
    right: 10px;
    background: white;
    color: #000;
    font-size: 12px;
    font-weight: bold;
    padding: 3px 6px;
    border-radius: 5px;
}

.room-details {
    padding: 10px 0 5px;
    font-size: 14px;
    color: #fff;
    text-align: right;
    font-weight: bold;
    opacity: 0.8;
}

.room-activity {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 0;
    font-size: 14px;
    color: #fff;
}

.user-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 2px solid #ff69b4;
}

.room-activity span {
    font-size: 13px;
    opacity: 0.8;
}

.time-ago {
    font-size: 12px;
    opacity: 0.6;
}

.join-room-btn {
    width: 100%;
    padding: 8px;
    background: #ff69b4;
    color: white;
    border: none;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
    border-radius: 8px;
    margin-top: 10px;
}

.join-room-btn:hover {
    background: #ff4791;
}
</style>

<div class="watch-together-container">
    <div class="browse-header">
        <h1 style="color: #ff69b4;">Browse</h1>
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="on-air">On-air</button>
            <button class="filter-btn" data-filter="scheduled">Scheduled</button>
            <button class="filter-btn" data-filter="waiting">Waiting</button>
            <button class="filter-btn" data-filter="ended">Ended</button>
        </div>
    </div>

    <div class="watch-rooms-grid">
        <?php
        $args = array(
            'post_type' => 'watch_room',
            'posts_per_page' => -1,
        );
        $watch_rooms = new WP_Query($args);

        if ($watch_rooms->have_posts()) : ?>
            <?php while ($watch_rooms->have_posts()) : $watch_rooms->the_post();
                $episode_id = get_post_meta(get_the_ID(), 'episode_id', true);
                $room_status = get_post_meta(get_the_ID(), 'room_status', true);
                $room_url = get_post_meta(get_the_ID(), 'room_url', true);
                $thumbnail = get_the_post_thumbnail_url($episode_id, 'medium') ?: get_template_directory_uri() . '/images/default-thumbnail.jpg';
                $background_image = get_post_meta(get_the_ID(), 'background_image', true); 
                $user_name = get_the_author_meta('display_name', get_post_field('post_author', get_the_ID()));
                $time_ago = human_time_diff(get_post_time('U'), current_time('timestamp')) . ' ago';
                ?>
                <div class="watch-room-card <?php echo strtolower($room_status); ?>">
                    <div class="room-thumbnail" style="background-image: url('<?php echo esc_url($background_image); ?>');">
                        <span class="status-indicator"><?php echo $room_status; ?>...</span>
                        <span class="sub-indicator">SUB</span>
                    </div>
                    <div class="room-details">
                        <p>Episode 1</p>
                    </div>
                    <div class="room-activity">
                        <img src="<?php echo get_avatar_url(get_post_field('post_author', get_the_ID()), array('size' => 32)); ?>" alt="<?php echo esc_attr($user_name); ?>" class="user-avatar">
                        <span><?php echo esc_html($user_name); ?></span>
                        <span><?php echo esc_html(get_the_title()); ?> </span>
                        <span class="time-ago"><?php echo esc_html($time_ago); ?></span>
                    </div>
                    <button class="join-room-btn" data-room-url="<?php echo esc_attr($room_url); ?>">Join Room</button>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No watch rooms available. Please create a watch room in the admin.</p>
        <?php endif;

        wp_reset_postdata();
        ?>
    </div>
</div>

<?php get_footer(); ?>
