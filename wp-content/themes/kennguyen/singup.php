<?php
/**
 * Template Name: Singup page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

global $user_ID;
global $wpdb;
global $va_options;
$message = '';
$success = '';
if (empty($_SESSION['user'])) {
if ($_POST) {
    $table = $wpdb->prefix.'customer';

    $first_name = $wpdb->escape($_POST['first_name']);
    $last_name = $wpdb->escape($_POST['last_name']);
    $email = $wpdb->escape($_POST['email']);
    $password = $wpdb->escape($_POST['password']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $message = 'Please fill out the form!';
    } elseif (strlen($password) < 6) {
        $message = 'Password must be 6 or more characters!';
    } else {
        $results = $wpdb->query(
            $wpdb->prepare(
                "SELECT * FROM $table WHERE email = %s", $email)
        );

        if ($results != 0) {
            $message = 'E-mail is being used! Please use another email!';
        } else {
            $data = array();
            $data['first_name'] = $first_name;
            $data['last_name'] = $last_name;
            $data['email'] = $email;
            $data['password'] = md5($password);
            $data['created_at'] = date("Y-m-d h:i:s");
            $data['trackingMd5'] = md5($email);

            $insertRs = $wpdb->insert($table, $data);
            if (isset($insertRs)) {
                do_action('active_account_email', $data['email']);
                $_SESSION['register_email'] = $data['email'];

                wp_redirect(site_url() . '/thanks-register');
                exit;
//                $success = 'Sign Up Success! Please check your email to activate your account!';

            } else {
                $message = 'Registration failed!';
            }

        }
    }
}
get_header();
?>
<main>
    <section class="action_account">
        <div class="bg imgDrop"><img src="<?php bloginfo('template_directory') ?>/common/images/bg.png" alt=""/></div>
        <div class="wraper">
            <div class="form_action"> <a class="logo_form" href="<?php site_url() ?>/index"><img class="imgAutp" src="<?= isset($va_options['kn_logo']) && $va_options['kn_logo']['url'] !== '' ? $va_options['kn_logo']['url'] : bloginfo('template_directory').'/common/images/logo.svg' ?>" alt=""/></a><a class="btn_close" href="<?php site_url() ?>/index"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_close.svg" alt=""/></a>
                <form method="post" action="">
                    <div class="sub2 mt-40 fz-18">Start Your Free Trial Now</div>
                    <p style="color: red"><?= $message ?></p>
                    <p style="color: green"><?= $success ?></p>
                    <div class="group mt-20">
                        <input id="first_name" name="first_name" class="input" type="text" placeholder="Fist name"/>
                    </div>
                    <div class="group mt-20">
                        <input id="last_name" name="last_name" class="input" type="text" placeholder="Last name"/>
                    </div>
                    <div class="group mt-20">
                        <input id="emailSingup" name="email" class="input" type="mail" placeholder="Email"/>
                    </div>
                    <div class="group mt-20">
                        <input id="password" name="password" class="input input_password" type="password" placeholder="Password"/><i class="toggle-password"></i>
                    </div>
                    <div class="group mt-20">
                        <input id="btn_singup" class="btn_acction mt-20" type="submit" value="Create Account"/>
                    </div>
                    <div class="group mt-20">
                        <p class="text">Already have an account? <a class="forget_pass" href="<?php site_url() ?>/login">Log in</a></p>
                        <p>By clicking “Create account” I accept the <br>Terms of Service, the Anti-Spam Policy, <br>and the Privacy Policy. Accessibitity info.</p>
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
                        <div class="col-4"> <a href="<?=$va_options['op1_link']?>"><?=$va_options['op1_title']?></a></div>
                        <div class="col-4"> <a href="<?=$va_options['op2_link']?>"><?=$va_options['op2_title']?></a></div>
                        <div class="col-4"> <a href="<?=$va_options['op3_link']?>"><?=$va_options['op3_title']?></a></div>
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
