<?php
/*
template name: Episodes
*/
get_header(); ?>
<div class="bd">
    <div class="dfxc">
        <main class="main-site">
            <section class="section movies">
                <header class="section-header">
                    <div class="rw alg-cr jst-sb">
                        <h1 class="section-title"><?php the_title(); ?></h1>
                    </div>
                </header>
                <ul class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl6e eqcl">
                    <?php $posts_per_page = 60;
                    $thumbs = get_option('disable_thumbs_episodes', false);
                    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $offset = ($page - 1);
                    $episodes = get_terms('episodes', array(
                        'orderby'       => 'id',
                        'order'         => 'DESC',
                        'hide_empty'    => 0,
                        /*'number'        => 120*/
                    ));
                    for ($i = $offset * $posts_per_page; $i < ($offset + 1) * $posts_per_page; $i++) {
                        $episode = $episodes[$i];
                        if ($episode != null) {
                            /*foreach ( $episodes as $episode ) {  */
                            $air_date = get_term_meta($episode->term_id, 'air_date', true);
                            $dat = strtotime($air_date); ?>
                            <li>
                                <article class="post dfx fcl episodes fa-play-circle">
                                    <?php if (!$thumbs) { ?>
                                        <div class="post-thumbnail">
                                            <figure><?php echo tr_theme_img($episode->term_id, 'episode', $episode->name, $episode->taxonomy); ?></figure>
                                            <span class="play fa-play"></span>
                                        </div>
                                    <?php } ?>
                                    <header class="entry-header">
                                        <span class="num-epi"><?php echo get_term_meta($episode->term_id, 'season_number', true); ?>x<?php echo get_term_meta($episode->term_id, 'episode_number', true); ?></span>
                                        <h2 class="entry-title"><?php echo $episode->name; ?></h2>
                                        <div class="entry-meta">
                                            <span class="time"><?php echo human_time_diff($dat, current_time('timestamp')) . ' ago'; ?></span>
                                        </div>
                                    </header>
                                    <a href="<?php echo get_term_link($episode); ?>" class="lnk-blk"></a>
                                </article>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <nav class="navigation pagination"><?php pagination12('PREV', 'I RADHES'); ?></nav>
            </section>
        </main>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer();  ?>