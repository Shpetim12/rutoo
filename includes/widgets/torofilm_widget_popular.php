<?php 
add_action( 'widgets_init', function(){
    register_widget( 'torofilm_wdgt_popular' );
});
class torofilm_wdgt_popular extends WP_Widget {
    #Sets up the widgets name etc
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget_top',
            'description' => 'Show Movies and Series Popular',
        );
        parent::__construct( 'torofilm_wdgt_popular', 'Torofilm Popular', $widget_ops );
    }
    # Display frontend
    public function widget( $argus, $instance ) {
        echo $argus['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $argus['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $argus['after_title'];
        } 
        $activate_movies = ( ! empty( $instance['activate_movies'] ) ) ? $instance['activate_movies'] : false;
        $activate_series = ( ! empty( $instance['activate_series'] ) ) ? $instance['activate_series'] : false;
        $number          = ( ! empty( $instance['number'] ) ) ? (int) ( $instance['number'] ) : 5;
        $number_series   = ( ! empty( $instance['number_series'] ) ) ? (int) ( $instance['number_series'] ) : 5;
        ?>
        <ul class="aa-tbs ax-tbs" data-tbs="<?php echo $this->id; ?>-aa-top">
            <?php if($activate_movies){ ?>
            <li><a data-category="all" data-mode="2" data-limit="<?php echo $number; ?>" data-post="movies" href="#<?php echo $this->id; ?>-all" class="on"><?php _e('Movies', 'torofilm'); ?></a></li><?php } ?>
            <?php if($activate_series){ ?>
            <li><a data-category="all" data-mode="2" data-limit="<?php echo $number_series ?>" data-post="series" href="#<?php echo $this->id; ?>-all-b"><?php _e('Series', 'torofilm'); ?></a></li><?php } ?>
        </ul>
        <div class="aa-cn" id="<?php echo $this->id; ?>-aa-top">
            <!-- a -->
            <?php if($activate_movies or $activate_series){ ?>
            <div id="<?php echo $this->id; ?>-all" class="aa-tb hdd on">
                <ul class="post-lst">
                    <?php 
                    if($activate_movies){
                        $args = array(
                            'post_type'      => 'movies',
                            'posts_per_page' => $number,
                            'meta_key'            => 'views', 
                            'orderby'             => 'meta_value_num', 
                            'order'               => 'DESC'
                        ); 
                    } elseif($activate_series){
                        $args = array(
                            'post_type'      => 'series',
                            'posts_per_page' => $number_series,
                            'meta_key'            => 'views', 
                            'orderby'             => 'meta_value_num', 
                            'order'               => 'DESC'
                        );
                    }
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                        while ( $the_query->have_posts() ) : $the_query->the_post(); 
                            get_template_part( 'public/partials/template/movies', 'sidebar' );
                        endwhile; 
                    endif; wp_reset_query(); ?>
                </ul>
            </div>
            <?php } ?>
            <!-- b -->
            <div id="<?php echo $this->id; ?>-all-b" class="aa-tb hdd">
            </div>
        </div>
        <?php echo $argus['after_widget'];
    }
    #Parameters Form of Widget
    public function form( $instance ) {
        $title           = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $number          = isset( $instance['number'] ) ? (int)( $instance['number'] ) : 5;
        $activate_movies = isset( $instance['activate_movies'] ) ? ( $instance['activate_movies'] ) : false;
        $activate_series = isset( $instance['activate_series'] ) ? ( $instance['activate_series'] ) : false;
        $number_series   = isset( $instance['number_series'] ) ? (int)( $instance['number_series'] ) : 5; 
        ?>
        <div class="wdgt-tt">
            <div>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'torofilm'); ?>:</label>
                <div class="fr-input">
                    <span class="dashicons dashicons-edit-large"></span>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
                </div>
            </div>
            <h3 class="fr-input-cat"><?php echo _e('Movies', 'torofilm'); ?> <input type="checkbox"  id="<?php echo $this->get_field_id( 'activate_movies' ); ?>" name="<?php echo $this->get_field_name( 'activate_movies' ); ?>" <?php if($activate_movies){echo 'checked';} ?>></h3>
            <div>
                <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php  _e('Number', 'torofilm'); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-shortcode"></span>
                    <input style="width: 60px;" class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
                </div>
            </div>
            <h3 class="fr-input-cat"><?php echo _e('Series', 'torofilm'); ?><input type="checkbox"  id="<?php echo $this->get_field_id( 'activate_series' ); ?>" name="<?php echo $this->get_field_name( 'activate_series' ); ?>" <?php if($activate_series){echo 'checked';} ?>></h3>
            
            <div>
                <label for="<?php echo $this->get_field_id( 'number_series' ); ?>"><?php _e( 'Number', 'torofilm' ); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-shortcode"></span>
                    <input class="tiny-text" id="<?php echo $this->get_field_id( 'number_series' ); ?>" name="<?php echo $this->get_field_name( 'number_series' ); ?>" type="number" step="1" min="1" value="<?php echo $number_series; ?>" size="3" />
                </div>
            </div>
        </div>
        <?php
    }
    #Save Data
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        foreach( $new_instance as $key => $value )
        {
            $updated_instance[$key] = sanitize_text_field($value);
        }
        return $updated_instance;
    }
}       