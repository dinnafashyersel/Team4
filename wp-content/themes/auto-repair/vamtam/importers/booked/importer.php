<?php
/**
 * VamTam Booked Importer
 */

if ( ! defined( 'WP_LOAD_IMPORTERS' ) )
	return;

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}

/**
 * WordPress Importer class for managing the import process of a WXR file
 *
 * @package Importer
 */
if ( class_exists( 'WP_Importer' ) ) {
class Vamtam_Booked_Import extends WP_Importer {
	private $file;

	public function __construct() {
		$this->file = WPV_SAMPLES_DIR . 'booked-settings.json';
	}

	/**
	 * Registered callback function for the WordPress Importer
	 *
	 * Manages the three separate stages of the WXR import process
	 */
	public function dispatch() {
		$this->header();

		check_admin_referer( 'vamtam-import-booked' );

		set_time_limit( 0 );
		$this->import( );

		$this->footer();
	}

	/**
	 * The main controller for the actual import stage.
	 */
	public function import() {
		add_filter( 'http_request_timeout', array( $this, 'bump_request_timeout' ) );

		$this->import_start();

		wp_suspend_cache_invalidation( true );

		$settings = json_decode( file_get_contents( $this->file ), true );

		foreach ( $settings as $opt_name => $opt_val ) {
			update_option( $opt_name, $opt_val );
		}

		wp_suspend_cache_invalidation( false );

		$this->import_end();
	}

	protected function import_start() {
		if ( ! file_exists( $this->file ) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
			echo esc_html__( 'The file does not exist, please try again.', 'wordpress-importer' ) . '</p>';
			$this->footer();
			die();
		}

		do_action( 'import_start' );
	}

	/**
	 * Performs post-import cleanup of files and the cache
	 */
	protected function import_end() {
		$redirect = admin_url( '' );

		echo '<p>' . esc_html__( 'All done.', 'wordpress-importer' ) . ' <a href="' . esc_url( $redirect ) . '">' . esc_html__( 'Have fun!', 'wordpress-importer' ) . '</a></p>';

		echo '<!-- all done -->';

		do_action( 'import_end' );
	}

	// Display import page title
	protected function header() {
		echo '<div class="wrap">';
		echo '<h2>' . esc_html__( 'Import Booked Settings', 'wordpress-importer' ) . '</h2>'; }

	// Close div.wrap
	protected function footer() {
		echo '</div>';
	}

	/**
	 * Added to http_request_timeout filter to force timeout at 120 seconds during import
	 * @return int 120
	 */
	public function bump_request_timeout( $imp ) {
		return 120;
	}
}

} // class_exists( 'WP_Importer' )

function vamtam_booked_importer_init() {
	$GLOBALS['vamtam_booked_import'] = new Vamtam_Booked_Import();
	register_importer( 'vamtam_booked', 'Vamtam Booked Importer', sprintf( esc_html__( 'Import Booked settings, for use with the demo content provided with VamTam themes, not to be used as a stand-alone product.', 'auto-repair' ), VAMTAM_THEME_NAME ), array( $GLOBALS['vamtam_booked_import'], 'dispatch' ) );
}
add_action( 'admin_init', 'vamtam_booked_importer_init' );
