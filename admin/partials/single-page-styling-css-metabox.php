<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    Single_Page_Styling
 * @subpackage Single_Page_Styling/admin/partials
 */

// Add an nonce field so we can check for it later.
wp_nonce_field( 'single_page_styling_css_metabox', 'single_page_styling_css_metabox_nonce' );

// Use get_post_meta to retrieve an existing value from the database.
$value = get_post_meta( $post->ID, '_single_page_styling_content', true );
?>
<div class="single-page-styling-editor-wrapper">
	<div id="js__sps-ace-editor" style="position: absolute; top: 0; left: 0;bottom: 0;right: 0;"></div>
</div>

<?php

echo '<textarea id="css_metabox_field" name="css_metabox_field" style="display: none;" />' . esc_attr( $value ) . '</textarea>';