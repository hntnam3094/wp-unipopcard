<?php
/*
 * Plugin Name: Report management
 * Description: An example of how to use the WP_List_Table class to display data in your WordPress Admin area
 * Plugin URI: http://www.paulund.co.uk
 * Author: Paul Underwood
 * Author URI: http://www.paulund.co.uk
 * Version: 1.0
 * License: GPL2
 */

if(is_admin())
{
    new Report_List_Table();
}

/**
 * Paulund_Wp_List_Table class will create the page to load the table
 */
class Report_List_Table
{
    /**
     * Constructor will create the menu item
     */
    public $message;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_report_management'));
        add_action('admin_head', array(&$this, 'admin_header'));
    }


    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_report_management()
    {
        $hook = add_menu_page( 'Reports', 'Reports', 'manage_options', 'report_management.php', array($this, 'list_table_page') );
        add_action( "load-$hook", 'add_options' );

    }

    function add_options()
    {
        $option = 'per_page';
        $args = array(
            'label' => 'Reports',
            'default' => 10,
            'option' => 'report_per_page'
        );
        add_screen_option($option, $args);
    }



    function admin_header() {
        $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
        if( 'report_management.php' != $page )
            return;

        echo '<style type="text/css">';
        echo '.wp-list-table .column-email { width: 30%; }';
        echo '</style>';
    }

    /**
     * Display the list table page
     *
     * @return Void
     */
    public function list_table_page()
    {
        $customer = new Report_Table();
        $customer->prepare_items();
        ?>
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <div style="display: flex; align-items: center">
                <h1 style="font-weight: bold; margin-right: 30px">Customer</h1>
            </div>
            <?php
            $customer->search_box('search', 'search_id');
            $customer->display();
            ?>
        </div>
        <?php
    }
}

// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Report_Table extends WP_List_Table
{
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = $this->get_column_info();

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ));

        $perPage = $this->get_items_per_page('books_per_page', 5);
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
        $this->process_bulk_action();
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'full_name' => 'Full name',
            'email'       => 'Email',
            'package'        => 'Package',
            'price'    => 'Price',
            'sale_price'      => 'Sale price',
        );

        return $columns;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array('email' => array('email', false),'full_name' => array('full_name', false),
            'package' => array('package', false),'price' => array('price', false),
            'sale_price' => array('sale_price', false));
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        $data = array();

        global $wpdb;
        $table = $wpdb->prefix . 'order';
        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table} "));


        foreach ($result as $item) {
            $data[] = (array)$item;
        }

        return $data;
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'email':
            case 'full_name':
            case 'package':
            case 'price':
            case 'sale_price':
                return $item[ $column_name ];

            default:
                return print_r( $item, true ) ;
        }
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'email';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }


        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc')
        {
            return $result;
        }

        return -$result;
    }
}
?>
