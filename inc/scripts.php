<?php
/**
 * Enqueue scripts and styles.
 */
function ppwp2_scripts() {
	$primary = get_theme_mod( 'primary_color', 'indigo' );
	$secondary = get_theme_mod( 'secondary_color', 'pink' );

	// wp_enqueue_style( 'mdlwp-mdl-css', '//storage.googleapis.com/code.getmdl.io/1.1.1/material.'.$primary.'-'.$secondary.'.min.css' );

	// wp_enqueue_style( 'mdlwp-mdl-icons', '//fonts.googleapis.com/icon?family=Material+Icons' );

	// wp_enqueue_style( 'mdlwp-mdl-roboto', '//fonts.googleapis.com/css?family=Roboto:300,400,500,700' );

	wp_enqueue_style( 'mdlwp-style', get_stylesheet_directory_uri() . '/style.min.css' );

	// wp_enqueue_script( 'mdlwp-mdl-js', '//storage.googleapis.com/code.getmdl.io/1.1.3/material.min.js', array(), '1.1.1', true );

	wp_enqueue_script( 'mdlwp-mdlwp-js', get_stylesheet_directory_uri() . '/js/dist/scripts.min.js', array('jquery'), '2.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ppwp2_scripts' );

/**
 * Remove parent theme css/js.
 */
function ppwp2_remove_parent_theme_stuff() {
    remove_action( 'wp_enqueue_scripts', 'mdlwp_scripts' );
}
add_action( 'after_setup_theme', 'ppwp2_remove_parent_theme_stuff');

/**
 * Enqueue customizer script
 */
function ppwp2_customizer_live_preview() {
	wp_enqueue_script( 'mdlwp-themecustomizer',	get_stylesheet_directory_uri() . '/js/customizer.js', array( 'jquery','customize-preview' ), '', true );
}
remove_action( 'customize_preview_init', 'mdlwp_customizer_live_preview' );
add_action( 'customize_preview_init', 'ppwp2_customizer_live_preview' );

/**
 * Fix rocketloader
 **/
function add_data_attribute($tag, $handle) {
	$replace_handles = [
		'mdlwp-mdlwp-js',
		'jquery-core'
	];

	if (in_array($handle, $replace_handles)) {
		return str_replace(' src', ' data-cfasync="false" src', $tag);
	};

	return $tag;
}

add_filter('script_loader_tag', 'add_data_attribute', 10, 2);
