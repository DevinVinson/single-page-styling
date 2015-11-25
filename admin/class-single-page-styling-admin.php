<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    Single_Page_Styling
 * @subpackage Single_Page_Styling/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Single_Page_Styling
 * @subpackage Single_Page_Styling/admin
 * @author     Devin Vinson <devinvinson@gmail.com>
 */
class Single_Page_Styling_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/single-page-styling-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name . 'ace', plugin_dir_url( __FILE__ ) . 'js/ace/ace.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/single-page-styling-admin.js', array( $this->plugin_name . 'ace' ,'jquery' ), $this->version, false );

	}

	/**
	 * Add CSS Meta Box to each Admin screen we want.
	 *
	 * @since 1.0.0
	 */
	public function add_css_meta_box() {

		$screens = apply_filters( 'single_page_styling_post_types', array( 'page' ) );

		foreach ( $screens as $screen ) {
			add_meta_box(
				'_single_page_styling_content',
				__( 'Custom CSS', 'single-page-styling' ),
				array( $this, 'metabox_callback'),
				$screen
			);
		}
	}

	/**
	 * Pull in the metabox content for display.
	 *
	 * @since 1.0.0
	 * @param $post
	 *
	 */
	public function metabox_callback( $post ) {

		require_once plugin_dir_path( __FILE__ ) . 'partials/single-page-styling-css-metabox.php';

	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @since 1.0.0
	 * @param int $post_id The ID of the post being saved.
	 *
	 */
	public function save_metabox( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['single_page_styling_css_metabox_nonce'] ) )
			return $post_id;

		$nonce = $_POST['single_page_styling_css_metabox_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'single_page_styling_css_metabox' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}


		/*
		 * A customized sanitize_text_field to keep whitespace
		 */
		$css = $_POST['css_metabox_field'];

		$filtered = wp_check_invalid_utf8( $css );

		if ( strpos($filtered, '<') !== false ) {
			$filtered = wp_pre_kses_less_than( $filtered );
			$filtered = wp_strip_all_tags( $filtered, false );
		} else {
			$filtered = trim( $filtered );
		}

		$found = false;
		while ( preg_match('/%[a-f0-9]{2}/i', $filtered, $match) ) {
			$filtered = str_replace($match[0], '', $filtered);
			$found = true;
		}

		if ( $found ) {
			// Strip out the whitespace that may now exist after removing the octets.
			$filtered = trim( preg_replace('/ +/', ' ', $filtered) );
		}


		// Update the meta field.
		update_post_meta( $post_id, '_single_page_styling_content', $filtered );
	}

}
