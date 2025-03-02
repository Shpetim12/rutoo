<?phpclass TOROFILM_public_ajax{    /*EPISODES BY SEASON*/    public function select_season()    {        if (isset($_POST['action'])) {            $thumbs = get_option('disable_thumbs_episodes', false);            $season = $_POST['season'];            $post = $_POST['post'];            $tempx = $season;            $cv    = 'value';            $ntempx = $season;            if(!$tempx) {                $tempx = 'NOT EXISTS';                $cv = 'compare';                $ntempx = 0;            }            $episodes = get_terms('episodes', array(                'orderby' => 'meta_value_num',                'order'         => 'ASC',                'hide_empty'    => 0,                'number'        => 1000,                'meta_query' => array(                    'relation' => 'AND',                    array(                        'key' => 'episode_number',                        'compare' => 'EXISTS',                    ),                    array(                        'key' => 'tr_id_post',                        'value' => $post                    ),                    array(                        'key' => 'season_number',                        $cv   => $tempx                    )                )            ));            foreach ($episodes as $episode) {  ?>                <li>                    <article class="post dfx fcl episodes fa-play-circle lg">                        <?php if (!$thumbs) { ?>                            <div class="post-thumbnail">                                <figure><?php echo tr_theme_img($episode->term_id, 'episode', $episode->name, $episode->taxonomy); ?></figure>                            </div>                        <?php } ?>                        <header class="entry-header">                            <span class="num-epi"><?php echo $ntempx; ?>x<?php echo get_term_meta($episode->term_id, 'episode_number', true); ?></span>                            <h2 class="entry-title"><?php echo $episode->name; ?></h2>                            <?php if($dat){ ?>                            <div class="entry-meta">                                <span class="time"><?php echo human_time_diff($dat, current_time('timestamp')) . ' ' . __('ago', 'torofilm'); ?></span>                            </div>                            <?php } ?>                            <span class="view"><?php _e('View', 'torofilm'); ?></span>                        </header>                        <a href="<?php echo get_term_link($episode); ?>" class="lnk-blk"></a>                    </article>                </li>                <?php }            exit;        }    }    /*AGREGAR A FAVORITO*/    public function peli_add_favorito()    {        if (isset($_POST['action'])) {            $post_id = $_POST['post_id'];            $status = $_POST['status'];            $user_id = get_current_user_id();            $data = get_user_meta($user_id, 'favorito', true);            if ($status == 'favorito') {                if (($key = array_search($post_id, $data)) !== false) {                    unset($data[$key]);                }                update_user_meta($user_id, 'favorito', $data);            } elseif ($status == 'nofavorito') {                if ($data) {                    if (!in_array($post_id, $data)) {                        array_push($data, $post_id);                        update_user_meta($user_id, 'favorito', $data);                    }                } else {                    $data = array($post_id);                    update_user_meta($user_id, 'favorito', $data);                }            }            $res = [                'res' => $user_id            ];            echo json_encode($res);            wp_die();        }    }    public function peli_add_favorito_s()    {        if (isset($_POST['action'])) {            $post_id = $_POST['post_id'];            $status = $_POST['status'];            $user_id = get_current_user_id();            $data = get_user_meta($user_id, 'favorito-s', true);            if ($status == 'favorito') {                if (($key = array_search($post_id, $data)) !== false) {                    unset($data[$key]);                }                update_user_meta($user_id, 'favorito-s', $data);            } elseif ($status == 'nofavorito') {                if ($data) {                    if (!in_array($post_id, $data)) {                        array_push($data, $post_id);                        update_user_meta($user_id, 'favorito-s', $data);                    }                } else {                    $data = array($post_id);                    update_user_meta($user_id, 'favorito-s', $data);                }            }            $res = [                'res' => $user_id            ];            echo json_encode($res);            wp_die();        }    }    public function editor_user_perfil()    {        if (isset($_POST['action'])) {            $pass = $_POST['pass'];            $passRepeat = $_POST['passRepeat'];            $user = get_current_user_id();            #Se actualiza la descripcion            wp_update_user(array('ID' => $user, 'user_pass' => $pass));            echo json_encode($res);            wp_die();        }    }    public function peli_login_header()    {        if (isset($_POST['action'])) {            #Data            $name = $_POST['name'];            $pass = esc_attr($_POST['pass']);            #Security of Form            $username = sanitize_text_field($name);            $password = sanitize_text_field($pass);            if ($remember) $remember = "true";            else $remember = "false";            #Verify Login            $login_data = array();            $login_data['user_login'] = $username;            $login_data['user_password'] = $password;            $login_data['remember'] = $remember;            $user_verify = wp_signon($login_data, false);            if (is_wp_error($user_verify)) {                $error = 'true';            } else {                $error = 'false';            }            $res = [                'error' => $error            ];            echo json_encode($res);            wp_die();        }    }    public function peli_register_header()    {        if (isset($_POST['action'])) {            #Data            $name = $_POST['name'];            $pwd1 = esc_attr($_POST['pass']);            $email = esc_attr($_POST['email']);            $email = sanitize_email($email);            $username = sanitize_user($name);            if ($email == "" || $pwd1 == "" || $username == "") {                $err = 'true';            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {                $err = 'true';            } else if (email_exists($email)) {                $err = 'true';            } else {                $userdata = array(                    'user_login'    =>   $username,                    'user_email'    =>   $email,                    'user_pass'     =>   $pwd1,                );                $user = wp_insert_user($userdata);                $err = 'false';            }            $res = [                'error' => $err            ];            echo json_encode($res);            wp_die();        }    }    public function tr_search_suggest()    {        if (isset($_POST['action'])) {            $args = array(                'post_type' => array('post', 'movies', 'series'),                'post_status' => 'publish',                'order' => 'DESC',                'orderby' => 'date',                's' => $_POST['term'],                'posts_per_page' => 5            );            $query_movie = new WP_Query($args);            if ($query_movie->post_count > 0) {                if ($query_movie->have_posts()) : ?>                    <li class="title"><?php _e('Results', 'torofilm'); ?></li>                    <?php while ($query_movie->have_posts()) {                        $query_movie->the_post(); ?>                        <li class="fa-play-circle">                            <a href="<?php the_permalink(); ?>"><span class="<?php echo 'type-' . get_post_type(); ?>"><?php _e(get_post_type(), 'torofilm'); ?></span><?php the_title(); ?></a>                        </li>                <?php }                endif;                wp_reset_query(); ?>                <li><a id="more-shm" href="javascript:void(0)" class="btn sm rnd"><?php _e('More results', 'torofilm'); ?></a></li>            <?php } else { ?>                <li class="loading"><i class="fas fa-spinner fa-pulse"></i></li>                <li class="error"><?php _e('No results found', 'torofilm'); ?></li>                <?php }            exit;        }    }    public function tr_search_suggest_h()    {        if (isset($_POST['action'])) {            $args = array(                'post_type' => array('post', 'movies', 'series'),                'post_status' => 'publish',                'order' => 'DESC',                'orderby' => 'date',                's' => $_POST['term'],                'posts_per_page' => 5            );            $query_movie = new WP_Query($args);            if ($query_movie->post_count > 0) {                if ($query_movie->have_posts()) : ?>                    <li class="title"><?php _e('Results', 'torofilm'); ?></li>                    <?php while ($query_movie->have_posts()) {                        $query_movie->the_post(); ?>                        <li class="fa-play-circle">                            <a href="<?php the_permalink(); ?>"><span class="<?php echo 'type-' . get_post_type(); ?>"><?php _e(get_post_type(), 'torofilm'); ?></span><?php the_title(); ?></a>                        </li>                <?php }                endif;                wp_reset_query(); ?>                <li><a id="more-shm-h" href="javascript:void(0)" class="btn sm rnd"><?php _e('More results', 'torofilm'); ?></a></li>            <?php } else { ?>                <li class="loading"><i class="fas fa-spinner fa-pulse"></i></li>                <li class="error"><?php _e('No results found', 'torofilm'); ?></li>            <?php }            exit;        }    }    public function tr_movie_category()    {        if (isset($_POST['action'])) {            $limit    = $_POST['limit'];            $posttype = $_POST['post'];            $cate     = $_POST['cate'];            $mode     = $_POST['mode'];            if ($posttype == 'movies-series') {                exit();            }            if ($mode == 1 or $mode == 3) {                if ($cate == 'all') {                    $args = array(                        'post_type'      => $posttype,                        'posts_per_page' => $limit,                    );                } else {                    $args = array(                        'post_type'      => $posttype,                        'posts_per_page' => $limit,                        'cat'            => $cate                    );                }            } else {                $args = array(                    'post_type'      => $posttype,                    'posts_per_page' => $limit,                    'meta_key'            => 'views',                    'orderby'             => 'meta_value_num',                    'order'               => 'DESC'                );            }            $the_query = new WP_Query($args);            if ($the_query->have_posts()) { ?>                <?php if ($mode == 1) { ?>                    <ul class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl6e">                        <?php while ($the_query->have_posts()) : $the_query->the_post();                            get_template_part('public/partials/template/movies', 'main');                        endwhile; ?>                    </ul>                <?php } elseif ($mode == 2) { ?>                    <ul class="post-lst">                        <?php while ($the_query->have_posts()) : $the_query->the_post();                            get_template_part('public/partials/template/movies', 'sidebar');                        endwhile; ?>                    </ul>                <?php } elseif ($mode == 3) { ?>                    <ul class="post-lst rw sm rcl1 rcl2a rcl3b rcl2c rcl3d rcl4e news-lst">                        <?php while ($the_query->have_posts()) : $the_query->the_post();                            get_template_part('public/partials/template/post', 'main');                        endwhile; ?>                    </ul>            <?php }            } else {                echo '<p>' .  _e('No results found', 'torofilm') . '</p>';            }            wp_reset_query(); ?><?php exit;        }    }}