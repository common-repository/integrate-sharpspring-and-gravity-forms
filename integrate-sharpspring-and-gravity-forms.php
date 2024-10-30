<?php
/*
	Plugin Name: Integrate SharpSpring and Gravity Forms
	Description: Integrates Gravity Forms with SharpSpring, allowing form submissions to be automatically sent to your SharpSpring account.
	Version: 1.0.4
	Author: Oyova
	Author URI: https://www.oyova.com
 */

define('INTEGRATE_SHARPSPRING_AND_GRAVITY_FORMS', '1.0.4');

add_action('gform_loaded', array('ISGF_GF_Simple_Feed_AddOn_Bootstrap', 'load'), 5);

class ISGF_GF_Simple_Feed_AddOn_Bootstrap {

	public static function load() {

		if ( ! method_exists( 'GFForms', 'include_feed_addon_framework' ) ) {
			return;
		}

		require_once 'class-integrate-sharpspring-and-gravity-forms.php';

		GFAddOn::register( 'ISGF_GFSimpleFeedAddOn' );
	}

}

function ISFGF_gf_simple_feed_addon() {
	return ISGF_GFSimpleFeedAddOn::get_instance();
}