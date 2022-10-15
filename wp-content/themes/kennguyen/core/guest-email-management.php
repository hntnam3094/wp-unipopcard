<?php
add_action( 'admin_menu', 'my_admin_menu2' );
function my_admin_menu2() {
    add_menu_page( 'Guest email management', 'Guest email', 'manage_options', 'kn-guest-email', 'admin_guest_email_page', 'dashicons-email');
}

if ($_GET['guest_id']) {
    global $wpdb;
    $id = $_GET['guest_id'];
    $result = $wpdb->get_results ( "SELECT * FROM  wp_guest_email WHERE id=" . $id );
    if (!empty($result)) {
        $rs = $wpdb->delete( 'wp_guest_email', ['id' => $id]);
    }
}

function admin_guest_email_page(){
    global $wpdb;
    $query = 'SELECT * FROM wp_guest_email';
    $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total = $wpdb->get_var( $total_query );
    $items_per_page = 10;
    $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
    $offset = ( $page * $items_per_page ) - $items_per_page;
    $result = $wpdb->get_results( $query . " LIMIT ${offset}, ${items_per_page}" );
    ?>
    <div class="wrap">
        <h2>Guest email management</h2>
        <table class="widefat fixed" style="margin-bottom: 15px;">
            <thead>
            <tr>
                <th class="manage-column column-columnname" scope="col">No</th>
                <th class="manage-column column-columnname" scope="col">Email</th>
                <th class="manage-column column-columnname" scope="col">Action</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $no = 1;
            foreach ($result as $value) { ?>
                <tr class="alternate">
                    <td class="column-columnname"><?= $no++ ?></td>
                    <td class="column-columnname"><?= $value->email ?></td>
                    <td class="column-columnname">
                        <a href="?page=kn-guest-email&guest_id=<?= $value->id ?>" onclick="return confirm(`Are you sure?`)">Delete</a>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
        <div style="text-align: right">
            <?php
            echo paginate_links( array(
                'base' => add_query_arg( 'cpage', '%#%' ),
                'format' => '',
                'prev_text' => __('&laquo;'),
                'next_text' => __('&raquo;'),
                'total' => ceil($total / $items_per_page),
                'current' => $page
            ));
            ?>
        </div>
    </div>
    <?php
}
