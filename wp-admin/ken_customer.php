<?php
/**
 * Dashboard Administration Screen
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Bootstrap */
require_once __DIR__ . '/admin.php';
require_once ABSPATH . 'wp-admin/admin-header.php';

global $wpdb;
$table = $wpdb->prefix . 'customer';

$id = $_GET['customer'];
$queryResult = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$table} WHERE id=%d",$id));

$edit = admin_url( '/ken_customer_edit.php?customer=' .$id . '&action=edit' );
$home = admin_url('?page=customer_managerment.php');

if (!empty($queryResult)) {
    function column_type_member($item)
    {
        $member = '-';
        if ($item == 1) {
            $member = 'Weekly member';
        }
        if ($item == 2) {
            $member = 'Monthly member';
        }
        return $member;
    }

    function column_member_ship($item)
    {
        $member = 'Normal member';
        if ($item == 1) {
            $member = 'Member';
        }
        return $member;
    }
    $user = $queryResult[0]; ?>
    <div class="wrap">
        <div class="container">
            <table class="table table-striped widefat " cellspacing="0">
                <thead>
                <tr>
                    <td colspan="2"><h3>Customer infomation</h3></td>
                </tr>
                </thead>
                <tbody>
                <tr class="alternate">
                    <td class="column-columnname"><b>Email</b></td>
                    <td class="column-columnname"><?= isset($user->email) ? $user->email : '-' ?></td>
                </tr>
                <tr class="alternate">
                    <td class="column-columnname"><b>First name</b></td>
                    <td class="column-columnname"><?= isset($user->first_name) ? $user->first_name : '-' ?></td>
                </tr>
                <tr class="alternate">
                    <td class="column-columnname"><b>Last name</b></td>
                    <td class="column-columnname"><?= isset($user->last_name) ? $user->last_name : '-' ?></td>
                </tr>
                <tr class="alternate">
                    <td class="column-columnname"><b>Birth day</b></td>
                    <td class="column-columnname"><?= isset($user->birth_day) ? $user->birth_day : '-' ?></td>
                </tr>
                <tr class="alternate">
                    <td class="column-columnname"><b>Membership</b></td>
                    <td class="column-columnname"><?= column_member_ship($user->member_ship) ?></td>
                </tr>
                <tr class="alternate">
                    <td class="column-columnname"><b>Type member</b></td>
                    <td class="column-columnname"><?= column_type_member($user->type_member) ?></td>
                </tr>
                <tr class="alternate">
                    <td class="column-columnname"><b>Start date</b></td>
                    <td class="column-columnname"><?= isset($user->start_date) ? $user->start_date : '-' ?></td>
                </tr>
                <tr class="alternate">
                    <td class="column-columnname"><b>End date</b></td>
                    <td class="column-columnname"><?= isset($user->end_date) ? $user->end_date : '-' ?></td>
                </tr>
                </tbody>
            </table>
            <div style="margin-top: 5px">
                <a href="<?= $edit ?>" class="button">Edit</a>
                <a href="<?= $home ?>" class="button">Back</a>
            </div>
        </div>
    </div>
    <?php
} else {
    echo 'Dữ liệu không tồn tại!';
}
?>
<?php

require_once ABSPATH . 'wp-admin/admin-footer.php';
