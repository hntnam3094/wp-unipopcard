<?php
/**
 * Template Name: Forgot page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */
if (empty($_SESSION['user'])) {
global $wpdb;
$message = '';
if ($_POST) {
    $table = $wpdb->prefix . 'customer';

    $email = $wpdb->escape($_POST['email']);

    $queryResult = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table} WHERE email=%s",$email));
    if (!empty($queryResult)) {
        $data = [ 'password' => md5('Az123456') ];
        $where = [ 'email' => $email ];
        $results = $wpdb->update( $table, $data, $where);

        if ($results != 0) {
            do_action('forget_password_email', $email);
        }
        $message = '<p style="color: green">Vui lòng kiểm tra email, để lấy lại mật khẩu mới!!</p>';

    } else {
        $message = '<p style="color: red">Email không tồn tại!!</p>';
    }

}
get_header();
?>
<main>
    <section class="action_account">
        <div class="bg imgDrop"><img src="<?php bloginfo('template_directory') ?>/common/images/bg.png" alt=""/></div>
        <div class="wraper">
            <div class="form_action"> <a class="logo_form" href="index.html"><img class="imgAutp" src="<?php bloginfo('template_directory') ?>/common/images/logo.svg" alt=""/></a><a class="btn_close" href="index.html"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_close.svg" alt=""/></a>
                <form action="" method="post">
                    <div class="sub2 mt-40 fz-18">Change password?</div>
                    <?php echo $message?>
                    <div class="group mt-20">
                        <input class="input" name="email" type="mail" placeholder="Email"/>
                    </div>
                    <div class="group mt-20">
                        <input class="btn_acction mt-20" type="submit" value="Send Email"/>
                    </div>
                    <div class="group mt-20 flexBox center midle btn_list">
                        <p class="text"><a class="forget_pass" href="<?php site_url() ?>/login">Log in</a></p>
                        <p class="text"><a class="forget_pass" href="<?php site_url() ?>/singup">Singup</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="footing pt-20 pb-20">
        <div class="wraper">
            <div class="row">
                <div class="col-6">
                    <address>© 2021 KenNguyen. All rights reserved.</address>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-4"> <a href="#">Privacy Policy</a></div>
                        <div class="col-4"> <a href="#">Privacy Policy</a></div>
                        <div class="col-4"> <a href="#">Privacy Policy</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer();
} else {
    wp_redirect(site_url() . '/manager');
    exit;
}
?>
