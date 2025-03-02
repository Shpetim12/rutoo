<?php
/*
 * Template Name: Solo Leveling Episodes (Full Width)
 * Description: Full-width video player for Solo Leveling episodes.
 */

get_header();
?>

<div class="episode-container">
    <!-- Header Section -->
    <header class="episode-header">
        <h1>?? Watch Solo Leveling - Episode 19 Together</h1>
        <h2>Solo Leveling - SUB <span class="sub-tag">SUB</span> · Episode 19</h2>
    </header>

    <!-- Full Width Video Player -->
    <div class="video-wrapper">
        <?php 
        $video_url = "https://filemoon.to/e/fyhnpng48zpk/_SubsPlease__Solo_Leveling_-_19__1080p___1BFFB5F5_"; // Replace with ACF if needed

        if ($video_url) {
            echo '<iframe src="' . esc_url($video_url) . '" allowfullscreen></iframe>';
        } else {
            echo "<p>Video not available.</p>"; 
        }
        ?>
    </div>

    <!-- User & Viewers Info -->
    <div class="episode-info">
        <div class="user-info">
            <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="User Avatar" class="user-avatar">
            <span>creas - Created 5 months ago</span>
        </div>
        <div class="viewers-count">
            <span>??? 0 viewers</span>
        </div>
        <div class="time-count">
            <span>?? 139:15:04:49</span>
        </div>
    </div>
</div>

<?php
// Custom CSS for Full-Width Styling
?>
<style>
    body, html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #1e122b; /* Dark theme background */
        color: #fff;
    }

    .episode-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        padding: 20px 5%;
        background: #2a1d4e;
    }

    .episode-header {
        text-align: left;
        margin-bottom: 15px;
        padding: 10px 0;
        border-bottom: 2px solid #4a3b6e;
    }

    .episode-header h1 {
        font-size: 24px;
        color: #fff;
        margin: 0;
    }

    .episode-header h2 {
        font-size: 18px;
        color: #b5b5b5;
        margin: 5px 0;
    }

    .sub-tag {
        background: #6ac259;
        color: #fff;
        padding: 3px 6px;
        font-size: 14px;
        border-radius: 5px;
        font-weight: bold;
    }

    .video-wrapper {
        width: 100%;
        height: 600px; /* Adjust height if needed */
        background: black;
        position: relative;
    }

    .video-wrapper iframe {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 0;
    }

    .episode-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: #2a1d4e;
        border-top: 1px solid #4a3b6e;
        margin-top: 15px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .viewers-count, .time-count {
        font-size: 16px;
        color: #d0a8ff;
    }
</style>

<?php get_footer(); ?>
