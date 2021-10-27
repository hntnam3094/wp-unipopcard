<?php
/**
 * Template Name: Login page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */


global $user_ID;
global $wpdb;
if (!$user_ID) {
    if ($_POST) {
        $email = $wpdb->escape($_POST['email']);
        $password = $wpdb->escape($_POST['password']);
        $remember = $wpdb->escape($_POST['password']);

        $login_array = array();
        $login_array['user_login'] = $email;
        $login_array['user_password'] = $password;
        $login_array['remember'] = $wpdb->escape($_POST['remember']);

        $verifu_user = wp_signon($login_array, true);

        if (!is_wp_error($verifu_user)) {
            wp_redirect( site_url() . '/manager' );
            exit;
        } else {
            wp_redirect( site_url() . '/login' );
            exit;
        }
    } else {
        get_header();
        ?>
        <main>
            <section class="action_account">
                <div class="bg imgDrop"><img src="<?php bloginfo('template_directory') ?>/common/images/bg.png" alt=""/></div>
                <div class="wraper">
                    <div class="form_action"> <a class="btn_close" href="<?php site_url() ?>/index"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_close.svg" alt=""/></a>
                        <form method="post" action="">
                            <div class="sub1">Don’t have an account? <a href="<?php site_url() ?>/singup">Sign up</a></div>
                            <div class="sub2 mt-20 fz-18">Welcome back</div>
                            <a class="btn_acction btn_fb mt-20" href="">
                                <span class="icon">
                                    <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_fb.svg" alt=""/>
                                </span>
                                        <span class="text">Login with Facebook</span>
                                    </a>
                                    <a class="btn_acction btn_gg mt-20" href="http://dev.ken.com/wp-login.php?loginSocial=google">
                                <span class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_fb.svg" alt=""/>
                                </span>
                                <span class="text">Login with Facebook</span>
                            </a>
                            <div class="sub2 mt-70">Login with email</div>
                            <div class="group mt-20">
                                <input id="email" name="email" class="input" type="mail" placeholder="Email"/>
                            </div>
                            <div class="group mt-20">
                                <input id="password" name="password" class="input input_password" type="password" placeholder="Password"/><i class="toggle-password"></i>
                            </div>
                            <div class="group mt-20 flexBox star midle">
                                <input id="remember" type="checkbox" name="remember"/>
                                <label for="checbox">Remember me</label>
                            </div>
                            <div class="group mt-20">
                                <input class="btn_acction mt-20" type="submit" value="Login"/>
                            </div>
                            <div class="group mt-20">
                                <p class="text"><a class="forget_pass" href="<?php site_url() ?>/forgot-pass">Forgot password?</a></p>
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
        <?php get_footer(); }
}  else {
    wp_redirect( site_url() . '/manager' );
    exit;
}
?>


