<?php

if( !defined( 'ABSPATH' ) )
    exit;

/**
 * Plugin Name: WP Views Counter
 * Plugin URI: https://krigus.com/
 * Description: Add counter to each post in your blog or site
 * Version: 1.0.1
 * Author: Krigus
 * Text Domain: pvc
 * Domain Path: /languages
 * License: GPLv2 or later
 */

define( 'PVC_VERSION', '1.0.1' );
define( 'PVC__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PVC__PLUGIN_URL', plugin_dir_url( __FILE__ ) );

register_activation_hook( __FILE__, array( 'PVC\PVC', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'PVC\PVC', 'plugin_deactivation' ) );

require_once( PVC__PLUGIN_DIR . 'functions.php' );
require_once( PVC__PLUGIN_DIR . 'classes/pvc.class.php' );
require_once( PVC__PLUGIN_DIR . 'classes/settings.class.php' );
require_once( PVC__PLUGIN_DIR . "widgets/viewed-posts.php" );

add_action( 'plugins_loaded', array( 'PVC\PVC', 'init' ) );

if( !is_admin() )
    add_action( 'wp', array( 'PVC\PVC', 'wp' ) );

add_action( 'widgets_init', array( 'PVC\PVC', "init_widget" ) );
add_action( 'post_submitbox_misc_actions', array( 'PVC\PVC', "edit_view_count" ) );
add_action( 'admin_menu', array( 'PVC\Settings', 'add_submenu_page' ) );