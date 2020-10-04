<?php
if (! defined ( 'ABSPATH' ))
	exit (); // Exit if accessed directly

/* ----------------------------------------------------------------------------------- */
	/* Define the URL and DIR path */
	/* ----------------------------------------------------------------------------------- */

define ( 'thumbs_rating_url', plugins_url () . "/" . dirname ( plugin_basename ( __FILE__ ) ) );
define ( 'thumbs_rating_path', WP_PLUGIN_DIR . "/" . dirname ( plugin_basename ( __FILE__ ) ) );

/* ----------------------------------------------------------------------------------- */
/* Init */
/* Localization */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_init' )) :
	function thumbs_rating_init() {
		load_plugin_textdomain ( 'thumbs-rating', false, basename ( dirname ( __FILE__ ) ) . '/languages' );
	}
	add_action ( 'plugins_loaded', 'thumbs_rating_init' );


endif;

/* ----------------------------------------------------------------------------------- */
/* Encue the Scripts for the Ajax call */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_scripts' )) :
	function thumbs_rating_scripts() {
		wp_enqueue_script ( 'thumbs_rating_scripts', thumbs_rating_url . '/js/general.js', array (
				'jquery'
		), '4.0.1' );
		wp_localize_script ( 'thumbs_rating_scripts', 'thumbs_rating_ajax', array (
				'ajax_url' => admin_url ( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce ( 'thumbs-rating-nonce' )
		) );
	}
	add_action ( 'wp_enqueue_scripts', 'thumbs_rating_scripts' );


endif;

/* ----------------------------------------------------------------------------------- */
/* Encue the Styles for the Thumbs up/down */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_styles' )) :
	function thumbs_rating_styles() {
		wp_register_style ( "thumbs_rating_styles", thumbs_rating_url . '/css/style.css', "", "1.0.0" );
		wp_enqueue_style ( 'thumbs_rating_styles' );
	}
	add_action ( 'wp_enqueue_scripts', 'thumbs_rating_styles' );


endif;

/* ----------------------------------------------------------------------------------- */
/* Add the thumbs up/down links to the content */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_getlink' )) :
	function thumbs_rating_getlink($post_ID = '', $type_of_vote = '', $show_div_wrap = true) {

		// Sanatize params
		$post_ID = intval ( sanitize_text_field ( $post_ID ) );
		$type_of_vote = intval ( sanitize_text_field ( $type_of_vote ) );

		$thumbs_rating_link = "";

		if ($post_ID == '')
			$post_ID = get_the_ID ();

		$thumbs_rating_up_count = get_post_meta ( $post_ID, '_thumbs_rating_up', true ) != '' ? get_post_meta ( $post_ID, '_thumbs_rating_up', true ) : '0';
		$thumbs_rating_down_count = get_post_meta ( $post_ID, '_thumbs_rating_down', true ) != '' ? get_post_meta ( $post_ID, '_thumbs_rating_down', true ) : '0';

		$voted  = isset( $type_of_vote ) && $type_of_vote == 2 ? false : true;

		$link_button = '<span class="likebtn-wrapper lb-loaded lb-style-white lb-popup-position-top lb-popup-style-light lb-unlike-not-allowed">
							<span class="likebtn-button lb-like thumbs-rating-up">
								<span onclick="thumbs_rating_vote(this, ' . $post_ID . ', 1);" class="lb-a">
									<span class="likebtn-icon lb-like-icon">&nbsp;</span>
									<span class="likebtn-label lb-like-label">Like</span>
								</span>
								<span class="lb-count" data-count="'. $thumbs_rating_up_count . '" style="display: inline-block;">'. $thumbs_rating_up_count . '</span>
							</span>
							<!-- <span class="likebtn-button lb-dislike thumbs-rating-down">
								<span onclick="thumbs_rating_vote(this, ' . $post_ID . ', 2);" class="lb-a">
									<span class="likebtn-icon lb-dislike-icon">&nbsp;</span>
								</span>
								<span class="lb-count" data-count="'. $thumbs_rating_down_count . '" style="display: inline-block;">'. $thumbs_rating_down_count . '</span>
							</span> -->
						</span>';

		if ( $show_div_wrap ) {
			$thumbs_rating_link = '<div  class="thumbs-rating-container" id="thumbs-rating-' . $post_ID . '" data-content-id="' . $post_ID . '">';
		}

		$thumbs_rating_link .= $link_button;

		if ( $show_div_wrap ) {
			$thumbs_rating_link .= '</div>';
		}

		return $thumbs_rating_link;
	}


endif;

/* ----------------------------------------------------------------------------------- */
/* Handle the Ajax request to vote up or down */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_add_vote_callback' )) :
	function thumbs_rating_add_vote_callback() {

		// Check the nonce - security
		check_ajax_referer ( 'thumbs-rating-nonce', 'nonce' );

		global $wpdb;

		// Get the POST values

		$post_ID = intval ( $_POST ['postid'] );
		$type_of_vote = intval ( $_POST ['type'] );
		$selection = '';

		if ( isset( $_POST['selection'] ) ) {
			$selection = intval ( $_POST ['selection'] );
		}

		$alternate = '';
		if ( isset( $_POST ['alternate'] ) ) {
			$alternate = intval ( $_POST ['alternate'] );
		}

		$serveraddress = $_SERVER['REMOTE_ADDR'];
		$post_voter_ips = get_option ( 'link_library_voter_ips' );
		if ( empty( $post_voter_ips ) ) {
			$post_voter_ips = array();
		}
		$current_ip_votes = $post_voter_ips[$serveraddress];

		$user_id = get_current_user_id();
		$post_voter_users = get_option ( 'link_library_voter_users' );
		if ( 0 != $user_id ) {
			if ( empty( $post_voter_users ) ) {
				$post_voter_users = array();
			}
			$current_user_votes = $post_voter_users[$user_id];
		}

		// Check the type and retrieve the meta values

		if ($type_of_vote == 1) {

			if ( !in_array( $post_ID, $current_ip_votes ) && $selection == 1 ) {
				$current_ip_votes[] = $post_ID;

				if ( 0 != $user_id ) {
					$current_user_votes[] = $post_ID;
				}
			} elseif ( in_array( $post_ID, $current_ip_votes ) && $selection == 0) {
				$key = array_search( $post_ID, $current_ip_votes );
				if ( $key !== false ) {
					unset( $current_ip_votes[$key] );
				}

				if ( 0 != $user_id ) {
					$user_key = array_search( $post_ID, $current_user_votes );
					if ( $user_key !== false ) {
						unset( $current_user_votes[$user_key] );
					}
				}
			}

			if ( empty( $current_ip_votes ) ) {
				unset( $post_voter_ips[$serveraddress] );
			} else {
				$post_voter_ips[$serveraddress] = $current_ip_votes;
			}

			if ( 0 != $user_id ) {
				if ( empty( $current_user_votes ) ) {
					unset( $post_voter_users[$user_id] );
				} else {
					$post_voter_users[$user_id] = $current_user_votes;
				}
			}

			update_option ( 'link_library_voter_ips', $post_voter_ips );
			update_option ( 'link_library_voter_users', $post_voter_users );

			$other_meta_name = '_thumbs_rating_down';
			$meta_name = "_thumbs_rating_up";
		} elseif ($type_of_vote == 2) {
			$other_meta_name = "_thumbs_rating_up";
			$meta_name = "_thumbs_rating_down";
		}

		if ($selection == 0){
			$thumbs_rating_count = get_post_meta ( $post_ID, $meta_name, true ) != '' ? get_post_meta ( $post_ID, $meta_name, true ) : '0';
			$thumbs_rating_count = $thumbs_rating_count - 1;

		} elseif ($selection == 1) {
			$thumbs_rating_count = get_post_meta ( $post_ID, $meta_name, true ) != '' ? get_post_meta ( $post_ID, $meta_name, true ) : '0';
			$thumbs_rating_count = $thumbs_rating_count + 1;

			if ($alternate == 1){
				$thumbs_alternate_rating_count = get_post_meta ( $post_ID, $other_meta_name, true ) != '' ? get_post_meta ( $post_ID, $other_meta_name, true ) : '0';
				$thumbs_alternate_rating_count = $thumbs_alternate_rating_count - 1;
				update_post_meta ( $post_ID, $other_meta_name, $thumbs_alternate_rating_count );
			}
		}

		update_post_meta ( $post_ID, $meta_name, $thumbs_rating_count );

		// Retrieve the meta value from the DB
		$results = thumbs_rating_getlink ( $post_ID, $type_of_vote, false );

		die ( $results ) ;
	}

	add_action ( 'wp_ajax_thumbs_rating_add_vote', 'thumbs_rating_add_vote_callback' );
	add_action ( 'wp_ajax_nopriv_thumbs_rating_add_vote', 'thumbs_rating_add_vote_callback' );


endif;

/* ----------------------------------------------------------------------------------- */
/* Add Votes +/- columns to the Admin */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_columns' )) :
	function thumbs_rating_columns($columns) {
		return array_merge ( $columns, array (
				'thumbs_rating_up_count' => __ ( 'Up Votes', 'thumbs-rating' ),
				'thumbs_rating_down_count' => __ ( 'Down Votes', 'thumbs-rating' )
		) );
	}
	add_filter ( 'manage_posts_columns', 'thumbs_rating_columns' );
	add_filter ( 'manage_pages_columns', 'thumbs_rating_columns' );


endif;

/* ----------------------------------------------------------------------------------- */
/* Add Values to the new Admin columns */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_column_values' )) :
	function thumbs_rating_column_values($column, $post_id) {
		switch ($column) {
			case 'thumbs_rating_up_count' :
				echo get_post_meta ( $post_id, '_thumbs_rating_up', true ) != '' ? "+" . get_post_meta ( $post_id, '_thumbs_rating_up', true ) : '0';
				break;

			case 'thumbs_rating_down_count' :
				echo get_post_meta ( $post_id, '_thumbs_rating_down', true ) != '' ? "-" . get_post_meta ( $post_id, '_thumbs_rating_down', true ) : '0';
				break;
		}
	}

	add_action ( 'manage_posts_custom_column', 'thumbs_rating_column_values', 10, 2 );
	add_action ( 'manage_pages_custom_column', 'thumbs_rating_column_values', 10, 2 );


endif;

/* ----------------------------------------------------------------------------------- */
/* Make our columns are sortable */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_sortable_columns' )) :
	function thumbs_rating_sortable_columns($columns) {
		$columns ['thumbs_rating_up_count'] = 'thumbs_rating_up_count';
		$columns ['thumbs_rating_down_count'] = 'thumbs_rating_down_count';
		return $columns;
	}

	// Apply this to all public post types

	add_action ( 'admin_init', 'thumbs_rating_sort_all_public_post_types' );
	function thumbs_rating_sort_all_public_post_types() {
		foreach ( get_post_types ( array (
				'public' => true
		), 'names' ) as $post_type_name ) {

			add_action ( 'manage_edit-' . $post_type_name . '_sortable_columns', 'thumbs_rating_sortable_columns' );
		}

		add_filter ( 'request', 'thumbs_rating_column_sort_orderby' );
	}

	// Tell WordPress our fields are numeric
	function thumbs_rating_column_sort_orderby($vars) {
		if (isset ( $vars ['orderby'] ) && 'thumbs_rating_up_count' == $vars ['orderby']) {
			$vars = array_merge ( $vars, array (
					'meta_key' => '_thumbs_rating_up',
					'orderby' => 'meta_value_num'
			) );
		}
		if (isset ( $vars ['orderby'] ) && 'thumbs_rating_down_count' == $vars ['orderby']) {
			$vars = array_merge ( $vars, array (
					'meta_key' => '_thumbs_rating_down',
					'orderby' => 'meta_value_num'
			) );
		}
		return $vars;
	}


endif;

/* ----------------------------------------------------------------------------------- */
/* Print our JavaScript function in the footer. We want to check if the user has already voted on the page load */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_check' )) :
	function thumbs_rating_check() {

		$serveraddress = $_SERVER['REMOTE_ADDR'];
		$post_voter_ips = get_option ( 'link_library_voter_ips' );
		$current_ip_votes = array();

		if ( isset( $post_voter_ips[$serveraddress] ) ) {
			$current_ip_votes = $post_voter_ips[$serveraddress];
		}

		$json_array_ip = json_encode( $current_ip_votes );

		$user_id = get_current_user_id();
		$current_user_votes = array();
		if ( 0 != $user_id ) {
			$post_voter_users = get_option ( 'link_library_voter_users' );
			if ( !empty( $post_voter_users ) && isset( $post_voter_users[$user_id] ) ) {
				$current_user_votes = $post_voter_users[$user_id];
			}
		}
		$json_array_users = json_encode( $current_user_votes );

		$output = "<script>\n";
		$output .= "\tjQuery(document).ready(function() {\n";
		$output .= "\t\tvar current_ip_votes = " . $json_array_ip . ";\n";
		$output .= "\t\tvar current_user_votes = " . $json_array_users . ";\n";

		$output .= "\t\tupdateCount();\n";

		$output .= "\t\tfunction updateCount () {\n";
		$output .= "\t\t\tjQuery( '.thumbs-rating-container' ).each( function() {\n";
		$output .= "\t\t\t\tvar icon_container = jQuery( this );\n";
		$output .= "\t\t\t\tvar content_id  = icon_container.data('content-id');\n";
		$output .= "\t\t\t\tvar vote_count  = icon_container.find('.lb-count').attr('data-count');\n";
		$output .= "\t\t\t\tif ( ( current_ip_votes.includes( content_id ) || current_user_votes.includes( content_id ) ) && vote_count > 0 ) {\n";
		$output .= "\t\t\t\t\ticon_container.find('.likebtn-button.lb-like').addClass('thumbs-rating-voted lb-voted');\n";
		$output .= "\t\t\t\t}\n";
		$output .= "\t\t\t});\n";
		$output .= "\t\t};\n";
		$output .= "});\n";
		$output .= "</script>\n";

		return $output;
	}

endif;

/* ----------------------------------------------------------------------------------- */
/* Two functions to show the ratings values in your theme */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_show_up_votes_func' )) :
	function thumbs_rating_show_up_votes_func($atts) {

		extract ( shortcode_atts ( array (
				'post_id' => get_the_ID ()
		), $atts, 'thumbs_rating_show_up_votes' ) );

		$post_id = intval ( sanitize_text_field ( $post_id ) );
		return renderVotesCount($post_id, 1);

		//return get_post_meta ( $post_id, '_thumbs_rating_up', true ) != '' ? get_post_meta ( $post_id, '_thumbs_rating_up', true ) : '0';
	}
	add_shortcode( 'thumbs_rating_show_up_votes', 'thumbs_rating_show_up_votes_func' );
endif;

if (! function_exists ( 'thumbs_rating_show_down_votes_func' )) :
	function thumbs_rating_show_down_votes_func($post_id = "") {

		extract ( shortcode_atts ( array (
				'post_id' => get_the_ID ()
		), $atts, 'thumbs_rating_show_down_votes' ) );

		$post_id = intval ( sanitize_text_field ( $post_id ) );

		return renderVotesCount($post_id, 2);
		//return get_post_meta ( $post_id, '_thumbs_rating_down', true ) != '' ? get_post_meta ( $post_id, '_thumbs_rating_down', true ) : '0';
	}
	add_shortcode( 'thumbs_rating_show_down_votes', 'thumbs_rating_show_down_votes_func' );
endif;

function renderVotesCount($post_id, $type) {
	// Sanatize params
	$post_ID = intval ( sanitize_text_field ( $post_id ) );
	$type = intval ( sanitize_text_field ( $type ) );

	$thumbs_rating_link = "";

	if($type == 1 ){
		$thumbs_rating_up_count = get_post_meta ( $post_ID, '_thumbs_rating_up', true ) != '' ? get_post_meta ( $post_ID, '_thumbs_rating_up', true ) : '0';
		$link_button = '<span class="likebtn-wrapper lb-loaded lb-style-white lb-popup-position-top lb-popup-style-light lb-unlike-not-allowed">
							<span class="likebtn-button lb-like thumbs-rating-up">
								<span class="lb-a">
									<span class="likebtn-icon lb-like-icon">&nbsp;</span>
									<span class="likebtn-label lb-like-label">Like</span>
								</span>
								<span class="lb-count" data-count="'. $thumbs_rating_up_count . '" style="display: inline-block;">'. $thumbs_rating_up_count . '</span>
							</span>';
	} elseif ($type == 2) {
		$thumbs_rating_down_count = get_post_meta ( $post_ID, '_thumbs_rating_down', true ) != '' ? get_post_meta ( $post_ID, '_thumbs_rating_down', true ) : '0';
		$link_button = '<span class="likebtn-wrapper lb-loaded lb-style-white lb-popup-position-top lb-popup-style-light lb-unlike-not-allowed">
							<span class="likebtn-button lb-dislike thumbs-rating-down">
								<span class="lb-a">
									<span class="likebtn-icon lb-dislike-icon">&nbsp;</span>
								</span>
								<span class="lb-count" data-count="'. $thumbs_rating_down_count . '" style="display: inline-block;">'. $thumbs_rating_down_count . '</span>
							</span>
						</span>';
	}
	$thumbs_rating_link = '<div  class="thumbs-rating-container" id="thumbs-rating-' . $post_ID . '" data-content-id="' . $post_ID . '">';
	$thumbs_rating_link .= $link_button;
	$thumbs_rating_link .= '</div>';

	return $thumbs_rating_link ;
}

/* ----------------------------------------------------------------------------------- */
/* Top Votes Shortcode [thumbs_rating_top] */
/* ----------------------------------------------------------------------------------- */

if (! function_exists ( 'thumbs_rating_top_func' )) :
	function thumbs_rating_top_func($atts) {
		$return = '';

		// Parameters accepted

		extract ( shortcode_atts ( array (
				'exclude_posts' => '',
				'type' => 'positive',
				'posts_per_page' => 5,
				'category' => '',
				'show_votes' => 'yes',
				'post_type' => 'any',
				'show_both' => 'no',
				'order' => 'DESC',
				'orderby' => 'meta_value_num'
		), $atts ) );

		// Check wich meta_key the user wants

		if ($type == 'positive') {

			$meta_key = '_thumbs_rating_up';
			$other_meta_key = '_thumbs_rating_down';
			$sign = "+";
			$other_sign = "-";
		} else {
			$meta_key = '_thumbs_rating_down';
			$other_meta_key = '_thumbs_rating_up';
			$sign = "-";
			$other_sign = "+";
		}

		// Build up the args array

		$args = array (
				'post__not_in' => explode ( ",", $exclude_posts ),
				'post_type' => $post_type,
				'post_status' => 'publish',
				'cat' => $category,
				'pagination' => false,
				'posts_per_page' => $posts_per_page,
				'cache_results' => true,
				'meta_key' => $meta_key,
				'order' => $order,
				'orderby' => $orderby,
				'ignore_sticky_posts' => true
		);

		// Get the posts

		$thumbs_ratings_top_query = new WP_Query ( $args );

		// Build the post list

		if ($thumbs_ratings_top_query->have_posts ()) :

			$return .= '<ol class="thumbs-rating-top-list">';

			while ( $thumbs_ratings_top_query->have_posts () ) {

				$thumbs_ratings_top_query->the_post ();

				$return .= '<li>';

				// Do something here to fetch sthe image and attach it to the output

				$return .= '<div class="object_fit">' . get_the_post_thumbnail ( null, $size, $attr ) . '</div>';

				// $return .= '<div> </div>';

				$return .= '<a href="' . get_permalink () . '">' . get_the_title () . '</a>';

				if ($show_votes == "yes") {

					// Get the votes

					$meta_values = get_post_meta ( get_the_ID (), $meta_key );

					// Add the votes to the HTML

					$return .= ' (' . $sign;

					if (sizeof ( $meta_values ) > 0) {

						$return .= $meta_values [0];
					} else {

						$return .= "0";
					}

					// Show the other votes if needed

					if ($show_both == 'yes') {

						$other_meta_values = get_post_meta ( get_the_ID (), $other_meta_key );

						$return .= " " . $other_sign;

						if (sizeof ( $other_meta_values ) > 0) {

							$return .= $other_meta_values [0];
						} else {

							$return .= "0";
						}
					}

					$return .= ')';
				}
			}

			$return .= '</li>';

			$return .= '</ol>';

			// Reset the post data or the sky will fall

			wp_reset_postdata ();


		endif;

		return $return;
	}

	add_shortcode ( 'thumbs_rating_top', 'thumbs_rating_top_func' );

endif;

/* ----------------------------------------------------------------------------------- */
/* Create Shortcode for the buttons */
/* ----------------------------------------------------------------------------------- */
function thumbs_rating_shortcode_func($atts) {
	$return = thumbs_rating_getlink ();

	return $return;
}
add_shortcode ( 'thumbs-rating-buttons', 'thumbs_rating_shortcode_func' );
