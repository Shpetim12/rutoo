<?php get_header();
$term    = get_queried_object();
$term_id = get_queried_object_id();
$loop    = new TOROFLIX_Movies(); 
$data    = array('term' => $term, 'term_id' => $term_id, 'loop' => $loop); ?>
    <div class="bd">
        <?php $term_id = get_queried_object_id();
        do_action( 'episodes_content', $data );

if (is_user_logged_in()) {
    global $wpdb;
    $user_id = get_current_user_id();
    $episode_id = $term_id; // Episode's term ID
    $episode_title = $term->name;
    $episode_url = get_permalink();

    $wpdb->replace('wp_gga2hf_watch_history', [
        'user_id' => $user_id,
        'episode_id' => $episode_id,
        'episode_title' => $episode_title,
        'episode_url' => $episode_url
    ]);
}


        # 10: POST SINGLE
        # 20: SECTION PLAYER
        # 30: SECTION SEASON
        # 40: SECTION RECOMEND ?>
    </div>              
<?php get_footer(); 
$links = tr_links_episodes($term_id);
$links['downloads'] = !empty($links['downloads']) ? $links['downloads'] : ''; ?>
<?php if($links['downloads']){ ?>
    <div class="mdl" id="mdl-download">
        <div class="mdl-cn anm-b">
            <div class="mdl-hd">
                <div class="mdl-title"><?php _e('Download Links', 'torofilm'); ?></div>
                <button class="btn lnk mdl-close aa-mdl" data-mdl="mdl-download" type="button"><i class="fa-times"></i></button>
            </div>
            <div class="mdl-bd">
                <div class="download-links">
                    <table>
                        <thead>
                            <tr>
                                <th><?php _e('Server', 'torofilm'); ?></th>
                                <th><?php _e('Lang', 'torofilm'); ?></th>
                                <th><?php _e('Quality', 'torofilm'); ?></th>
                                <th><?php _e('Link', 'torofilm'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($links['downloads'] as $key => $download) { 
                                $count = $key + 1; 
                                $count = sprintf("%02d", $count); 
                                //Server
                                if($download['server']){
                                $server_term = get_term( $download['server'], 'server' ); }
                                // lang
                                if($download['lang']){                                $lang_term = get_term( $download['lang'], 'language' ); }
                                // quality
                                if($download['quality']){
                                    $quality_term = get_term( $download['quality'], 'quality' ); } 
                                ?>
                                <tr>
                                    <td><span class="num">#<?php echo $count; ?></span> <?php if(isset($server_term->name)){  echo $server_term->name; } ?></td>
                                    <td><?php if( $download['lang'] ) { echo $lang_term->name; } else{ echo ''; } ?></td>
                                    <td><span><?php if($download['quality']){ echo $quality_term->name; }  ?></span></td>
                                    <td><a rel="nofollow" target="_blank" href="<?php echo esc_url( home_url( '/?trdownload='.$download['i'].'&t=ser&trid='.$term_id ) );  ?> class="btn sm rnd blk"><?php _e('Download', 'torofilm'); ?></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mdl-ovr aa-mdl" data-mdl="mdl-download"></div>
    </div>
<button id="save-episode" data-episode-id="<?php the_ID(); ?>">Save Episode</button>

    <script>
        document.getElementById('save-episode').addEventListener('click', function() {
            const episodeId = this.dataset.episodeId;

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'save_last_watched_episode',
                    episode_id: episodeId
                })
            }).then(response => response.json())
              .then(data => {
                  alert(data.data || 'Episode saved!');
              });
        });
    </script>
<?php } ?>
<div class="mdl" id="mdl-favorites">
    <div class="mdl-cn anm-b">
    </div>
    <div class="mdl-ovr aa-mdl" data-mdl="mdl-favorites"></div>
</div>
