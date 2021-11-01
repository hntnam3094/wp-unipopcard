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
    public $message;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_customer_managerment'));
        add_action('admin_head', array(&$this, 'admin_header'));
    }


    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_customer_managerment()
    {
        $hook = add_menu_page( 'Customer', 'Customer', 'manage_options',
            'customer_managerment.php', array($this, 'list_table_page'), 'dashicons-universal-access' );
        add_action( "load-$hook", 'add_options' );

        function add_options()
        {
            $option = 'per_page';
            $args = array(
                'label' => 'Customer',
                'default' => 10,
                'option' => 'customer_per_page'
            );
            add_screen_option($option, $args);
        }

    }



    function admin_header() {
        $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
        if( 'customer_managerment.php' != $page )
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
        $selected = '';
        if ($_POST['type_membership'] != '') {
            $selected = $_POST['type_membership'];
        }
        $customer = new Customer_Table();
        $customer->prepare_items();
        $add    = admin_url( 'ken_customer_edit.php');
        ?>
        <div class="wrap">
            <div style="margin-bottom: 15px" >
                <h2 style="font-size: 30px">Customer management</h2>
                <a href="<?= $add ?>" class="page-title-action">Add new</a>
            </div>
            <div class="alignleft">
                <form method="post">
                    <select id="select-type-membership" name="type_membership">
                        <option value="" <?= $selected == '' ? 'selected' : '' ?>>Type member</option>
                        <option value="0" <?= $selected == 0 ? 'selected' : '' ?>>Not active</option>
                        <option value="1" <?= $selected == 1 ? 'selected' : '' ?>>Monthly member</option>
                        <option value="2" <?= $selected == 2 ? 'selected' : '' ?>>Yearly member</option>
                    </select>
                    <button type="submit" class="button">Apply</button>
                </form>
            </div>
            <div>
                <form method="post">
                    <?php $customer->search_box('search', 'search_id'); ?>
                </form>
            </div>

            <?php
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
        $this->_column_headers = $this->get_column_info();

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ));

        $perPage = $this->get_items_per_page('customer_per_page', 5);
        $currentPage = $this->get_pagenum();
//        $perPage = 2;
//        $currentPage = $this->get_pagenum();
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
        return array('email' => array('email', false),'first_name' => array('first_name', false),'last_name' => array('last_name', false));
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
        $result = [];
        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table} "));

        if (!empty($_POST) && isset($_POST['s'])) {

            $char = $_POST['s'] . '%';
            $result = $wpdb->get_results(
                "SELECT * FROM {$table} WHERE email LIKE '$char' OR first_name LIKE '$char' OR last_name LIKE '$char';");
        }

        if (!empty($_POST) && $_POST['type_membership'] != '') {
            $type = $_POST['type_membership'];
            $result = $wpdb->get_results(
                "SELECT * FROM {$table} WHERE type_member = '$type';");
        }



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
    function validateEmail($email) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        else {
            return false;
        }
    }

    function column_email($item) {
        $text = 'Are you sure?';
        $view    = admin_url( 'ken_customer.php?customer=' .$item['id'] . '&action=view' );
        $edit    = admin_url( 'ken_customer_edit.php?customer=' .$item['id'] . '&action=edit' );
        $password = [
            'password'    => sprintf( '<a href="?page=%s&action=%s&customer=%s">Submit new password</a>',$_REQUEST['page'],'password',$item['email'])
        ];

        $actions = array(
            'view'      => sprintf('<a href="%s">View</a>',$view),
            'edit'      => sprintf('<a href="%s">Edit</a>',$edit),
            'delete'    => sprintf( '<a href="?page=%s&action=%s&customer=%s" onclick="return confirm(`Are you sure?`)">Delete</a>',$_REQUEST['page'],'delete',$item['id'])
        );

        if ($this->validateEmail($item['email'])) {
            $actions = array_merge($actions, $password);
        }

        return sprintf('%1$s %2$s', $item['email'], $this->row_actions($actions) );
    }

    function column_type_member($item)
    {
        $member = '-';
        if ($item['type_member'] == 1) {
            $member = 'Monthly member';
        }
        if ($item['type_member'] == 2) {
            $member = 'Yearly member';
        }
        return $member;
    }

    function column_member_ship($item)
    {
        $member = '-';
        if ($item['member_ship'] == 1) {
            $member = 'Membership';
        }
        return $member;
    }

    function column_id($item)
    {

    }

//    function get_bulk_actions() {
//        $actions = array(
//            'edit'    => 'Edit'
//        );
//        return $actions;
//    }



    function process_bulk_action() {
        global $wpdb;
        $table = $wpdb->prefix . 'customer';
        if( 'password' == $this->current_action() )
        {
            $email = $_GET['customer'];
            if (!empty($email)) {
                $queryResult = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT * FROM {$table} WHERE email=%s",$email));
                if (!empty($queryResult)) {
                    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                    $pass = array();
                    $alphaLength = strlen($alphabet) - 1;
                    for ($i = 0; $i < 8; $i++) {
                        $n = rand(0, $alphaLength);
                        $pass[] = $alphabet[$n];
                    }

                    $random_pass = implode($pass);

                    $data = [ 'password' => md5($random_pass) ];
                    $where = [ 'email' => $email ];
                    $results = $wpdb->update( $table, $data, $where);

                    if ($results != 0) {
                        do_action('forget_password_email', $email, $random_pass);
                        wp_die('Please check email to get new password!!');
                    }
                }
            }
        }

        if( 'delete' == $this->current_action() )
        {
            $id = $_GET['customer'];
            $wpdb->delete( $table, array( 'id' => $id ) );
            wp_die('This customer has been deleted!');
        }

    }


}
?>
