<?php
/**
 * Plugin Name: Windspeed Converter
 * Plugin URI:  https://www.ostheimer.at/
 * Description: Insert a wind speed converter via widget or shortcode. The user enters one of five values (km/h, mph, Beaufort, m/s, knots) and the plugin calculates the others.
 * Author:      Andreas Ostheimer
 * Version:     1.5.0
 * Author URI:  https://www.ostheimer.at
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wind-speed-converter
 * Domain Path: /languages
 *
 * Copyright 2012-2026 Ostheimer.at (email: office@ostheimer.at)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin constants
define( 'WSCONV_PLUGIN_FILE', __FILE__ );
define( 'WSCONV_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WSCONV_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WSCONV_VERSION', '1.5.0' );

/**
 * Load the bundled translations.
 *
 * The plugin ships its own .mo files in /languages for all 24 official EU
 * languages; translate.wordpress.org has no language packs for this plugin,
 * so the text domain must be loaded explicitly.
 */
function wsconv_load_textdomain() {
	load_plugin_textdomain( 'wind-speed-converter', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'wsconv_load_textdomain' );

/**
 * Show the one-time onboarding notice after activation.
 */
function wsconv_activate() {
	update_option( 'wsconv_show_activation_notice', '1' );
}
register_activation_hook( __FILE__, 'wsconv_activate' );

/**
 * Register the widget.
 */
function wsconv_widgets_init() {
	require_once WSCONV_PLUGIN_DIR . 'widget.php';
	register_widget( 'WSConv_Widget' );
}
add_action( 'widgets_init', 'wsconv_widgets_init' );

/**
 * Register shared assets so both the frontend and the block editor can use them.
 */
function wsconv_register_assets() {
	wp_register_style( 'wsconv-css', WSCONV_PLUGIN_URL . 'windspeed-converter.css', array(), WSCONV_VERSION );
}
add_action( 'init', 'wsconv_register_assets', 5 );

/**
 * Register the Gutenberg block (server-rendered, no build step).
 */
function wsconv_register_block() {
	wp_register_script(
		'wsconv-block-editor',
		WSCONV_PLUGIN_URL . 'block/block.js',
		array( 'wp-blocks', 'wp-element', 'wp-i18n', 'wp-block-editor', 'wp-components', 'wp-server-side-render' ),
		WSCONV_VERSION,
		true
	);
	wp_set_script_translations( 'wsconv-block-editor', 'wind-speed-converter', WSCONV_PLUGIN_DIR . 'languages' );

	register_block_type(
		WSCONV_PLUGIN_DIR . 'block',
		array(
			'render_callback' => 'wsconv_render_block',
		)
	);
}
add_action( 'init', 'wsconv_register_block' );

/**
 * Render callback for the block: maps boolean attributes onto the
 * shortcode renderer so block, shortcode and widget share one output path.
 *
 * @param array $attributes Block attributes.
 * @return string Rendered HTML output.
 */
function wsconv_render_block( $attributes ) {
	$atts = array();
	foreach ( array( 'kmh', 'mph', 'beaufort', 'ms', 'knots', 'link' ) as $field ) {
		$enabled        = ! isset( $attributes[ $field ] ) || false !== $attributes[ $field ];
		$atts[ $field ] = $enabled ? $field : 'false';
	}

	ob_start();
	wsconv_display_shortcode( $atts );
	return ob_get_clean();
}

/**
 * Enqueue plugin styles.
 */
function wsconv_enqueue_styles() {
	wp_enqueue_style( 'wsconv-css' );
}
add_action( 'wp_enqueue_scripts', 'wsconv_enqueue_styles' );

/**
 * Enqueue plugin scripts and localize messages.
 */
function wsconv_enqueue_scripts() {
	wp_enqueue_script( 'wsconv-converter', WSCONV_PLUGIN_URL . 'windspeed-converter.js', array( 'jquery' ), WSCONV_VERSION, true );
	wp_enqueue_script( 'wsconv-beaufort-scala', WSCONV_PLUGIN_URL . 'windspeed-converter-beaufort-scala.js', array( 'jquery' ), WSCONV_VERSION, true );
	wp_localize_script(
		'wsconv-converter',
		'wsconv_messages',
		array(
			'usecomma'      => __( '* Use . (dot) as comma.', 'wind-speed-converter' ),
			'numberbetween' => __( '* Number between 1 and 12', 'wind-speed-converter' ),
			'mustinteger'   => __( '* Number must be an integer.', 'wind-speed-converter' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'wsconv_enqueue_scripts' );

/**
 * Shortcode handler for [windspeed_converter].
 *
 * @param array $atts Shortcode attributes.
 * @return string Rendered HTML output.
 */
function wsconv_shortcode( $atts ) {
	ob_start();
	wsconv_display_shortcode( $atts );
	return ob_get_clean();
}
add_shortcode( 'windspeed_converter', 'wsconv_shortcode' );

/**
 * Render the converter form for the shortcode.
 *
 * @param array $atts Shortcode attributes.
 */
function wsconv_display_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'kmh'      => 'kmh',
			'mph'      => 'mph',
			'beaufort' => 'beaufort',
			'ms'       => 'ms',
			'knots'    => 'knots',
			'link'     => 'link',
		),
		$atts,
		'windspeed_converter'
	);

	echo '<div id="wind_converter" class="wind_converter">';
	echo '<form name="form_wind_converter">';

	if ( 'false' !== $atts['kmh'] ) {
		echo '<div id="kmh" class="field">';
		echo '<label>' . esc_html__( 'Km/h', 'wind-speed-converter' ) . '</label>';
		echo '<input type="text" name="kmh" class="input_field" />';
		echo '</div>';
	}

	if ( 'false' !== $atts['mph'] ) {
		echo '<div id="mph" class="field">';
		echo '<label>' . esc_html__( 'Mph', 'wind-speed-converter' ) . '</label>';
		echo '<input type="text" name="mph" class="input_field" />';
		echo '</div>';
	}

	if ( 'false' !== $atts['beaufort'] ) {
		echo '<div id="beaufort" class="field">';
		echo '<label>' . esc_html__( 'Beaufort', 'wind-speed-converter' ) . '</label>';
		echo '<input type="text" name="beaufort" class="input_field" />';
		echo '</div>';
	}

	if ( 'false' !== $atts['ms'] ) {
		echo '<div id="ms" class="field">';
		echo '<label>' . esc_html__( 'M/s', 'wind-speed-converter' ) . '</label>';
		echo '<input type="text" name="ms" class="input_field" />';
		echo '</div>';
	}

	if ( 'false' !== $atts['knots'] ) {
		echo '<div id="knots" class="field">';
		echo '<label>' . esc_html__( 'Knots', 'wind-speed-converter' ) . '</label>';
		echo '<input type="text" name="knots" class="input_field" />';
		echo '</div>';
	}

	echo '<div class="field message"></div>';
	echo '<div class="clear"></div>';

	if ( 'false' !== $atts['link'] ) {
		echo '<div id="link" class="field">';
		echo '<a href="https://www.ostheimer.at" target="_blank" title="' . esc_attr__( 'Ostheimer Webdesign and SEO', 'wind-speed-converter' ) . '">by Ostheimer.at</a>';
		echo '</div>';
	}

	echo '</form>';
	echo '</div>';
}

// Admin UI: guide page, plugin list links and activation notice.
if ( is_admin() ) {
	require_once WSCONV_PLUGIN_DIR . 'admin.php';
}
