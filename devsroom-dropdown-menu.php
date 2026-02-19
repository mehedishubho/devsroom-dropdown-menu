<?php

/**
 * Plugin Name: Devsroom Custom Toolkit
 * Plugin URI:  https://devsroom.com
 * Description: A lightweight and scalable WordPress toolkit developed by Mehedi Hassan Shubho (Devsroom). Built for performance, security, and modern WordPress standards.
 * Version:     1.4.0
 * Author:      Mehedi Hassan Shubho
 * Author URI:  https://wpmhs.com
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: devsroom-dropdown-menu
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */


if (! defined('ABSPATH')) {
	exit;
}

if (! defined('DDM_VERSION')) {
	define('DDM_VERSION', '1.0.0');
}

if (! defined('DDM_FILE')) {
	define('DDM_FILE', __FILE__);
}

if (! defined('DDM_PATH')) {
	define('DDM_PATH', plugin_dir_path(DDM_FILE));
}

if (! defined('DDM_URL')) {
	define('DDM_URL', plugin_dir_url(DDM_FILE));
}

require_once DDM_PATH . 'includes/class-ddm-plugin.php';

/**
 * Bootstraps the plugin singleton.
 *
 * @return void
 */
function ddm_bootstrap_plugin()
{
	Devsroom\DropdownMenu\DDM_Plugin::instance();
}

add_action('plugins_loaded', 'ddm_bootstrap_plugin');
