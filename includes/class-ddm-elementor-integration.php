<?php
/**
 * Elementor integration bootstrap.
 *
 * @package DevsroomDropdownMenu
 */

namespace Devsroom\DropdownMenu;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Integrates the plugin widget with Elementor.
 */
class DDM_Elementor_Integration {

	/**
	 * Minimum Elementor version.
	 */
	private const MIN_ELEMENTOR_VERSION = '3.18.0';

	/**
	 * Minimum WordPress version.
	 */
	private const MIN_WORDPRESS_VERSION = '6.4';

	/**
	 * Minimum PHP version.
	 */
	private const MIN_PHP_VERSION = '8.0';

	/**
	 * Plugin instance.
	 *
	 * @var DDM_Plugin
	 */
	private $plugin;

	/**
	 * Constructor.
	 *
	 * @param DDM_Plugin $plugin Main plugin instance.
	 */
	public function __construct( DDM_Plugin $plugin ) {
		$this->plugin = $plugin;
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Runs compatibility checks and widget registration hook.
	 *
	 * @return void
	 */
	public function init() {
		if ( version_compare( PHP_VERSION, self::MIN_PHP_VERSION, '<' ) ) {
			/* translators: %s: Minimum PHP version. */
			$this->plugin->add_admin_notice( sprintf( __( 'Devsroom Dropdown Menu requires PHP %s or higher.', 'devsroom-dropdown-menu' ), self::MIN_PHP_VERSION ) );
			return;
		}

		if ( version_compare( get_bloginfo( 'version' ), self::MIN_WORDPRESS_VERSION, '<' ) ) {
			/* translators: %s: Minimum WordPress version. */
			$this->plugin->add_admin_notice( sprintf( __( 'Devsroom Dropdown Menu requires WordPress %s or higher.', 'devsroom-dropdown-menu' ), self::MIN_WORDPRESS_VERSION ) );
			return;
		}

		if ( ! did_action( 'elementor/loaded' ) ) {
			$this->plugin->add_admin_notice( __( 'Devsroom Dropdown Menu requires Elementor to be installed and activated.', 'devsroom-dropdown-menu' ) );
			return;
		}

		if ( ! defined( 'ELEMENTOR_VERSION' ) || version_compare( ELEMENTOR_VERSION, self::MIN_ELEMENTOR_VERSION, '<' ) ) {
			/* translators: %s: Minimum Elementor version. */
			$this->plugin->add_admin_notice( sprintf( __( 'Devsroom Dropdown Menu requires Elementor %s or higher.', 'devsroom-dropdown-menu' ), self::MIN_ELEMENTOR_VERSION ) );
			return;
		}

		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
	}

	/**
	 * Registers custom Elementor widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Widgets manager instance.
	 * @return void
	 */
	public function register_widgets( $widgets_manager ) {
		require_once __DIR__ . '/widgets/class-ddm-dropdown-menu-widget.php';
		require_once __DIR__ . '/widgets/class-ddm-advanced-product-actions-widget.php';
		require_once __DIR__ . '/widgets/class-ddm-woo-product-image-widget.php';

		$widgets_manager->register( new \Devsroom\DropdownMenu\Widgets\DDM_Dropdown_Menu_Widget() );
		$widgets_manager->register( new \Devsroom\DropdownMenu\Widgets\DDM_Advanced_Product_Actions_Widget() );
		$widgets_manager->register( new \Devsroom\DropdownMenu\Widgets\DDM_Woo_Product_Image_Widget() );
	}
}

