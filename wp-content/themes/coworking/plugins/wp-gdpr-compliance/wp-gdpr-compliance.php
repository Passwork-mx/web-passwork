<?php
/* WP GDPR Compliance support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'coworking_wp_gdpr_compliance_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'coworking_wp_gdpr_compliance_theme_setup9', 9 );
	function coworking_wp_gdpr_compliance_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'coworking_filter_tgmpa_required_plugins', 'coworking_wp_gdpr_compliance_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'coworking_wp_gdpr_compliance_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('coworking_filter_tgmpa_required_plugins',	'coworking_wp_gdpr_compliance_tgmpa_required_plugins');
	function coworking_wp_gdpr_compliance_tgmpa_required_plugins( $list = array() ) {
		if ( coworking_storage_isset( 'required_plugins', 'wp-gdpr-compliance' ) && coworking_storage_get_array( 'required_plugins', 'wp-gdpr-compliance', 'install' ) !== false ) {
			$list[] = array(
				'name'     => coworking_storage_get_array( 'required_plugins', 'wp-gdpr-compliance', 'title' ),
				'slug'     => 'wp-gdpr-compliance',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'coworking_exists_wp_gdpr_compliance' ) ) {
	function coworking_exists_wp_gdpr_compliance() {
//		Old way (before v.2.0)
//		Attention! In the v.2.0 and v.2.0.1 this check throw fatal error in their autoloader!
//		return class_exists( 'WPGDPRC\WPGDPRC' );
//		New way (to avoid error in wp_gdpr_compliance autoloader)
//		Check constants:	before v.2.0						after v.2.0
		return defined( 'WP_GDPR_C_ROOT_FILE' ) || defined( 'WPGDPRC_ROOT_FILE' );
	}
}
