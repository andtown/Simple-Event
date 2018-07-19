<?php
/**
* Plugin Name: Simple Event
* Plugin URI: 
* Version: 0.1.0
* Author: Andtown
* Author URI: 
* Description: This plugin is a simple event plugin that uses custom post type to store events
* License: MIT
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

defined('SIMPLE_EVENT_PLUGIN_PATH') || define( 'SIMPLE_EVENT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, array('Simple_Event','activate_plugin') );
register_deactivation_hook( __FILE__, array('Simple_Event','deactivate_plugin') );

require plugin_dir_path( __FILE__ ) . 'includes/class-simple-event.php';

Simple_Event::get_instance();