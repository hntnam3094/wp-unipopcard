<?php
/**
 * Template Name: Account page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

include_once dirname( __FILE__ ).'/auth.php';
if (isset($_SESSION['user'])) {
$user = $_SESSION['user'];
$active = '';
$password_message = '';
$infomartion_message = '';
if ($_POST) {
    global $wpdb;
    $table = $wpdb->prefix.'customer';

    $first_name = $wpdb->escape($_POST['first_name']);
    $last_name = $wpdb->escape($_POST['last_name']);
    $birth_day = $wpdb->escape($_POST['birth_day']);
    $email = $wpdb->escape($_POST['email']);

    $old_password = $wpdb->escape($_POST['old_password']);
    $new_password = $wpdb->escape($_POST['new_password']);
    $new_password_confirm = $wpdb->escape($_POST['new_password_confirm']);

    if (isset($_POST['subsciptionNo'])) {
        $active = 'membership';
        $jsonRpcRequestCancel = array (
            'method' => 'cancelSubscription',
            'params' => array($sessionID, $_POST['subsciptionNo']),
            'id' => $i++,
            'jsonrpc' => '2.0');

        callRPC((Object)$jsonRpcRequestCancel, $host, true);
    }

    if (isset($_POST['old_password'])) {
        $active = 'password';
        if (empty($old_password) || empty($new_password) || empty($new_password_confirm)) {
            $password_message = '<p style="color: red">Please complete password information!</p>';
        } elseif (strlen($new_password) < 6 || strlen($new_password_confirm) < 6 ) {
            $password_message = '<p style="color: red">New password must be longer than 6 characters!</p>';
        } elseif ($new_password != $new_password_confirm) {
            $password_message = '<p style="color: red">Confirm password does not match the new password!</p>';
        } else {
            $queryResult = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * 
                            FROM {$table} 
                            WHERE email=%s 
                            AND password=%s",
                    $user->email, md5($old_password)));

            if (empty($queryResult)) {
                $password_message = '<p style="color: red">Wrong old password!</p>';
            } else {
                $data = [ 'password' => md5($new_password) ];
                $where = [ 'email' => $user->email ];
                $results = $wpdb->update( $table, $data, $where);
                if ($results != 0) {
                    $password_message = '<p style="color: green">Change password successfully!</p>';
                } else {
                    $password_message = '<p style="color: red">Change password failed!</p>';
                }
            }
        }
    }
    if (isset($_POST['first_name']) || isset($_POST['last_name']) || isset($_POST['birth_day']) || isset($_POST['email'])){
        $active = 'infomartion';

        $data = [ 'first_name' => $first_name,
                  'last_name' => $last_name,
                  'birth_day' => $birth_day,
                  'email' => $email ];

        $where = [ 'email' => $user->email ];
        $results = $wpdb->update( $table, $data, $where);
        if ($results != 0) {
            $queryResult = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$table}  WHERE email=%s ", $user->email));

            $_SESSION['user'] = $queryResult[0];
            $infomartion_message = '<p style="color: green">Data update successful!!</p>';
        } else {
            $infomartion_message = '<p style="color: green">No data changes!!!</p>';
        }

    }

}
get_header();
?>
<main>

    <section class="my_project pt-40 pb-100">
        <div class="wraper">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="manager_member">
                        <div class="info flexBox midle">
                            <div class="avatar">
                                <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/avatar.png" alt=""/></div>
                            </div>
                            <div class="name">
                                <div class="fz-18">Account of</div>
                                <div class="fz-24"><?= $user->first_name .' '. $user->last_name ?></div>
                            </div>
                        </div>
                        <?php
                        $expired_date = [];
                        $level_membership = 'Not active';
                        if (isset($_SESSION['user'])) {
                            $user = $_SESSION['user'];
                            $today = date("Y-m-d");
                            if (!empty($user->start_date) && !empty($user->end_date)) {
                                if ($today >= $user->start_date && $today <= $user->end_date) {
                                    $now = time();
                                    $number_end = strtotime($user->end_date);
                                    $days_left = $number_end - $now;
                                    $total_days = round($days_left / (60 * 60 * 24));

                                    $date_formate = date('l,F j, Y', strtotime($user->end_date));
                                    $expired_date = [
                                        'days_left' => $total_days,
                                        'date_format' => $date_formate
                                    ];
                                } else {
                                    $expired_date = [
                                    ];
                                }
                            }

                            if ($user->type_member != 0) {
                                if ($user->type_member == 1) {
                                    $level_membership = 'Monthly member';
                                }

                                if ($user->type_member == 2) {
                                    $level_membership = 'Yearly member';
                                }
                            }
                        }
                        ?>
                        <div class="info_course">
                            <ul>
                                <li class="mt-40"><a href="<?php site_url() ?>/my-craft-room">
                                        <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01_on.svg" alt=""/></div>
                                        <div class="txt">My Downloaded Projects</div></a></li>
                                <?php if (empty($expired_date)) {
                                    ?>
                                    <li class="mt-40"><a href="<?php site_url() ?>/upgrade-today">
                                            <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_02.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_02_on.svg" alt=""/></div>
                                            <div class="txt">Upgrade Today</div></a></li>
                                    <?php
                                }
//                                else {
//                                    ?>
<!--                                    <li class="mt-40"><a href="--><?php //site_url() ?><!--/history">-->
<!--                                            <div class="icon"> <img src="--><?php //bloginfo('template_directory') ?><!--/common/images/icon/acc_03.svg" alt=""/><img class="on" src="--><?php //bloginfo('template_directory') ?><!--/common/images/icon/acc_02_on.svg" alt=""/></div>-->
<!--                                            <div class="txt">History order</div></a></li>-->
<!--                                    --><?php
//                                }?>

                                <li class="mt-40"><a class="active" href="<?php site_url() ?>/account">
                                        <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_03.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_03_on.svg" alt=""/></div>
                                        <div class="txt">Account Settings</div></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 project">
                    <div class="course_my pt-40 pb-50 bg_white">
                        <h1 class="ttl_main fz-20 text-center text-up">Account Settings</h1>
                        <div class="info_detail mt-30">
                            <div class="wrap">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?= $active == '' ? 'active' : $active == 'infomartion' ? 'active' : '' ?>" id="tab01-tab" data-bs-toggle="tab" data-bs-target="#tab01" type="button" role="tab" aria-controls="tab01" aria-selected="true"> <i class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/info_01.svg" alt=""/></i><span>Account Details</span></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?= $active == 'password' ? 'active' : '' ?>" id="tab02-tab" data-bs-toggle="tab" data-bs-target="#tab02" type="button" role="tab" aria-controls="tab02" aria-selected="false"> <i class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/info_02.svg" alt=""/></i><span> Change Password</span></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab03-tab" data-bs-toggle="tab" data-bs-target="#tab03" type="button" role="tab" aria-controls="tab03" aria-selected="false"> <i class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/info_03.svg" alt=""/></i><span>Manage Membership</span></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="modal" data-bs-target="#modal_logout"> <i class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/info_04.svg" alt=""/></i><span>Log out</span></button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content mt-40" id="myTabContent">
                                <div class="tab-pane fade <?= $active == '' ? 'show active' : $active == 'infomartion' ? 'show active' : '' ?>" id="tab01" role="tabpanel" aria-labelledby="tab01-tab">
                                    <h2 class="ttl_sub fz-22">Account Settings</h2>
                                    <?php echo $infomartion_message?>
                                    <div class="info mt-30">
                                        <form class="form_edit" action="" method="post">
                                            <div class="group">
                                                <input type="text" name="first_name" value="<?php echo isset($user->first_name) ? $user->first_name : ''?>"/>
                                            </div>
                                            <div class="group">
                                                <input type="text" name="last_name" value="<?php echo isset($user->last_name) ? $user->last_name : ''?>"/>
                                            </div>
                                            <div class="group">
                                                <input type="date" name="birth_day" lang="en" value="<?php echo isset($user->birth_day) ? $user->birth_day : ''?>"/>
                                            </div>
                                            <div class="group">
                                                <input type="mail" name="email" value="<?php echo isset($user->email) ? $user->email : ''?>" readonly/>
                                            </div>
                                            <div class="group">
                                                <input class="btn_submit" type="submit" value="Save Changes"/>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade <?= $active == 'password' ? 'show active' : '' ?>" id="tab02" role="tabpanel" aria-labelledby="tab02-tab">
                                    <h2 class="ttl_sub fz-22">Change Password</h2>
                                    <?php echo $password_message?>
                                    <div class="info mt-30">
                                        <form class="form_edit" action="" method="post">
                                            <div class="group">
                                                <input type="text" name="old_password" placeholder="Old password"/>
                                            </div>
                                            <div class="group">
                                                <input type="text" name="new_password" placeholder="New password"/>
                                            </div>
                                            <div class="group">
                                                <input type="text" name="new_password_confirm" placeholder="Confirm new password"/>
                                            </div>
                                            <div class="group">
                                                <input class="btn_submit" type="submit" type="text" value="Save Changes"/>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade <?= $active == 'membership' ? 'show active' : '' ?>" id="tab03" role="tabpanel" aria-labelledby="tab03-tab">
                                    <h2 class="ttl_sub fz-22">Membership Details</h2>
                                    <div class="info mt-30">
                                        <div class="row">
                                            <div class="col-12 col-md-5">
                                                <div class="label">Membership Level:</div>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="content">
                                                    <p><?= $level_membership  ?><br>
                                                        <?php
                                                            if (check_membership() != 2) { ?>
                                                        <a href="<?php site_url() ?>/upgrade-today">Upgrade to the yearly plan </a>to get the best value for your membership!</p>
                                                        <?php    }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-5">
                                                <div class="label">Membership Expiration:</div>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <?php
                                                if (!empty($expired_date)) { ?>
                                                    <div class="content">
                                                        <?= $expired_date['date_format'] ?> (<?= $expired_date['days_left'] ?> days left) After this date you will not be able to download any project files or access members-only content.
                                                    </div>
                                               <?php } else { ?>
                                                    <div class="content">
                                                        <a href="<?php site_url() ?>/upgrade-today">JOIN NOW</a>
                                                    </div>
                                               <?php }?>
                                            </div>
                                            <?php
                                            $jsonRpcRequest = array (
                                                'method' => 'getSubscription',
                                                'params' => array($sessionID, $user->subNo),
                                                'id' => $i++,
                                                'jsonrpc' => '2.0');

                                            $data = callRPC((Object)$jsonRpcRequest, $host, true);
                                            $status = $data->RecurringEnabled;
                                            if ($data->Status != 'DISABLED' && $status) { ?>
                                                <div class="info">
                                                    <form class="form_edit" action="" method="post">
                                                        <div class="group">
                                                            <input type="hidden" name="subsciptionNo" value="<?= $user->subNo ?>"/>
                                                            <input class="btn_submit" type="submit" onclick="return confirm('Do you wanna cancel renewal?')" value="Cancel renewal"/>
                                                        </div>
                                                    </form>
                                                </div>
                                           <?php }
                                            ?>

                                        </div>

                                        <?php
                                        $table = $wpdb->prefix . 'order';

                                        $queryResultOrder = $wpdb->get_results(
                                            $wpdb->prepare("SELECT * FROM {$table} WHERE id_customer=%d ",$user->id));
                                        ?>
                                        <div class="row pt-20">
                                            <?php
                                            if (isset($queryResultOrder)) {
                                                ?>
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Email/Name</th>
                                                        <th scope="col">Package</th>
                                                        <th scope="col">Bought date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    function validateEmail($email) {
                                                        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                            return true;
                                                        }
                                                        else {
                                                            return false;
                                                        }
                                                    }
                                                    foreach ($queryResultOrder as $key =>$item) { ?>
                                                        <tr>
                                                            <th scope="row"><?= $key + 1 ?></th>
                                                            <td><?= validateEmail($item->email) ? $item->email : $item->full_name ?></td>
                                                            <td><?= $item->package ?></td>
                                                            <td><?= $item->bought_date ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="content pt-5">
                                                    <p>You do not have any order!</p>
                                                    <a href="<?php site_url() ?>/upgrade-today">JOIN NOW</a>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer();
} else {
    wp_redirect(home_url());
    exit;
}
?>
