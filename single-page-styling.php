<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://devinvinson.com
 * @since             1.0.0
 * @package           Single_Page_Styling
 *
 * @wordpress-plugin
 * Plugin Name:       Single Page Styling
 * Plugin URI:        http://tinminewp.com/plugins/single-page-styling
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Devin Vinson
 * Author URI:        http://devinvinson.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       single-page-styling
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-single-page-styling-activator.php
 */
function activate_single_page_styling() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-single-page-styling-activator.php';
	Single_Page_Styling_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-single-page-styling-deactivator.php
 */
function deactivate_single_page_styling() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-single-page-styling-deactivator.php';
	Single_Page_Styling_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_single_page_styling' );
register_deactivation_hook( __FILE__, 'deactivate_single_page_styling' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-single-page-styling.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_single_page_styling() {

	$plugin = new Single_Page_Styling();
	$plugin->run();

}
run_single_page_styling();
