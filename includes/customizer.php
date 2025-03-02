<?php
require_once TOROFILM_DIR_PATH . 'admin/customizer/class-torofilm-multiple-checkbox.php';
function my_customize_register($wp_customize)
{
    function theme_slug_sanitize_select($input, $setting)
    {
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control($setting->id)->choices;
        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
    function sanitize_multiple_checkbox($values)
    {
        $multi_values = !is_array($values) ? explode(',', $values) : $values;
        return !empty($multi_values) ? array_map('sanitize_text_field', $multi_values) : array();
    }
    function theme_slug_sanitize_checkbox($input)
    {
        return ((isset($input) && true == $input) ? true : false);
    }
    function theme_slug_sanitize_radio($input, $setting)
    {
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control($setting->id)->choices;
        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('header_image');
    /*Generate Menu Toroflix*/
    $wp_customize->add_panel('toroflix_options', array(
        'title' => 'Torofilm',
        'priority' => 30,
        'capability' => 'edit_theme_options',
    ));
        $wp_customize->add_section('header_option', array(
            'title'      => 'Header Option',
            'panel'      => 'toroflix_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));
            $wp_customize->add_setting('header_sticky', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('header_sticky', array(
                'label'    => 'Enabled Sticky Header',
                'section'  => 'header_option',
                'priority' => 2,
                'type'     => 'checkbox'
            ));
            #Slider Checkbox
            $wp_customize->add_setting('header_login', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('header_login', array(
                'label'    => 'Enabled Login User',
                'section'  => 'header_option',
                'priority' => 2,
                'type'     => 'checkbox'
            ));
        #Block Home
        $wp_customize->add_section('block_home', array(
            'title' => __('Home', 'torofilm'),
            'panel' => 'toroflix_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
    $wp_customize->add_setting('disable_image_header', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('disable_image_header', array(
        'label'    => 'Disable Image on Header',
        'section'  => 'block_home',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('setting_image_header', array(
        //default value
        'capability'        => 'edit_theme_options',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_header_control', array(
        'label'     => 'Header Image',
        'settings'  => 'setting_image_header',
        'section'   => 'block_home',
        'priority' => 2,
    )));
    //Image Header - hotlink 
    $wp_customize->add_setting('setting_image_header_hotlink', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('setting_image_header_hotlink', array(
        'label'    => 'Image Header URL external',
        'section'  => 'block_home',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('disable_image_footer', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('disable_image_footer', array(
        'label'    => 'Disble Image on Footer',
        'section'  => 'block_home',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('setting_image_footer', array(
        //default value
        'capability'        => 'edit_theme_options',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_footer_control', array(
        'label'     => 'Footer Image',
        'settings'  => 'setting_image_footer',
        'section'   => 'block_home',
        'priority' => 2,
    )));
    //Image Footer - hotlink 
    $wp_customize->add_setting('setting_image_footer_hotlink', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('setting_image_footer_hotlink', array(
        'label'    => 'Image Footer URL external',
        'section'  => 'block_home',
        'priority' => 2,
        'type'     => 'text',
    ));
    #MOVIES
    $wp_customize->add_section('section_movies', array(
        'title' => 'Movies',
        'panel' => 'toroflix_options',
        'priority' => 1,
        'capability' => 'edit_theme_options',
    ));

        /* Sizes Images header */
        $wp_customize->add_setting('size_image_header_movies', array(
            'type'              => 'option',
            'default'           => 'right',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_select',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('size_image_header_movies', array(
            'label'    => 'Size of image on header (by default is high)',
            'section'  => 'section_movies',
            'priority' => 2,
            'type'     => 'select',
            'choices'  => array(
                'thumbnail' => 'Low',
                'medium'    => 'Medium',
                'original'  => 'High',
                'none'      => 'None',
            )
        ));
        $wp_customize->add_setting('size_image_footer_movies', array(
            'type'              => 'option',
            'default'           => 'right',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_select',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('size_image_footer_movies', array(
            'label'    => 'Size of image on footer (by default is high)',
            'section'  => 'section_movies',
            'priority' => 2,
            'type'     => 'select',
            'choices'  => array(
                'thumbnail' => 'Low',
                'medium'    => 'Medium',
                'original'  => 'High',
                'none'      => 'None',
            )
        ));
       
    #SERIES
    $wp_customize->add_section('section_series', array(
        'title'      => 'Series',
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
        /* Sizes Images header */
        $wp_customize->add_setting('size_image_header_series', array(
            'type'              => 'option',
            'default'           => 'right',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_select',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('size_image_header_series', array(
            'label'    => 'Size of image on header (by default is high)',
            'section'  => 'section_series',
            'priority' => 2,
            'type'     => 'select',
            'choices'  => array(
                'thumbnail' => 'Low',
                'medium'    => 'Medium',
                'original'  => 'High',
                'none'      => 'None',
            )
        ));
        $wp_customize->add_setting('size_image_footer_series', array(
            'type'              => 'option',
            'default'           => 'right',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_select',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('size_image_footer_series', array(
            'label'    => 'Size of image on footer (by default is high)',
            'section'  => 'section_series',
            'priority' => 2,
            'type'     => 'select',
            'choices'  => array(
                'thumbnail' => 'Low',
                'medium'    => 'Medium',
                'original'  => 'High',
                'none'      => 'None',
            )
        ));
        
    #EPISODES
    $wp_customize->add_section('section_episodes', array(
        'title'      => 'Episodes',
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
    #Related Activation
    $wp_customize->add_setting('disable_related_episodes', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('disable_related_episodes', array(
        'label'    => 'Disabled Related',
        'section'  => 'section_episodes',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('disable_thumbs_episodes', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('disable_thumbs_episodes', array(
        'label'    => 'Disabled Thumbs',
        'section'  => 'section_episodes',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('title_related_episodes', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('title_related_episodes', array(
        'label'    => 'Title of Section',
        'section'  => 'section_episodes',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('related_episodes_number', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint'
    ));
    $wp_customize->add_control('related_episodes_number', array(
        'label'    => 'Number Items',
        'section'  => 'section_episodes',
        'priority' => 2,
        'type'     => 'number',
    ));
    #Player
    $wp_customize->add_section('player_toroflix', array(
        'title'      => 'Player',
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));

    $wp_customize->add_setting( 'enable_tab_lang', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('enable_tab_lang', array(
        'label'    => __( 'Enable tabs by language' ),
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'checkbox'
    ));


    $wp_customize->add_setting('player_encrypt', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('player_encrypt', array(
        'label'    => 'Disabled Player Encrypt',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('player_advertising', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('player_advertising', array(
        'label'    => 'Disabled Player Advertising',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('player_fake', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('player_fake', array(
        'label'    => 'Disabled Player Fake',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('player_fake_blank', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('player_fake_blank', array(
        'label'    => 'Disabled Player Fake blank',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('player_fake_url', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
    ));
    $wp_customize->add_control('player_fake_url', array(
        'label'    => 'Player Fake url',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('player_advertising_code', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
    ));
    $wp_customize->add_control('player_advertising_code', array(
        'label'    => 'Advertising code',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'textarea',
    ));
    #Sidebar
    $wp_customize->add_section('sidebar_toroflix', array(
        'title' => 'Sidebar',
        'panel' => 'toroflix_options',
        'priority' => 1,
        'capability' => 'edit_theme_options',
    ));
    #Slider Type
    $wp_customize->add_setting('sidebar_type', array(
        'type'              => 'option',
        'default'           => 'right',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_select',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('sidebar_type', array(
        'label'    => 'Sidebar Home',
        'section'  => 'sidebar_toroflix',
        'priority' => 2,
        'type'     => 'select',
        'choices'  => array(
            'side-right' => 'Right',
            'side-left'  => 'Left',
            'side-none'  => 'Hide',
        )
    ));
    $wp_customize->add_setting('sidebar_type_movies_series', array(
        'type'              => 'option',
        'default'           => 'right',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_select',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('sidebar_type_movies_series', array(
        'label'    => 'Sidebar Movies and Series',
        'section'  => 'sidebar_toroflix',
        'priority' => 2,
        'type'     => 'select',
        'choices'  => array(
            'side-right' => 'Right',
            'side-left'  => 'Left',
            'side-none'  => 'Hide',
        )
    ));
    $wp_customize->add_setting('sidebar_type_category', array(
        'type'              => 'option',
        'default'           => 'right',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_select',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('sidebar_type_category', array(
        'label'    => 'Sidebar Category',
        'section'  => 'sidebar_toroflix',
        'priority' => 2,
        'type'     => 'select',
        'choices'  => array(
            'side-right' => 'Right',
            'side-left'  => 'Left',
            'side-none'  => 'Hide',
        )
    ));
    $wp_customize->add_section('poster_option', array(
        'title'      => __('Poster Option', 'torofilm'),
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_setting('poster_option_views', array(
        'type'              => 'option',
        'default'           => array('popular', 'movies', 'series', 'season', 'episode'),
        'sanitize_callback' => 'sanitize_multiple_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new TOROFLIX_multiple_checbox($wp_customize, 'poster_option_views', array(
        'label'       => __('Poster Option View', 'torofilm'),
        'description' => __('Select options to show in poster of series and movies', 'torofilm'),
        'section'     => 'poster_option',
        'choices'     => array(
            'year' => 'Year',
            'lang' => 'Language',
            'qual' => 'Quality',
        ),
        'priority' => 2,
    )));

    /* ADS SECTION */
    $wp_customize->add_section('ads_section', array(
        'title'      => __('ADS', 'torofilm'),
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));

        $wp_customize->add_setting('ads_top_player', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options'
        ));
        $wp_customize->add_control('ads_top_player', array(
            'label'    => __('Top player', 'torofilm'),
            'section'  => 'ads_section',
            'priority' => 2,
            'type'     => 'textarea',
        ));

        $wp_customize->add_setting('ads_bottom_player', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('ads_bottom_player', array(
            'label'    => __('Bottom player', 'torofilm'),
            'section'  => 'ads_section',
            'priority' => 2,
            'type'     => 'textarea',
        ));

    #Footer
    $wp_customize->add_section('footer_section', array(
        'title'      => __('Footer', 'torofilm'),
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
    #Footer Text
    $wp_customize->add_setting('text_footer', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('text_footer', array(
        'label'    => __('Text', 'torofilm'),
        'section'  => 'footer_section',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('text_footer', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('text_footer', array(
        'label'    => __('Text', 'torofilm'),
        'section'  => 'footer_section',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('social_facebook', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('social_facebook', array(
        'label'    => 'Social Facebook',
        'section'  => 'footer_section',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('social_twitter', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('social_twitter', array(
        'label'    => 'Social Twitter',
        'section'  => 'footer_section',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('social_instagram', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('social_instagram', array(
        'label'    => 'Social Instagram',
        'section'  => 'footer_section',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('logo_footer', array(
        //default value
        'capability'        => 'edit_theme_options',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_footer_control', array(
        'label'     => 'Logo Footer',
        'settings'  => 'logo_footer',
        'section'   => 'footer_section',
        'priority' => 2,
    )));
    #Analityc Section 
    $wp_customize->add_section('section_analityc', array(
        'title'      => __('Analityc', 'torofilm'),
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_setting('analityc_code', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
    ));
    $wp_customize->add_control('analityc_code', array(
        'label'    => __('Analityc code', 'torofilm'),
        'section'  => 'section_analityc',
        'priority' => 2,
        'type'     => 'textarea',
    ));
    $wp_customize->add_setting('analityc_position', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_select'
    ));
    $wp_customize->add_control('analityc_position', array(
        'label'       => __('Analityc position', 'torofilm'),
        'section'     => 'section_analityc',
        'priority'    => 2,
        'type'        => 'select',
        'description' => 'By default is header',
        'choices'     => array(
            'header' => 'Header',
            'footer' => 'Footer',
        )
    ));
}
add_action('customize_register', 'my_customize_register');
