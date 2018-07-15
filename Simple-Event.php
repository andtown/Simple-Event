<?php
/**
* Plugin Name: Simple Event
* Plugin URI: 
* Version: 0.0.1
* Author: Andtown
* Author URI: 
* Description: 
* License: MIT
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

register_activation_hook( __FILE__, array('Simple_Event','activate_plugin') );
register_deactivation_hook( __FILE__, array('Simple_Event','deactivate_plugin') );

require plugin_dir_path( __FILE__ ) . 'includes/class-simple-event.php';

Simple_Event::get_instance();