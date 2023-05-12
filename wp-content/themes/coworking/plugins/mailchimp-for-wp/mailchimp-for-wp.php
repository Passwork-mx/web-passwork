<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'coworking_mailchimp_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'coworking_mailchimp_theme_setup9', 9 );
	function coworking_mailchimp_theme_setup9() {
		if ( coworking_exists_mailchimp() ) {
			add_action( 'wp_enqueue_scripts', 'coworking_mailchimp_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_mailchimp', 'coworking_mailchimp_frontend_scripts', 10, 1 );
			add_filter( 'coworking_filter_merge_styles', 'coworking_mailchimp_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'coworking_filter_tgmpa_required_plugins', 'coworking_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'coworking_mailchimp_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('coworking_filter_tgmpa_required_plugins',	'coworking_mailchimp_tgmpa_required_plugins');
	function coworking_mailchimp_tgmpa_required_plugins( $list = array() ) {
		if ( coworking_storage_isset( 'required_plugins', 'mailchimp-for-wp' ) && coworking_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'install' ) !== false ) {
			$list[] = array(
				'name'     => coworking_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'title' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'coworking_exists_mailchimp' ) ) {
	function coworking_exists_mailchimp() {
		return function_exists( '__mc4wp_load_plugin' ) || defined( 'MC4WP_VERSION' );
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue styles for frontend
if ( ! function_exists( 'coworking_mailchimp_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'coworking_mailchimp_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_mailchimp', 'coworking_mailchimp_frontend_scripts', 10, 1 );
	function coworking_mailchimp_frontend_scripts( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
			current_action() == 'wp_enqueue_scripts' && coworking_need_frontend_scripts( 'mailchimp' )
			||
			current_action() != 'wp_enqueue_scripts' && $force === true
			)
		) {
			$loaded = true;
			$coworking_url = coworking_get_file_url( 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' );
			if ( '' != $coworking_url ) {
				wp_enqueue_style( 'coworking-mailchimp-for-wp', $coworking_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'coworking_mailchimp_merge_styles' ) ) {
	//Handler of the add_filter( 'coworking_filter_merge_styles', 'coworking_mailchimp_merge_styles');
	function coworking_mailchimp_merge_styles( $list ) {
		$list[ 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( coworking_exists_mailchimp() ) {
	require_once coworking_get_file_dir( 'plugins/mailchimp-for-wp/mailchimp-for-wp-style.php' );
}

