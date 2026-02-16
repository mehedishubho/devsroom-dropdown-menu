<?php
/**
 * Main plugin class.
 *
 * @package DevsroomDropdownMenu
 */

namespace Devsroom\DropdownMenu;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class-ddm-elementor-integration.php';

/**
 * Bootstraps runtime hooks and Elementor integration.
 */
class DDM_Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var DDM_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Admin notices to render.
	 *
	 * @var string[]
	 */
	private $admin_notices = array();

	/**
	 * Returns singleton instance.
	 *
	 * @return DDM_Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'admin_notices', array( $this, 'render_admin_notices' ) );

		new DDM_Elementor_Integration( $this );
	}

	/**
	 * Loads plugin translations.
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'devsroom-dropdown-menu', false, dirname( plugin_basename( DDM_FILE ) ) . '/languages' );
	}

	/**
	 * Registers frontend assets used by the widget.
	 *
	 * @return void
	 */
	public function register_assets() {
		wp_register_style(
			'ddm-widget',
			DDM_URL . 'assets/css/ddm-widget.css',
			array(),
			DDM_VERSION
		);

		wp_register_script(
			'ddm-widget',
			DDM_URL . 'assets/js/ddm-widget.js',
			array(),
			DDM_VERSION,
			true
		);

		wp_register_style(
			'ddm-woo-product-image',
			DDM_URL . 'assets/css/ddm-woo-product-image.css',
			array(),
			DDM_VERSION
		);

		wp_register_script(
			'ddm-woo-product-image',
			DDM_URL . 'assets/js/ddm-woo-product-image.js',
			array(),
			DDM_VERSION,
			true
		);
	}

	/**
	 * Queues an admin notice.
	 *
	 * @param string $message Notice text.
	 * @return void
	 */
	public function add_admin_notice( $message ) {
		$message = (string) $message;

		if ( '' === $message || in_array( $message, $this->admin_notices, true ) ) {
			return;
		}

		$this->admin_notices[] = $message;
	}

	/**
	 * Renders queued admin notices.
	 *
	 * @return void
	 */
	public function render_admin_notices() {
		if ( empty( $this->admin_notices ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		foreach ( $this->admin_notices as $notice ) {
			echo '<div class="notice notice-error"><p>' . esc_html( $notice ) . '</p></div>';
		}
	}
}

