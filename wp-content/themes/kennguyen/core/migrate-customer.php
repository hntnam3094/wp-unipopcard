<?php
/**
 * Plugin Name: Migration - Customer
 * Plugin URI: https://www.myplugin.com
 * Description: Plugin Description
 * Version: 1.0.0
 * Author: myplugin
 * Author URI: https://www.myplugin.com
 * Requires at least: 5.5.1
 * Tested up to: 5.5.1
 */
if ( !defined( 'ABSPATH' ) ) exit;
//tạo hook active plugins
add_action('init', 'my_plugin_create_db');

//tạo database từ hook
function my_plugin_create_db() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();
    $table_customer = $wpdb->prefix . 'customer';
    $table_customer_dowload = $wpdb->prefix . 'customer_download';
    $table_order = $wpdb->prefix . 'order';

    if($wpdb->get_var("SHOW TABLES LIKE '$table_customer'" ) != $table_customer){
        $sql= "CREATE TABLE $table_customer (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            birth_day DATE,
            member_ship INT DEFAULT 0,
            type_member INT DEFAULT 0,
            start_date DATE,
            end_date DATE,
            active INT DEFAULT 0,
            created_at DATETIME,
            subNo VARCHAR(50),
            trackingMd5 VARCHAR(500),
            id_google VARCHAR(500),
            id_facebook VARCHAR(500));";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    if($wpdb->get_var("SHOW TABLES LIKE '$table_customer_dowload'" ) != $table_customer_dowload){
        $sql= "CREATE TABLE $table_customer_dowload (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            id_customer INT DEFAULT 0,
            id_post INT DEFAULT 0);";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    if($wpdb->get_var("SHOW TABLES LIKE '$table_order'" ) != $table_order){
        $sql= "CREATE TABLE $table_order (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            id_customer INT DEFAULT 0,
            email VARCHAR(255) ,
            full_name VARCHAR(255),
            package VARCHAR(255),
            price FLOAT DEFAULT 0,
            sale_price FLOAT DEFAULT 0,
            status INT DEFAULT 0,
            bought_date DATETIME ,
            refno VARCHAR(50),
            orderData LONGTEXT);";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

//    $sql = "CREATE TABLE $table_customer (
//		id mediumint(9) NOT NULL AUTO_INCREMENT,
//		email varchar(255) NOT NULL,
//		password varchar(255) NOT NULL,
//		first_name varchar(255) DEFAULT '',
//		last_name varchar(255) DEFAULT '',
//		birth_day date DEFAULT '',
//		member_ship int DEFAULT 0,
//		type_member int DEFAULT 0,
//		start_date date DEFAULT '',
//		end_date date DEFAULT '',
//		active int DEFAULT 1,
//		PRIMARY KEY  (id)
//	);";

//    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//    dbDelta( $sql );
}




