<?php
if (check_membership() != 1) {
    if (!empty($_POST)) {
        global $wpdb;
        $table = $wpdb->prefix .'guest_email';
        $data = array(
            'email'    => $_POST['guest_email']
        );

        if (isset($_POST['guest_email'])) {
            $query = 'SELECT * FROM wp_guest_email where email like "'.$_POST['guest_email'].'"';
            $total_query = "SELECT COUNT(1) FROM (${query}) AS totalEmail";
            $total = $wpdb->get_var( $total_query );
            if ($total == 0) {
                $success=$wpdb->insert( $table, $data );
            }
        }
    }
    echo '<div class="form_submit pt-20">
                                        <form method="post">
                                            <input class="input" name="guest_email" type="text" placeholder="Your Email Adress"/>
                                            <input class="submit" type="submit" value="JOIN NOW"/>
                                        </form>
                                    </div>';
}
?>
