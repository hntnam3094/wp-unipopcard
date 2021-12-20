<?php
/**
 * Template Name: Logout page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

session_unset();
wp_redirect( site_url() . '/' );
exit;
?>


