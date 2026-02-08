<?php
/**
 * Windspeed Converter Widget
 *
 * @package WindspeedConverter
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Widget class for the Windspeed Converter.
 */
class WSConv_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'wsconv_widget',
			esc_html__( 'Windspeed Converter Widget', 'wind-speed-converter' )
		);
	}

	/**
	 * Front-end display of the widget.
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core widget args are pre-escaped
		echo $args['before_widget'];

		echo '<div id="wind_converter" class="wind_converter">';

		if ( ! empty( $title ) ) {
			echo '<h3 class="widget-title">' . esc_html( $title ) . '</h3>';
		}

		echo '<form name="form_wind_converter">';

		if ( ! empty( $instance['kmh'] ) && 1 == $instance['kmh'] ) {
			echo '<div id="kmh" class="field"><label>' . esc_html__( 'Km/h', 'wind-speed-converter' ) . '</label><input type="text" name="kmh" class="input_field" /></div>';
		}

		if ( ! empty( $instance['mph'] ) && 1 == $instance['mph'] ) {
			echo '<div id="mph" class="field"><label>' . esc_html__( 'Mph', 'wind-speed-converter' ) . '</label><input type="text" name="mph" class="input_field" /></div>';
		}

		if ( ! empty( $instance['beaufort'] ) && 1 == $instance['beaufort'] ) {
			echo '<div id="beaufort" class="field"><label>' . esc_html__( 'Beaufort', 'wind-speed-converter' ) . '</label><input type="text" name="beaufort" class="input_field" /></div>';
		}

		if ( ! empty( $instance['ms'] ) && 1 == $instance['ms'] ) {
			echo '<div id="ms" class="field"><label>' . esc_html__( 'M/s', 'wind-speed-converter' ) . '</label><input type="text" name="ms" class="input_field" /></div>';
		}

		if ( ! empty( $instance['knots'] ) && 1 == $instance['knots'] ) {
			echo '<div id="knots" class="field"><label>' . esc_html__( 'Knots', 'wind-speed-converter' ) . '</label><input type="text" name="knots" class="input_field" /></div>';
		}

		echo '<div class="field message"></div>';
		echo '<div class="clear"></div>';

		if ( ! empty( $instance['link'] ) && 1 != $instance['link'] ) {
			echo '<div id="link"><a href="https://www.ostheimer.at" target="_blank" title="' . esc_attr__( 'Ostheimer Webdesign and SEO', 'wind-speed-converter' ) . '">by Ostheimer.at</a></div>';
		}

		echo '</form>';
		echo '</div>';
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core widget args are pre-escaped
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title    = isset( $instance['title'] ) ? $instance['title'] : '';
		$kmh      = isset( $instance['kmh'] ) ? $instance['kmh'] : '';
		$mph      = isset( $instance['mph'] ) ? $instance['mph'] : '';
		$beaufort = isset( $instance['beaufort'] ) ? $instance['beaufort'] : '';
		$ms       = isset( $instance['ms'] ) ? $instance['ms'] : '';
		$knots    = isset( $instance['knots'] ) ? $instance['knots'] : '';
		$link     = isset( $instance['link'] ) ? $instance['link'] : '';

		echo '<div class="widget-content">';

		// Title field
		echo '<p><label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">';
		esc_html_e( 'Title', 'wind-speed-converter' );
		echo ' <input id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '" /></label></p>';

		// Km/h checkbox
		echo '<p><input id="' . esc_attr( $this->get_field_id( 'kmh' ) ) . '" type="checkbox" name="' . esc_attr( $this->get_field_name( 'kmh' ) ) . '" value="1" ' . checked( $kmh, 1, false ) . ' /><label for="' . esc_attr( $this->get_field_id( 'kmh' ) ) . '"> ';
		esc_html_e( 'Km/h', 'wind-speed-converter' );
		echo '</label></p>';

		// Mph checkbox
		echo '<p><input id="' . esc_attr( $this->get_field_id( 'mph' ) ) . '" type="checkbox" name="' . esc_attr( $this->get_field_name( 'mph' ) ) . '" value="1" ' . checked( $mph, 1, false ) . ' /><label for="' . esc_attr( $this->get_field_id( 'mph' ) ) . '"> ';
		esc_html_e( 'Mph', 'wind-speed-converter' );
		echo '</label></p>';

		// Beaufort checkbox
		echo '<p><input id="' . esc_attr( $this->get_field_id( 'beaufort' ) ) . '" type="checkbox" name="' . esc_attr( $this->get_field_name( 'beaufort' ) ) . '" value="1" ' . checked( $beaufort, 1, false ) . ' /><label for="' . esc_attr( $this->get_field_id( 'beaufort' ) ) . '"> ';
		esc_html_e( 'Beaufort', 'wind-speed-converter' );
		echo '</label></p>';

		// M/s checkbox
		echo '<p><input type="checkbox" id="' . esc_attr( $this->get_field_id( 'ms' ) ) . '" name="' . esc_attr( $this->get_field_name( 'ms' ) ) . '" value="1" ' . checked( $ms, 1, false ) . ' /><label for="' . esc_attr( $this->get_field_id( 'ms' ) ) . '"> ';
		esc_html_e( 'M/s', 'wind-speed-converter' );
		echo '</label></p>';

		// Knots checkbox
		echo '<p><input type="checkbox" id="' . esc_attr( $this->get_field_id( 'knots' ) ) . '" name="' . esc_attr( $this->get_field_name( 'knots' ) ) . '" value="1" ' . checked( $knots, 1, false ) . ' /><label for="' . esc_attr( $this->get_field_id( 'knots' ) ) . '"> ';
		esc_html_e( 'Knots', 'wind-speed-converter' );
		echo '</label></p>';

		echo '<br />';

		// Hide link checkbox
		echo '<p><input type="checkbox" id="' . esc_attr( $this->get_field_id( 'link' ) ) . '" name="' . esc_attr( $this->get_field_name( 'link' ) ) . '" value="1" ' . checked( $link, 1, false ) . ' /><label for="' . esc_attr( $this->get_field_id( 'link' ) ) . '"> ';
		esc_html_e( 'Hide Link?', 'wind-speed-converter' );
		echo '</label></p>';

		echo '</div>';
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		foreach ( array( 'title', 'kmh', 'mph', 'beaufort', 'ms', 'knots', 'link' ) as $key ) {
			if ( isset( $new_instance[ $key ] ) ) {
				$instance[ $key ] = sanitize_text_field( $new_instance[ $key ] );
			}
		}
		return $instance;
	}
}
