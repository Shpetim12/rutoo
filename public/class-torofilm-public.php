<?php
class TOROFILM_Public
{
    private $theme_name;
    private $version;
    private $helpers;
    public function __construct($theme_name, $version)
    {
        $this->theme_name = $theme_name;
        $this->version    = $version;
    }
    public function enqueue_styles()
    {
        wp_enqueue_style($this->theme_name, TOROFILM_DIR_URI . 'public/css/torofilm-public.css', array(), $this->version, 'all');
        if (is_author()) {
            wp_enqueue_style('countries_css_public', TOROFILM_DIR_URI . 'helpers/countries/css/countrySelect.css', array(), $this->version, 'all');
        }
    }
    public function enqueue_scripts()
    {
        wp_enqueue_script('funciones_public_jquery', TOROFILM_DIR_URI . 'public/js/jquery.js',  array(), '3.0.0', true);
        wp_enqueue_script('owl_carousel', TOROFILM_DIR_URI . 'public/js/owl.carousel.min.js',  array(), $this->version, true);
        #Comments
        if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply', 'wp-includes/js/comment-reply', array(), false, true);
        }
        if (is_author()) {
            wp_enqueue_script('countries_js_public', TOROFILM_DIR_URI . 'helpers/countries/js/countrySelect.js',  array(), $this->version, true);
        }

        $trailer = false;
        if(is_singular()){
            global $post;
            $id_ms = $post->ID;
            $trailer = htmlspecialchars_decode(get_post_meta($id_ms, 'field_trailer', true));
            if (!$trailer)
                $trailer = false;
        }

        wp_enqueue_script('funciones_public_js', TOROFILM_DIR_URI . 'public/js/torofilm-public.js', array(), $this->version, true);
        #Localize Script
        $torofilm_Public = [
            'url'             => admin_url('admin-ajax.php'),
            'nonce'           => wp_create_nonce('torofilm_seg'),
            'access_error'    => __('Access error', 'torofilm'),
            'remove_favorite' => __('Removed from favorites', 'torofilm'),
            'add_favorite'    => __('Added to favorites', 'torofilm'),
            'saved'           => __('Data saved correctly', 'torofilm'),
            'warning'         => __('Image size must be less than 1MB', 'torofilm'),
            'error_upload'    => __('Upload error', 'torofilm'),
            'trailer'         => $trailer,
        ];
        wp_localize_script('funciones_public_js', 'torofilm_Public', $torofilm_Public);
        #Alternativo
        $translation_array = array('templateUrl' => get_stylesheet_directory_uri());
        wp_localize_script('funciones_public_js', 'object_name', $translation_array);
    }
}
