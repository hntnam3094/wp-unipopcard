<?php

/*

Plugin Name: My customer admin page

Description: Adds a custom admin pages with sample styles and scripts.

Version: 1.0.0

Author: Artbees

Author URI: http://artbees.net

Text Domain: my-custom-admin-page

*/



function my_admin_menu() {
    add_menu_page(
        __( 'Customer managerment', 'customer_page' ),
        __( 'Customer', 'customer_menu' ),
        'manage_options',
        'customer_managerment',
        'my_admin_page_contents',
        'dashicons-schedule',
        8
    );

    // adding submenu
    $hook = add_submenu_page("career","Custom List","Custom List",'edit_posts', "career", "custom_list_page");
    add_action('load-'.$hook, 'add_options');
}
add_action( 'admin_menu', 'my_admin_menu' );

function add_options() {
    $option = 'per_page';
    $args = array(
        'label' => 'Results',
        'default' => 10,
        'option' => 'results_per_page'
    );
    add_screen_option( $option, $args );

}

function customer_list_page () {
    if(!class_exists('Link_List_Table')){
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }

    class Link_List_Table extends WP_List_Table {
        function __construct() {
            parent::__construct( array(
                'singular'  => 'singular_name',     //singular name of the listed records
                'plural'    => 'plural_name',    //plural name of the listed records
                'ajax'      => false
            ) );
        }
    }

    $wp_list_table = new Link_List_Table();

    if( isset($_GET['s']) ){
        $wp_list_table->prepare_items($_GET['s']);
    } else {
        $wp_list_table->prepare_items();
    }
}

function column_default( $item, $column_name )
{
    switch( $column_name ) {
        case 'first_column_name':
        case 'second_column_name':
        case 'third_column_name':
        case 'fourth_column_name':
            return "<strong>".$item[$column_name]."</strong>";
        default:
            return print_r( $item, true ) ;
    }
}

function get_sortable_columns() {

    $sortable_columns = array(
        'first_column_name'     => array('first_column_name',true),
        'second_column_name' => array('second_column_name',true) );
    return $sortable_columns;
}

function my_admin_page_contents() {
    ?>
    <h1>
        <?php esc_html_e( 'Welcome to my custom admin page.', 'customer_managerment' ); ?>
    </h1>
    <?php
}




function register_my_plugin_scripts() {
    wp_register_style( 'my-plugin', plugins_url( 'ddd/css/plugin.css' ) );
    wp_register_script( 'my-plugin', plugins_url( 'ddd/js/plugin.js' ) );
}
add_action( 'admin_enqueue_scripts', 'register_my_plugin_scripts' );



function load_my_plugin_scripts( $hook ) {
// Load only on ?page=sample-page
    if( $hook != 'toplevel_page_sample-page' ) {
        return;
    }
// Load style & scripts.
    wp_enqueue_style( 'my-plugin' );
    wp_enqueue_script( 'my-plugin' );
}
add_action( 'admin_enqueue_scripts', 'load_my_plugin_scripts' );
