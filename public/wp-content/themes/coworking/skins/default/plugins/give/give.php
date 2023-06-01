<?php
/* Give (donation forms) support functions
------------------------------------------------------------------------------- */

if ( ! defined( 'COWORKING_GIVE_FORMS_PT_FORMS' ) )			define( 'COWORKING_GIVE_FORMS_PT_FORMS', 'give_forms' );
if ( ! defined( 'COWORKING_GIVE_FORMS_PT_PAYMENT' ) )			define( 'COWORKING_GIVE_FORMS_PT_PAYMENT', 'give_payment' );
if ( ! defined( 'COWORKING_GIVE_FORMS_TAXONOMY_CATEGORY' ) )	define( 'COWORKING_GIVE_FORMS_TAXONOMY_CATEGORY', 'give_forms_category' );
if ( ! defined( 'COWORKING_GIVE_FORMS_TAXONOMY_TAG' ) )		define( 'COWORKING_GIVE_FORMS_TAXONOMY_TAG', 'give_forms_tag' );


// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'coworking_give_theme_setup3' ) ) {
	add_action( 'after_setup_theme', 'coworking_give_theme_setup3', 3 );
	function coworking_give_theme_setup3() {
		if ( coworking_exists_give() ) {
			// Section 'Give'
			coworking_storage_merge_array(
				'options', '', array_merge(
					array(
						'give' => array(
							'title' => esc_html__( 'Give Donations', 'coworking' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the Give Donations pages', 'coworking' ) ),
							'icon'  => 'icon-donation',
							'type'  => 'section',
						),
					),
					coworking_options_get_list_cpt_options( 'give', esc_html__( 'Give Donations', 'coworking' ) )
				)
			);
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'coworking_give_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'coworking_give_theme_setup9', 9 );
	function coworking_give_theme_setup9() {
		if ( coworking_exists_give() ) {
			add_action( 'wp_enqueue_scripts', 'coworking_give_frontend_scripts', 1100 );
            add_action( 'wp_enqueue_scripts', 'coworking_give_responsive_styles', 2000 );
			add_filter( 'coworking_filter_merge_styles', 'coworking_give_merge_styles' );
            add_filter( 'coworking_filter_merge_styles_responsive', 'coworking_give_merge_styles_responsive' );
            add_filter('coworking_filter_merge_scripts', 'coworking_give_merge_scripts');
			add_filter( 'coworking_filter_get_post_categories', 'coworking_give_get_post_categories', 10, 2 );
			add_filter( 'coworking_filter_post_type_taxonomy', 'coworking_give_post_type_taxonomy', 10, 2 );
			add_filter( 'coworking_filter_detect_blog_mode', 'coworking_give_detect_blog_mode' );

            // Search theme-specific templates in the skin dir (if exists)
            add_filter( 'give_get_locate_template', 'coworking_give_get_locate_template', 100, 3 );
            add_filter( 'give_get_template_part', 'coworking_give_get_template_part', 100, 3 );
		}
		if ( is_admin() ) {
			add_filter( 'coworking_filter_tgmpa_required_plugins', 'coworking_give_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'coworking_give_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('coworking_filter_tgmpa_required_plugins', 'coworking_give_tgmpa_required_plugins');
	function coworking_give_tgmpa_required_plugins( $list = array() ) {
		if ( coworking_storage_isset( 'required_plugins', 'give' ) && coworking_storage_get_array( 'required_plugins', 'give', 'install' ) !== false ) {
			$list[] = array(
				'name'     => coworking_storage_get_array( 'required_plugins', 'give', 'title' ),
				'slug'     => 'give',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'coworking_exists_give' ) ) {
	function coworking_exists_give() {
		return class_exists( 'Give' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'coworking_give_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'coworking_give_frontend_scripts', 1100 );
	function coworking_give_frontend_scripts() {
		if ( coworking_is_on( coworking_get_theme_option( 'debug_mode' ) ) ) {
			$coworking_url = coworking_get_file_url( 'plugins/give/give.css' );
			if ( '' != $coworking_url ) {
				wp_enqueue_style( 'coworking-give', $coworking_url, array(), null );
			}
            $coworking_url = coworking_get_file_url( 'plugins/give/give.js' );
            if ( '' != $coworking_url ) {
                wp_enqueue_script( 'coworking-give', $coworking_url, array( 'jquery' ), null, true );
            }
		}
	}
}
// Enqueue responsive styles for frontend
if ( ! function_exists( 'coworking_give_responsive_styles' ) ) {
    //Handler of the add_action( 'wp_enqueue_scripts', 'coworking_give_responsive_styles', 2000 );
    function coworking_give_responsive_styles() {
        if ( coworking_is_on( coworking_get_theme_option( 'debug_mode' ) ) ) {
            $coworking_url = coworking_get_file_url( 'plugins/give/give-responsive.css' );
            if ( '' != $coworking_url ) {
                wp_enqueue_style( 'coworking-give-responsive', $coworking_url, array(), null );
            }
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'coworking_give_merge_styles' ) ) {
	//Handler of the add_filter('coworking_filter_merge_styles', 'coworking_give_merge_styles');
	function coworking_give_merge_styles( $list ) {
		$list[] = 'plugins/give/give.css';
		return $list;
	}
}
// Merge responsive styles
if ( ! function_exists( 'coworking_give_merge_styles_responsive' ) ) {
    //Handler of the add_filter('coworking_filter_merge_styles_responsive', 'coworking_give_merge_styles_responsive');
    function coworking_give_merge_styles_responsive( $list ) {
        $list[] = 'plugins/give/give-responsive.css';
        return $list;
    }
}
// Merge custom scripts
if ( ! function_exists( 'coworking_give_merge_scripts' ) ) {
    //Handler of the add_filter('coworking_filter_merge_scripts', 'coworking_give_merge_scripts');
    function coworking_give_merge_scripts( $list ) {
        $list[] = 'plugins/give/give.js';
        return $list;
    }
}
// Return true, if current page is any give page
if ( ! function_exists( 'coworking_is_give_page' ) ) {
	function coworking_is_give_page() {
		$rez = coworking_exists_give()
					&& ! is_search()
					&& (
						is_singular( COWORKING_GIVE_FORMS_PT_FORMS )
						|| is_post_type_archive( COWORKING_GIVE_FORMS_PT_FORMS )
						|| is_tax( COWORKING_GIVE_FORMS_TAXONOMY_CATEGORY )
						|| is_tax( COWORKING_GIVE_FORMS_TAXONOMY_TAG )
						|| ( function_exists( 'is_give_form' ) && is_give_form() )
						|| ( function_exists( 'is_give_category' ) && is_give_category() )
						|| ( function_exists( 'is_give_tag' ) && is_give_tag() )
						);
		return $rez;
	}
}

// Detect current blog mode
if ( ! function_exists( 'coworking_give_detect_blog_mode' ) ) {
	//Handler of the add_filter( 'coworking_filter_detect_blog_mode', 'coworking_give_detect_blog_mode' );
	function coworking_give_detect_blog_mode( $mode = '' ) {
		if ( coworking_is_give_page() ) {
			$mode = 'give';
		}
		return $mode;
	}
}


// Search skin-specific templates in the skin dir (if exists)
if ( ! function_exists( 'coworking_give_get_locate_template' ) ) {
    //Handler of the add_filter( 'give_get_locate_template', 'coworking_give_get_locate_template', 100, 3 );
    function coworking_give_get_locate_template( $template, $template_name, $template_path ) {
        $folders = apply_filters( 'coworking_filter_give_locate_template_folders', array(
            $template_path,
            'plugins/give/templates'
        ) );
        foreach ( $folders as $f ) {
            $theme_dir = apply_filters( 'coworking_filter_get_theme_file_dir', '', trailingslashit( coworking_esc( $f ) ) . $template_name );
            if ( '' != $theme_dir ) {
                $template = $theme_dir;
                break;
            }
        }
        return $template;
    }
}


// Search skin-specific templates parts in the skin dir (if exists)
if ( ! function_exists( 'coworking_give_get_template_part' ) ) {
    //Handler of the add_filter( 'give_get_template_part', 'coworking_give_get_template_part', 100, 3 );
    function coworking_give_get_template_part( $template, $slug, $name ) {
        $folders = apply_filters( 'coworking_filter_give_get_template_part_folders', array(
            'give',
            'plugins/give/templates'
        ) );
        foreach ( $folders as $f ) {
            $theme_dir = apply_filters( 'coworking_filter_get_theme_file_dir', '', trailingslashit( coworking_esc( $f ) ) . "{$slug}-{$name}.php" );
            if ( '' != $theme_dir ) {
                $template = $theme_dir;
                break;
            }
        }
        return $template;
    }
}



// Return taxonomy for current post type
if ( ! function_exists( 'coworking_give_post_type_taxonomy' ) ) {
	//Handler of the add_filter( 'coworking_filter_post_type_taxonomy',	'coworking_give_post_type_taxonomy', 10, 2 );
	function coworking_give_post_type_taxonomy( $tax = '', $post_type = '' ) {
		if ( coworking_exists_give() && COWORKING_GIVE_FORMS_PT_FORMS == $post_type ) {
			$tax = COWORKING_GIVE_FORMS_TAXONOMY_CATEGORY;
		}
		return $tax;
	}
}


// Show categories of the current product
if ( ! function_exists( 'coworking_give_get_post_categories' ) ) {
	//Handler of the add_filter( 'coworking_filter_get_post_categories', 'coworking_give_get_post_categories', 10, 2 );
	function coworking_give_get_post_categories( $cats = '', $args = array() ) {
		if ( get_post_type() == COWORKING_GIVE_FORMS_PT_FORMS ) {
			$cat_sep = apply_filters(
									'coworking_filter_post_meta_cat_separator',
									'<span class="post_meta_item_cat_separator">' . ( ! isset( $args['cat_sep'] ) || ! empty( $args['cat_sep'] ) ? ', ' : ' ' ) . '</span>',
									$args
									);
			$cats = coworking_get_post_terms( $cat_sep, get_the_ID(), COWORKING_GIVE_FORMS_TAXONOMY_CATEGORY );
		}
		return $cats;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( coworking_exists_give() ) {
	require_once coworking_get_file_dir( 'plugins/give/give-style.php' );
}
