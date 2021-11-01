<?php
/**
 * Template Name: Verify page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */
        get_header();
        $token = $_GET['token'];

        if (isset($token)) {
            global $wpdb;
            $table = $wpdb->prefix.'customer';

            $data = [ 'active' => 1 ]; // NULL value.
            $where = [ 'trackingMd5' => $token ]; // NULL value in WHERE clause.
            $results = $wpdb->update( $table, $data, $where ); // Also works in this case.

            if ($results != 0) {
                echo "<h5 style='color: green'>Kích hoạt tài khoản thành công!</h5>";
            } else {
                echo "<h5 style='color: red'>Gặp lỗi khi kích hoạt tài khoản!Vui lòng kiểm tra lại email đã đăng ký!</h5>";
            }
        }
        get_footer();
        ?>
