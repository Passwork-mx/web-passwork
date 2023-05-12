<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'coworking_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'coworking_essential_grid_theme_setup9', 9 );
	function coworking_essential_grid_theme_setup9() {
		if ( coworking_exists_essential_grid() ) {
			add_action( 'wp_enqueue_scripts', 'coworking_essential_grid_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_essential_grid', 'coworking_essential_grid_frontend_scripts', 10, 1 );
			add_filter( 'coworking_filter_merge_styles', 'coworking_essential_grid_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'coworking_filter_tgmpa_required_plugins', 'coworking_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'coworking_essential_grid_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('coworking_filter_tgmpa_required_plugins',	'coworking_essential_grid_tgmpa_required_plugins');
	function coworking_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( coworking_storage_isset( 'required_plugins', 'essential-grid' ) && coworking_storage_get_array( 'required_plugins', 'essential-grid', 'install' ) !== false && coworking_is_theme_activated() ) {
			$path = coworking_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || coworking_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => coworking_storage_get_array( 'required_plugins', 'essential-grid', 'title' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'version'  => '2.2.4.2',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'coworking_exists_essential_grid' ) ) {
	function coworking_exists_essential_grid() {
		return defined( 'EG_PLUGIN_PATH' ) || defined( 'ESG_PLUGIN_PATH' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'coworking_essential_grid_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'coworking_essential_grid_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_essential_grid', 'coworking_essential_grid_frontend_scripts', 10, 1 );
	function coworking_essential_grid_frontend_scripts( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
			current_action() == 'wp_enqueue_scripts' && coworking_need_frontend_scripts( 'essential_grid' )
			||
			current_action() != 'wp_enqueue_scripts' && $force === true
			)
		) {
			$loaded = true;
			$coworking_url = coworking_get_file_url( 'plugins/essential-grid/essential-grid.css' );
			if ( '' != $coworking_url ) {
				wp_enqueue_style( 'coworking-essential-grid', $coworking_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'coworking_essential_grid_merge_styles' ) ) {
	//Handler of the add_filter('coworking_filter_merge_styles', 'coworking_essential_grid_merge_styles');
	function coworking_essential_grid_merge_styles( $list ) {
		$list[ 'plugins/essential-grid/essential-grid.css' ] = false;
		return $list;
	}
}
