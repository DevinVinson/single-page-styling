<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    Single_Page_Styling
 * @subpackage Single_Page_Styling/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Single_Page_Styling
 * @subpackage Single_Page_Styling/includes
 * @author     Devin Vinson <devinvinson@gmail.com>
 */
class Single_Page_Styling_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'simple-page-styling',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}


}
