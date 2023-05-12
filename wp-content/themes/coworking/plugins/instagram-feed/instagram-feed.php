<?php
/* Instagram Feed support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'coworking_instagram_feed_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'coworking_instagram_feed_theme_setup9', 9 );
	function coworking_instagram_feed_theme_setup9() {
		if ( coworking_exists_instagram_feed() ) {
			add_action( 'wp_enqueue_scripts', 'coworking_instagram_feed_frontend_scripts_responsive', 2000 );
			add_action( 'trx_addons_action_load_scripts_front_instagram_feed', 'coworking_instagram_feed_frontend_scripts_responsive', 10, 1 );
			add_filter( 'coworking_filter_merge_styles_responsive', 'coworking_instagram_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'coworking_filter_tgmpa_required_plugins', 'coworking_instagram_feed_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'coworking_instagram_feed_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('coworking_filter_tgmpa_required_plugins',	'coworking_instagram_feed_tgmpa_required_plugins');
	function coworking_instagram_feed_tgmpa_required_plugins( $list = array() ) {
		if ( coworking_storage_isset( 'required_plugins', 'instagram-feed' ) && coworking_storage_get_array( 'required_plugins', 'instagram-feed', 'install' ) !== false ) {
			$list[] = array(
				'name'     => coworking_storage_get_array( 'required_plugins', 'instagram-feed', 'title' ),
				'slug'     => 'instagram-feed',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if Instagram Feed installed and activated
if ( ! function_exists( 'coworking_exists_instagram_feed' ) ) {
	function coworking_exists_instagram_feed() {
		return defined( 'SBIVER' );
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'coworking_instagram_feed_frontend_scripts_responsive' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'coworking_instagram_feed_frontend_scripts_responsive', 2000 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_instagram_feed', 'coworking_instagram_feed_frontend_scripts_responsive', 10, 1 );
	function coworking_instagram_feed_frontend_scripts_responsive( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
			current_action() == 'wp_enqueue_scripts' && coworking_need_frontend_scripts( 'instagram_feed' )
			||
			current_action() != 'wp_enqueue_scripts' && $force === true
			)
		) {
			$loaded = true;
			$coworking_url = coworking_get_file_url( 'plugins/instagram-feed/instagram-feed-responsive.css' );
			if ( '' != $coworking_url ) {
				wp_enqueue_style( 'coworking-instagram-feed-responsive', $coworking_url, array(), null, coworking_media_for_load_css_responsive( 'instagram-feed' ) );
			}
		}
	}
}

// Merge responsive styles
if ( ! function_exists( 'coworking_instagram_merge_styles_responsive' ) ) {
	//Handler of the add_filter('coworking_filter_merge_styles_responsive', 'coworking_instagram_merge_styles_responsive');
	function coworking_instagram_merge_styles_responsive( $list ) {
		$list[ 'plugins/instagram/instagram-responsive.css' ] = false;
		return $list;
	}
}
