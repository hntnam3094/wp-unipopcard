<?php
/**
 * Plugin Name: Customer managerment
 * Plugin URI: https://www.myplugin.com
 * Description: Plugin Description
 * Version: 1.0.0
 * Author: myplugin
 * Author URI: https://www.myplugin.com
 * Requires at least: 1.0
 * Tested up to: 1.0
 */

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Customers_List extends WP_List_Table
{

    /** Class constructor */
    public function __construct()
    {
        parent::__construct([
            'singular' => __('Customer', 'sp'), //singular name of the listed records
            'plural' => __('Customers', 'sp'), //plural name of the listed records
            'ajax' => false //should this table support ajax?

        ]);
    }
}
