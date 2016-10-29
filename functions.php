<?php
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles',99);
add_action('wp_enqueue_scripts', 'child_zerif_scripts');

function child_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ) );
}
if ( get_stylesheet() !== get_template() ) {
    add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), function ( $value, $old_value ) {
         update_option( 'theme_mods_' . get_template(), $value );
         return $old_value; // prevent update to child theme mods
    }, 10, 2 );
    add_filter( 'pre_option_theme_mods_' . get_stylesheet(), function ( $default ) {
        return get_option( 'theme_mods_' . get_template(), $default );
    } );
}

function child_zerif_scripts() {

	wp_enqueue_style('zerif_font', zerif_slug_fonts_url(), array(), null );

    wp_enqueue_style( 'zerif_font_all', '//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600italic,600,700,700italic,800,800italic');

    wp_enqueue_style('zerif_bootstrap_style', get_template_directory_uri() . '/css/bootstrap.css');

    wp_style_add_data( 'zerif_bootstrap_style', 'rtl', 'replace' );

    wp_enqueue_style('zerif_fontawesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css', array(), 'v1');

    wp_enqueue_style('zerif_style', get_stylesheet_uri(), array('zerif_fontawesome'), 'v1');

    wp_enqueue_style('zerif_responsive_style', get_template_directory_uri() . '/css/responsive.css', array('zerif_style'), 'v1');

    wp_enqueue_style('zerif_ie_style', get_template_directory_uri() . '/css/ie.css', array('zerif_style'), 'v1');
    wp_style_add_data( 'zerif_ie_style', 'conditional', 'lt IE 9' );

    if ( wp_is_mobile() ){

        wp_enqueue_style( 'zerif_style_mobile', get_template_directory_uri() . '/css/style-mobile.css', array('zerif_bootstrap_style', 'zerif_style'),'v1' );

    }

    /* Bootstrap script */
    wp_enqueue_script('zerif_bootstrap_script', get_template_directory_uri() . '/js/bootstrap.min.js', array("jquery"), '20120206', true);

    /* Knob script */
    wp_enqueue_script('zerif_knob_nav', get_template_directory_uri() . '/js/jquery.knob.js', array("jquery"), '20120206', true);

    /* Smootscroll script */
    $zerif_disable_smooth_scroll = get_theme_mod('zerif_disable_smooth_scroll');
    if( isset($zerif_disable_smooth_scroll) && ($zerif_disable_smooth_scroll != 1)):
        wp_enqueue_script('zerif_smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', array("jquery"), '20120206', true);
    endif;

	/* scrollReveal script */
	if ( !wp_is_mobile() ){
		wp_enqueue_script( 'zerif_scrollReveal_script', get_template_directory_uri() . '/js/scrollReveal.js', array("jquery"), '20120206', true  );
	}

    /* zerif script */
    wp_enqueue_script('zerif_script', get_template_directory_uri() . '/js/zerif.js', array("jquery", "zerif_knob_nav"), '20120206', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {

        wp_enqueue_script('comment-reply');

    }

    /* HTML5Shiv*/
    wp_enqueue_script( 'zerif_html5', get_template_directory_uri() . '/js/html5.js');
    wp_script_add_data( 'zerif_html5', 'conditional', 'lt IE 9' );

    /* parallax effect */
    if ( !wp_is_mobile() ){

        /* include parallax only if on frontpage and the parallax effect is activated */
        $zerif_parallax_use = get_theme_mod('zerif_parallax_show');

        if ( !empty($zerif_parallax_use) && ($zerif_parallax_use == 1) && is_front_page() ):

            wp_enqueue_script( 'zerif_parallax', get_template_directory_uri() . '/js/parallax.js', array("jquery"), 'v1', true  );

        endif;
    }

	add_editor_style('/css/custom-editor-style.css');

}

?>
