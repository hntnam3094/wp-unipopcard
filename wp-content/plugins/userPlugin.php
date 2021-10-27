<?php
/**
 * Plugin Name: My Plugin - Customer
 * Plugin URI: https://www.myplugin.com
 * Description: Plugin Description
 * Version: 1.0.0
 * Author: myplugin
 * Author URI: https://www.myplugin.com
 * Requires at least: 5.5.1
 * Tested up to: 5.5.1
 */

if ( !defined( 'ABSPATH' ) ) exit;

// Act on plugin activation
register_activation_hook( __FILE__, "activate_myplugin" );

// Act on plugin de-activation
register_deactivation_hook( __FILE__, "deactivate_myplugin" );

// Activate Plugin
function activate_myplugin() {

    // Execute tasks on Plugin activation

    // Insert DB Tables
    init_db_myplugin();
}

// De-activate Plugin
function deactivate_myplugin() {

    // Execute tasks on Plugin de-activation
}

// Initialize DB Tables
function init_db_myplugin() {
    // WP Globals
    global $table_prefix, $wpdb;

    // Customer Table
    $customerTable = $table_prefix . 'customer';

    // Create Customer Table if not exist
    if( $wpdb->get_var( "show tables like '$customerTable'" ) != $customerTable ) {

        // Query - Create Table
        $sql = "CREATE TABLE `$customerTable` (";
        $sql .= " `id` int(11) NOT NULL auto_increment, ";
        $sql .= " `email` varchar(500) NOT NULL, ";
        $sql .= " `first_name` varchar(500) NOT NULL, ";
        $sql .= " `last_name` varchar(500) NOT NULL, ";
        $sql .= " `birth_day` date, ";
        $sql .= " `member_ship` int, ";
        $sql .= " `start_date` date, ";
        $sql .= " `end_date` date, ";
        $sql .= " `active` int, ";
        $sql .= " ` PRIMARY KEY (id) ";

        // Include Upgrade Script
        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

        // Create Table
        dbDelta( $sql );
    }
}
