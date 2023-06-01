<?php
/**
 * The template to display Admin notices
 *
 * @package COWORKING
 * @since COWORKING 1.0.1
 */

$coworking_theme_slug = get_option( 'template' );
$coworking_theme_obj  = wp_get_theme( $coworking_theme_slug );
?>
<div class="coworking_admin_notice coworking_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$coworking_theme_img = coworking_get_file_url( 'screenshot.jpg' );
	if ( '' != $coworking_theme_img ) {
		?>
		<div class="coworking_notice_image"><img src="<?php echo esc_url( $coworking_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'coworking' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="coworking_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'coworking' ),
				$coworking_theme_obj->get( 'Name' ) . ( COWORKING_THEME_FREE ? ' ' . __( 'Free', 'coworking' ) : '' ),
				$coworking_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="coworking_notice_text">
		<p class="coworking_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $coworking_theme_obj->description ) );
			?>
		</p>
		<p class="coworking_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'coworking' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="coworking_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=coworking_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'coworking' );
			?>
		</a>
	</div>
</div>
