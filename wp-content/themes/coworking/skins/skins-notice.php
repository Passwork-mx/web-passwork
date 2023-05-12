<?php
/**
 * The template to display Admin notices
 *
 * @package COWORKING
 * @since COWORKING 1.0.64
 */

$coworking_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$coworking_skins_args = get_query_var( 'coworking_skins_notice_args' );
?>
<div class="coworking_admin_notice coworking_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins available', 'coworking' ); ?>
	</h3>
	<?php

	// Description
	$coworking_total      = $coworking_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$coworking_skins_msg  = $coworking_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $coworking_total, 'coworking' ), $coworking_total ) . '</strong>'
							: '';
	$coworking_total      = $coworking_skins_args['free'];
	$coworking_skins_msg .= $coworking_total > 0
							? ( ! empty( $coworking_skins_msg ) ? ' ' . esc_html__( 'and', 'coworking' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $coworking_total, 'coworking' ), $coworking_total ) . '</strong>'
							: '';
	$coworking_total      = $coworking_skins_args['pay'];
	$coworking_skins_msg .= $coworking_skins_args['pay'] > 0
							? ( ! empty( $coworking_skins_msg ) ? ' ' . esc_html__( 'and', 'coworking' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $coworking_total, 'coworking' ), $coworking_total ) . '</strong>'
							: '';
	?>
	<div class="coworking_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'coworking' ), $coworking_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="coworking_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $coworking_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'coworking' );
			?>
		</a>
	</div>
</div>
