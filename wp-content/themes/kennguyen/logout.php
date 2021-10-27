<?php
/**
 * Template Name: Logout page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

wp_logout();
wp_redirect( site_url() . '/login' );
exit;
?>


