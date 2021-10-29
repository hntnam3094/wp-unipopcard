<?php
/**
 * Template Name: Account page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

if (!empty($_SESSION['user'])) {
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

    if (isset($_POST['old_password'])) {
        $active = 'password';
        if (empty($old_password) || empty($new_password) || empty($new_password_confirm)) {
            $password_message = '<p style="color: red">Vui lòng điền đầy đủ thông tin mật khẩu!</p>';
        } elseif (strlen($new_password) < 6 || strlen($new_password_confirm) < 6 ) {
            $password_message = '<p style="color: red">Mật khẩu mới phải dài hơn 6 ký tự!</p>';
        } elseif ($new_password != $new_password_confirm) {
            $password_message = '<p style="color: red">Mật khẩu nhập lại không trùng với mật khẩu mới!</p>';
        } else {
            $queryResult = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * 
                            FROM {$table} 
                            WHERE email=%s 
                            AND password=%s",
                    $user->email, md5($old_password)));

            if (empty($queryResult)) {
                $password_message = '<p style="color: red">Mật khẩu cũ sai!</p>';
            } else {
                $data = [ 'password' => md5($new_password) ];
                $where = [ 'email' => $user->email ];
                $results = $wpdb->update( $table, $data, $where);
                if ($results != 0) {
                    $password_message = '<p style="color: green">Đổi mật khẩu thành công!</p>';
                } else {
                    $password_message = '<p style="color: red">Đổi mật khẩu thất bại!</p>';
                }
            }
        }
    } else {
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
            $infomartion_message = '<p style="color: green">Cập nhật dữ liệu thành công!!</p>';
        } else {
            $infomartion_message = '<p style="color: green">Không có dữ liệu thay đổi!!!</p>';
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
                        <div class="info_course">
                            <ul>
                                <li class="mt-40"><a href="<?php site_url() ?>/manager">
                                        <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01_on.svg" alt=""/></div>
                                        <div class="txt">My Downloaded Projects</div></a></li>
                                <li class="mt-40"><a href="upgrade.html">
                                        <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_02.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_02_on.svg" alt=""/></div>
                                        <div class="txt">Upgrade Today</div></a></li>
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
                                                <input type="text" name="birth_day" value="<?php echo isset($user->birth_day) ? $user->birth_day : ''?>"/>
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
                                <div class="tab-pane fade" id="tab03" role="tabpanel" aria-labelledby="tab03-tab">
                                    <h2 class="ttl_sub fz-22">Membership Details</h2>
                                    <div class="info mt-30">
                                        <div class="row">
                                            <div class="col-12 col-md-5">
                                                <div class="label">Membership Level:</div>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="content">
                                                    <p>Monthly<br><a href="">Upgrade to the yearly plan </a>to get the best value for your membership!</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-5">
                                                <div class="label">Membership Expiration:</div>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="content">Monday, August 30, 2021 (23 days left) After this date you will not be able to download any project files or access members-only content.</div>
                                            </div>
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
