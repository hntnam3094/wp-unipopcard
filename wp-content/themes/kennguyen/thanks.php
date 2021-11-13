<?php
/**
 * Template Name: Thanks register page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

get_header();
$token = $_GET['token'];

if (isset($token)) {
    global $wpdb;
    $table = $wpdb->prefix . 'customer';

    $data = ['active' => 1, 'trackingMd5' => '']; // NULL value.
    $where = ['trackingMd5' => $token]; // NULL value in WHERE clause.
    $results = $wpdb->update($table, $data, $where); // Also works in this case.
    if ($results != 0) {
        session_unset();
    }
}
global $va_options;
?>
<main>
    <section class="action_account">
        <div class="bg imgDrop"><img src="<?php bloginfo('template_directory') ?>/common/images/bg.png" alt=""/></div>
        <div class="wraper">
            <div class="form_action"> <a class="logo_form" href="index.html"><img class="imgAutp" src="<?= $va_options['kn_logo']['url'] !== '' ? $va_options['kn_logo']['url'] : bloginfo('template_directory').'/common/images/logo.svg' ?>" alt=""/></a><a class="btn_close" href="index.html"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_close.svg" alt=""/></a>
                <form action="">
                    <div class="sub2 mt-40 fz-18">Thank you!</div>
                    <?php if (isset($token) && $results == 0) { ?>
                        <p style="color:#c41320" class="text mt-10">Your account is not active! Plase contact us to support your account</p>
                    <?php } if (isset($token) && $results != 0) { ?>
                        <p style="color:green" class="text mt-10">Your account active is success!</p>
                    <?php } if (!isset($token)) { ?>
                        <p class="text mt-10">We've sent an email to <br><?= isset($_SESSION['register_email']) ? $_SESSION['register_email'] : 'Email' ?> <br>It contains instructions on how to change your password.</p>
                    <?php } ?>

                    <div class="content_back flexBox center mt-50 space pb-50"> <a class="item" href="#">
                            <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/thanks_03.svg" alt=""/></div>
                            <div class="txt" style="color:#c41320">Sign up your account</div></a><a class="item" href="#">
                            <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/thanks_01.svg" alt=""/></div>
                            <div class="txt" style="color:<?= $results != 0 ? '#c41320' : '' ?> ">Check your email and click the link</div></a><a class="item" href="#">
                            <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/thanks_02.svg" alt=""/></div>
                            <div class="txt" style="color:<?= $results != 0 ? '#c41320' : '' ?> ">Register successfull</div></a></div>
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
<?php
get_footer();
?>
