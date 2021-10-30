<?php
/*
 * Plugin Name: Customer managerment
 * Description: An example of how to use the WP_List_Table class to display data in your WordPress Admin area
 * Plugin URI: http://www.paulund.co.uk
 * Author: Paul Underwood
 * Author URI: http://www.paulund.co.uk
 * Version: 1.0
 * License: GPL2
 */

if(is_admin())
{
    new Paulund_Wp_List_Table();
}

/**
 * Paulund_Wp_List_Table class will create the page to load the table
 */
class Paulund_Wp_List_Table
{
    /**
     * Constructor will create the menu item
     */
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'add_customer_managerment' ));
    }

    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_customer_managerment()
    {
        add_menu_page( 'Khách hàng', 'Khách hàng', 'manage_options', 'customer_managerment.php', array($this, 'list_table_page') );
        add_submenu_page( 'Thêm mới ', 'Thêm mới ', 'Thêm mới', 'manage_options', 'add_new_customer', 'edit_customer' );
    }

    /**
     * Display the list table page
     *
     * @return Void
     */
    public function list_table_page()
    {
        $customer = new Customer_Table();
        $customer->prepare_items();
        ?>
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h2>Khách hàng</h2>
            <?php $customer->display(); ?>
        </div>
        <?php
    }
}

// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Customer_Table extends WP_List_Table
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

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ));

        $perPage = 10;
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
            'id'          => 'ID',
            'email'       => 'Email',
            'first_name' => 'First Name',
            'last_name'        => 'Last Name',
            'birth_day'    => 'Birth day',
            'member_ship'      => 'Membership',
            'type_member'      => 'Type member'
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
        return array('email' => array('email', false));
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
        $table = $wpdb->prefix . 'customer';
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
            case 'id':
            case 'email':
            case 'first_name':
            case 'last_name':
            case 'birth_day':
            case 'member_ship':
            case 'type_member':
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

    function column_email($item) {
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&email=%s">Chỉnh sửa</a>',$_REQUEST['page'],'edit',$item['id']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&email=%s">Xóa</a>',$_REQUEST['page'],'delete',$item['id']),
            'view'      => sprintf('<a href="?page=%s&action=%s&email=%s">Xem</a>',$_REQUEST['page'],'view',$item['id']),
            'passsword'    => sprintf('<a href="?page=%s&action=%s&email=%s">Gửi lại mật khẩu mới</a>',$_REQUEST['page'],'password',$item['id']),
        );
        return sprintf('%1$s %2$s', $item['email'], $this->row_actions($actions) );
    }

    function column_type_member($item)
    {
        $member = 'Không hỗ trợ';
        if ($item['type_member'] == 1) {
            $member = 'Thành viên tháng';
        }
        if ($item['type_member'] == 2) {
            $member = 'Thành viên năm';
        }
        return $member;
    }

    function column_member_ship($item)
    {
        $member = 'Chưa đăng ký';
        if ($item['membership'] == 1) {
            $member = 'Đã đăng ký';
        }
        return $member;
    }

//    function get_bulk_actions() {
//        $actions = array(
//            'edit'    => 'Edit'
//        );
//        return $actions;
//    }

    function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        if( 'delete' == $this->current_action() )
        {
            echo '<script>
                        
                    </script>';
            $id = $_GET['email'];
            wp_die($id);
        }

        if( 'edit' == $this->current_action() )
        {
            $id = $_GET['email'];
            $this->edit_customer($id);
        }
    }

    function edit_customer($id) {
        wp_die($id);
    }


}
?>
