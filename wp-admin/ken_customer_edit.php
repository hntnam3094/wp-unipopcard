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
$message_edit = '';
$message_add = '';
$id = $_GET['customer'];
$queryResult = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$table} WHERE id=%d",$id));

$save = admin_url( 'ken_customer_edit.php?customer=' .$id . '&action=edit' );
$customer = admin_url('?page=customer_managerment.php');

if ($_POST) {
    if (isset($_POST) && !isset($_POST['email'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $birth_day = $_POST['birth_day'];
        $member_ship = $_POST['member_ship'];
        $type_member = $_POST['type_member'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $active = $_POST['active'];

        $data = [   'first_name' => $first_name,
            'last_name' => $last_name,
            'birth_day' => $birth_day,
            'member_ship' => $member_ship,
            'type_member' => $type_member,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'active' => $active
        ];

        $where = [ 'id' => $id ];
        $results = $wpdb->update( $table, $data, $where);
        if ($results != 0) {
            $message_edit = '<h3 style="color: green">Update success!</h3>';
        }
    } else {
        $email = $_POST['email'];
        $password = md5($email);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $birth_day = $_POST['birth_day'];
        $member_ship = $_POST['member_ship'];
        $type_member = $_POST['type_member'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $active = $_POST['active'];
        $md5Tracking = md5($email);

        if (empty($email)) {
            $message_add = '<h3 style="color: red">Please enter required information (*)</h3>';
        } else {
            $results = $wpdb->query(
                $wpdb->prepare(
                    "SELECT * FROM $table WHERE email = %s", $email)
            );
            if ($results != 0) {
                $message_add = '<h3 style="color: red">Email is already exist!</h3>';
            } else {
                $data = array();
                $data['email'] = $email;
                $data['password'] = md5($email);
                $data['first_name'] = $first_name;
                $data['last_name'] = $last_name;
                $data['birth_day'] = $birth_day;
                $data['member_ship'] = $member_ship;
                $data['type_member'] = $type_member;
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                $data['created_at'] = date("Y-m-d h:i:s");
                $data['trackingMd5'] = md5($email);

                $insertRs = $wpdb->insert($table, $data);
                if (isset($insertRs)) {
                    $message_add = '<h3 style="color: green">Create account success! Plase check email to active your account!</h3>';
                    do_action('active_account_email', $data['email']);
                } else {
                    $message_add = 'Create account failed!';
                }
            }
        }
    }

}
if (!empty($queryResult)) {
    $user = $queryResult[0]; ?>
    <div class="wrap">
        <h1 style="font-weight: bold">Edit Customer</h1>
        <div class="container">
            <?php echo $message_edit?>
            <form method="post" action="">
                <table class="form-table" role="presentation">
                    <tr class="user-user-login-wrap">
                        <th><label for="user_login"><?php _e( 'Email' ); ?></label></th>
                        <td><input type="text" name="email" id="email" value="<?php echo esc_attr( $user->email ); ?>" disabled class="regular-text" /> <span class="description">This fields can not edit</span></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">First Name</label></th>
                        <td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $user->first_name ); ?>" class="regular-text" /></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Last Name</label></th>
                        <td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $user->last_name ); ?>" class="regular-text" /></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Birthday</label></th>
                        <td><input type="date" name="birth_day" id="birth_day" value="<?php echo esc_attr( $user->birth_day ); ?>" class="regular-text" /></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Membership</label></th>
                        <td>
                            <select id="member_ship" class="regular-text" name="member_ship">
                                <option value="0" <?= $user->member_ship == 0 ? 'selected' : '' ?>>-</option>
                                <option value="1" <?= $user->member_ship == 1 ? 'selected' : '' ?>>Membership</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Type member</label></th>
                        <td>
                            <select id="type_member" class="regular-text" name="type_member">
                                <option value="0" <?= $user->type_member == 0 ? 'selected' : '' ?>>-</option>
                                <option value="1" <?= $user->type_member == 1 ? 'selected' : '' ?>>Monthly member</option>
                                <option value="2" <?= $user->type_member == 2 ? 'selected' : '' ?>>Yearly member</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Start date</label></th>
                        <td><input type="date" name="start_date" id="start_date" value="<?php echo esc_attr( $user->start_date ); ?>" class="regular-text" /></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">End date</label></th>
                        <td><input type="date" name="end_date" id="end_date" value="<?php echo esc_attr( $user->end_date ); ?>" class="regular-text" /></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Active</label></th>
                        <td>
                            <select id="active" name="active">
                                <option value="0" <?= $user->active == 0 ? 'selected' : '' ?>>Not active</option>
                                <option value="1" <?= $user->active == 1 ? 'selected' : '' ?>>Active</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <div style="margin-top: 5px">
                    <button class="button">Save</button>
                    <a href="<?php echo $customer ?>" class="button">Back</a>
                </div>
            </form>

        </div>
    </div>
    <?php
} else { ?>
    <div class="wrap">
        <h1 style="font-weight: bold">Add new Customer</h1>
        <div class="container">
            <?= $message_add ?>
            <form action="" method="post">
                <table class="form-table" role="presentation">
                    <tr class="user-user-login-wrap">
                        <th><label for="user_login">Email<span style="color: red">*</span></label></th>
                        <td><input type="text" name="email" id="email" value="" class="regular-text" /></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">First Name</label></th>
                        <td><input type="text" name="first_name" id="first_name" value="" class="regular-text" /></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Last Name</label></th>
                        <td><input type="text" name="last_name" id="last_name" value="" class="regular-text" /></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Birthday</label></th>
                        <td><input type="date" name="birth_day" id="birth_day" value="" class="regular-text" /></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Membership</label></th>
                        <td>
                            <select id="member_ship" class="regular-text" name="member_ship">
                                <option value="0">-</option>
                                <option value="1">Membership</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Type member</label></th>
                        <td>
                            <select id="type_member" class="regular-text" name="type_member">
                                <option value="0">-</option>
                                <option value="1">Monthly member</option>
                                <option value="2">Yearly member</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">Start date</label></th>
                        <td><input type="date" name="start_date" id="start_date" value="" class="regular-text" /></td>
                    </tr>
                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">End date</label></th>
                        <td><input type="date" name="end_date" id="end_date" value="" class="regular-text" /></td>
                    </tr>
                </table>
                <div style="margin-top: 5px">
                    <button class="button">Save</button>
                    <a href="<?php echo $customer ?>" class="button">Back</a>
                </div>
            </form>

        </div>
    </div>

<?php
}

require_once ABSPATH . 'wp-admin/admin-footer.php';
