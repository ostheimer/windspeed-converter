<?php
/**
 * Admin UI: guide page, plugin list links and activation notice.
 *
 * @package WindspeedConverter
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the guide page under Tools.
 */
function wsconv_admin_menu() {
	add_management_page(
		__( 'Windspeed Converter – How to use', 'wind-speed-converter' ),
		'Windspeed Converter',
		'edit_posts',
		'wsconv-guide',
		'wsconv_render_guide_page'
	);
}
add_action( 'admin_menu', 'wsconv_admin_menu' );

/**
 * Add a "How to use" action link on the Plugins screen.
 *
 * @param array $links Existing action links.
 * @return array Modified action links.
 */
function wsconv_plugin_action_links( $links ) {
	$guide_link = '<a href="' . esc_url( admin_url( 'tools.php?page=wsconv-guide' ) ) . '">' . esc_html__( 'How to use', 'wind-speed-converter' ) . '</a>';
	array_unshift( $links, $guide_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( WSCONV_PLUGIN_FILE ), 'wsconv_plugin_action_links' );

/**
 * Add documentation and support links to the plugin row meta.
 *
 * @param array  $meta Existing row meta links.
 * @param string $file Plugin basename of the current row.
 * @return array Modified row meta links.
 */
function wsconv_plugin_row_meta( $meta, $file ) {
	if ( plugin_basename( WSCONV_PLUGIN_FILE ) === $file ) {
		$meta[] = '<a href="https://wordpress.org/plugins/wind-speed-converter/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Documentation', 'wind-speed-converter' ) . '</a>';
		$meta[] = '<a href="https://wordpress.org/support/plugin/wind-speed-converter/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Support', 'wind-speed-converter' ) . '</a>';
	}
	return $meta;
}
add_filter( 'plugin_row_meta', 'wsconv_plugin_row_meta', 10, 2 );

/**
 * Show a one-time notice after activation pointing to the guide page.
 */
function wsconv_activation_notice() {
	if ( ! get_option( 'wsconv_show_activation_notice' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( $screen && 'tools_page_wsconv-guide' === $screen->id ) {
		// The guide page itself deletes the option.
		return;
	}

	$guide_url   = admin_url( 'tools.php?page=wsconv-guide' );
	$dismiss_url = wp_nonce_url( add_query_arg( 'wsconv-dismiss-notice', '1' ), 'wsconv_dismiss_notice' );

	echo '<div class="notice notice-success"><p>';
	echo '<strong>' . esc_html__( 'Windspeed Converter is ready.', 'wind-speed-converter' ) . '</strong> ';
	printf(
		/* translators: %s: the [windspeed_converter] shortcode. */
		esc_html__( 'Add the converter to any page with the “Windspeed Converter” block, the shortcode %s or the widget.', 'wind-speed-converter' ),
		'<code>[windspeed_converter]</code>'
	);
	echo ' <a href="' . esc_url( $guide_url ) . '">' . esc_html__( 'Open the guide', 'wind-speed-converter' ) . '</a>';
	echo ' | <a href="' . esc_url( $dismiss_url ) . '">' . esc_html__( 'Dismiss', 'wind-speed-converter' ) . '</a>';
	echo '</p></div>';
}
add_action( 'admin_notices', 'wsconv_activation_notice' );

/**
 * Persistently dismiss the activation notice.
 */
function wsconv_handle_notice_dismiss() {
	if ( ! isset( $_GET['wsconv-dismiss-notice'] ) ) {
		return;
	}
	check_admin_referer( 'wsconv_dismiss_notice' );
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}
	delete_option( 'wsconv_show_activation_notice' );
	wp_safe_redirect( remove_query_arg( array( 'wsconv-dismiss-notice', '_wpnonce' ) ) );
	exit;
}
add_action( 'admin_init', 'wsconv_handle_notice_dismiss' );

/**
 * Render the guide page (Tools → Windspeed Converter).
 */
function wsconv_render_guide_page() {
	// Visiting the guide counts as onboarding done.
	delete_option( 'wsconv_show_activation_notice' );

	$fields = array(
		'kmh'      => __( 'Km/h', 'wind-speed-converter' ),
		'mph'      => __( 'Mph', 'wind-speed-converter' ),
		'beaufort' => __( 'Beaufort', 'wind-speed-converter' ),
		'ms'       => __( 'M/s', 'wind-speed-converter' ),
		'knots'    => __( 'Knots', 'wind-speed-converter' ),
	);
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Windspeed Converter – How to use', 'wind-speed-converter' ); ?></h1>
		<p><?php esc_html_e( 'The converter lets visitors enter one wind speed value and instantly calculates the others.', 'wind-speed-converter' ); ?></p>

		<h2><?php esc_html_e( 'Block editor', 'wind-speed-converter' ); ?></h2>
		<p><?php esc_html_e( 'Search for “Windspeed Converter” in the block inserter and add the block. Use the block settings in the sidebar to show or hide individual fields.', 'wind-speed-converter' ); ?></p>

		<h2><?php esc_html_e( 'Shortcode', 'wind-speed-converter' ); ?></h2>
		<p><?php esc_html_e( 'Insert the converter into any post or page with this shortcode:', 'wind-speed-converter' ); ?></p>
		<p><code>[windspeed_converter]</code></p>
		<p><?php esc_html_e( 'All fields are shown by default. Hide individual fields with attributes:', 'wind-speed-converter' ); ?></p>
		<table class="widefat striped" style="max-width: 640px;">
			<tbody>
				<?php foreach ( $fields as $attribute => $label ) : ?>
				<tr>
					<td><code>[windspeed_converter <?php echo esc_html( $attribute ); ?>="false"]</code></td>
					<td>
						<?php
						/* translators: %s: name of the converter field, e.g. "Km/h". */
						printf( esc_html__( 'Hides the “%s” field', 'wind-speed-converter' ), esc_html( $label ) );
						?>
					</td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td><code>[windspeed_converter link="false"]</code></td>
					<td><?php esc_html_e( 'Hides the backlink', 'wind-speed-converter' ); ?></td>
				</tr>
			</tbody>
		</table>
		<p><?php esc_html_e( 'Attributes can be combined:', 'wind-speed-converter' ); ?></p>
		<p><code>[windspeed_converter beaufort="false" ms="false" link="false"]</code></p>

		<h2><?php esc_html_e( 'Widget', 'wind-speed-converter' ); ?></h2>
		<p>
			<?php
			/* translators: %s: translated name of the widget. */
			printf( esc_html__( 'Add the “%s” widget under Appearance → Widgets, set a title and tick the fields you want to show.', 'wind-speed-converter' ), esc_html__( 'Windspeed Converter Widget', 'wind-speed-converter' ) );
			?>
		</p>

		<h2><?php esc_html_e( 'Languages', 'wind-speed-converter' ); ?></h2>
		<p><?php esc_html_e( 'Translations for all 24 official EU languages are bundled. The converter follows the site language set under Settings → General.', 'wind-speed-converter' ); ?></p>

		<h2><?php esc_html_e( 'Need help?', 'wind-speed-converter' ); ?></h2>
		<p>
			<a href="https://wordpress.org/support/plugin/wind-speed-converter/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Support forum', 'wind-speed-converter' ); ?></a>
			&middot;
			<a href="https://wordpress.org/plugins/wind-speed-converter/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Plugin page on WordPress.org', 'wind-speed-converter' ); ?></a>
		</p>
	</div>
	<?php
}
