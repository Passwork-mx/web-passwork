<?php
/**
 * Required plugins
 *
 * @package COWORKING
 * @since COWORKING 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$coworking_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'coworking' ),
	'page_builders' => esc_html__( 'Page Builders', 'coworking' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'coworking' ),
	'socials'       => esc_html__( 'Socials and Communities', 'coworking' ),
	'events'        => esc_html__( 'Events and Appointments', 'coworking' ),
	'content'       => esc_html__( 'Content', 'coworking' ),
	'other'         => esc_html__( 'Other', 'coworking' ),
);
$coworking_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'coworking' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'coworking' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $coworking_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'coworking' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'coworking' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $coworking_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'coworking' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'coworking' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $coworking_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'coworking' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'coworking' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $coworking_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'coworking' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'coworking' ),
		'required'    => false,
		'logo'        => 'woocommerce.png',
		'group'       => $coworking_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'coworking' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'coworking' ),
		'required'    => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $coworking_theme_required_plugins_groups['ecommerce'],
	),
	'give'                       => array(
		'title'       => esc_html__( 'Give', 'coworking' ),
		'description' => '',
		'required'    => false,
		'logo'        => coworking_get_file_url( 'plugins/give/give.png' ),
		'group'       => $coworking_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'coworking' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'coworking' ),
		'required'    => false,
        'logo'        => 'instagram-feed.png',
		'group'       => $coworking_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'coworking' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'coworking' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $coworking_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'coworking' ),
		'description' => '',
		'required'    => false,
        	'install'     => false,
        'logo'        => 'booked.png',
		'group'       => $coworking_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'coworking' ),
		'description' => '',
		'required'    => false,
        	'install'     => false,
        'logo'        => 'the-events-calendar.png',
		'group'       => $coworking_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'coworking' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'coworking' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $coworking_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'coworking' ),
		'description' => '',
		'required'    => false,
        	'install'     => false,
        'logo'        => coworking_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $coworking_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'coworking' ),
		'description' => '',
		'required'    => false,
		'logo'        => coworking_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $coworking_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'coworking' ),
		'description' => '',
		'required'    => false,
        	'install'     => false,
        'logo'        => coworking_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $coworking_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'coworking' ),
		'description' => '',
		'required'    => false,
		'logo'        => coworking_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $coworking_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'coworking' ),
		'description' => '',
		'required'    => false,
        	'install'     => false,
		'logo'        => coworking_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $coworking_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'coworking' ),
		'description' => '',
		'required'    => false,
        	'install'     => false,
        'logo'        => coworking_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $coworking_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'coworking' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $coworking_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'coworking' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $coworking_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'coworking' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'coworking' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $coworking_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'coworking' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'coworking' ),
		'required'    => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $coworking_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'coworking' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'coworking' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $coworking_theme_required_plugins_groups['other'],
	),
);

if ( COWORKING_THEME_FREE ) {
	unset( $coworking_theme_required_plugins['js_composer'] );
	unset( $coworking_theme_required_plugins['booked'] );
	unset( $coworking_theme_required_plugins['the-events-calendar'] );
	unset( $coworking_theme_required_plugins['calculated-fields-form'] );
	unset( $coworking_theme_required_plugins['essential-grid'] );
	unset( $coworking_theme_required_plugins['revslider'] );
	unset( $coworking_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $coworking_theme_required_plugins['trx_updater'] );
	unset( $coworking_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
coworking_storage_set( 'required_plugins', $coworking_theme_required_plugins );
