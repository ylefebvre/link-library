<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package link-library
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/#enqueuing-block-scripts
 */
function link_library_main_block_init() {
	$dir = dirname( __FILE__ );

	$block_js = 'link-library-main/block.js';
	wp_register_script(
		'link-library-main-block-editor',
		plugins_url( $block_js, __FILE__ ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
		filemtime( "$dir/$block_js" )
	);

	$editor_css = 'link-library-main/editor.css';
	wp_register_style(
		'link-library-main-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(
			'wp-blocks',
		),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'link-library-main/style.css';
	wp_register_style(
		'link-library-main-block',
		plugins_url( $style_css, __FILE__ ),
		array(
			'wp-blocks',
		),
		filemtime( "$dir/$style_css" )
	);

	global $my_link_library_plugin;

	register_block_type( 'link-library/link-library-main', array(
		'editor_script' => 'link-library-main-block-editor',
		'editor_style'  => 'link-library-main-block-editor',
		'style'         => 'link-library-main-block',
		'render_callback' => $my_link_library_plugin->link_library_func(),
	) );
}
add_action( 'init', 'link_library_main_block_init' );
