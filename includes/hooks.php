<?php

defined('ABSPATH') or die("Jog on");

/**
* Build admin menu
*/
function yk_cs_build_admin_menu() {

	add_menu_page( YK_CS_NAME, YK_CS_NAME, 'manage_options', 'yk-cs-conditional-statements-main-menu', 'yk_cs_conditions_page', 'dashicons-editor-code' );

	// Hide duplicated sub menu (wee hack!)
	add_submenu_page( 'yk-cs-conditional-statements-main-menu', '', '', 'manage_options', 'yk-cs-conditional-statements-main-menu', 'yk_cs_conditions_page' );

	// Add sub menus
	add_submenu_page( 'yk-cs-conditional-statements-main-menu', __( 'Conditions', YK_CS_SLUG ), __( 'Conditions', YK_CS_SLUG ), 'manage_options', 'yk-cs-conditional-statements-main-menu-conditions', 'yk_cs_conditions_page' );

}
add_action( 'admin_menu', 'yk_cs_build_admin_menu' );

/**
 * Enqueue relevant CSS / JS
 */
function yk_cs_enqueue_scripts() {
	wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css', [], SH_CD_PLUGIN_VERSION);
}
add_action( 'admin_enqueue_scripts', 'yk_cs_enqueue_scripts' );

/**
 * Used to render a list of conditions in text format
 *
 * @return string
 */
function yk_cs_shortcode_promo_list() {

	$conditions = yk_cs_conditions();

	$html = '';

	foreach ( $conditions as $key => $data ) {

		$html .= sprintf( '* [%1$s conditions="%2$s"] (supported operators: %3$s) - %4$s' . PHP_EOL,
				YK_CS_SHORTCODE,
				esc_html( $key ),
				implode( ', ', yk_cs_get_class_operators( $key ) ),
				wp_kses_post( $data['description'] )
		);

	}

	return $html;
}
add_shortcode( 'yk-cs-promo', 'yk_cs_shortcode_promo_list' );