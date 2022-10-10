<?php
/**
 * Template Name: Login page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

if(!session_id()) {
    session_start();
}
global $wpdb;
global $va_options;
$table = $wpdb->prefix . 'customer';
$login_message = '';
require_once 'vendor/autoload.php';
if (empty($_SESSION['user'])) {
    $cookieName = 'remember111';
    $isCookie = false;

    if (isset($_COOKIE[$cookieName])) {
        $isCookie = !empty($_COOKIE[$cookieName]);
        $accountCookie = json_decode(stripslashes($_COOKIE[$cookieName]));
    }
if ($_POST) {

    $email = $wpdb->escape($_POST['email']);
    $password = $wpdb->escape($_POST['password']);
    $remember = $wpdb->escape($_POST['remember']);

    if (!empty($remember)) {
        $value_cookie = [
            'email' => $email,
            'password' => $password
        ];
        $cookieStr = json_encode($value_cookie);
        setcookie($cookieName, $cookieStr, time() + (86400 * 30), "/");
    } else {
        unset($_COOKIE[$cookieName]);
        setcookie($cookieName, null, -1, '/');
    }

    $queryResult = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table} 
                            WHERE email=%s 
                            AND password=%s ",
            $email, md5($password)));


    if (!empty($queryResult)) {
        if ($queryResult[0]->active == 1) {
            $_SESSION['user'] = $queryResult[0];
            wp_redirect(site_url() . '/my-craft-room');
            exit;
        } else {
            $login_message = '<p style="color: red">Your account is not active <br> Please active your account or contact us!</p>';
        }

    } else {
        $login_message = '<p style="color: red">Wrong password or account!</p>';
    }

}

    // start login with google

    try {
        $clientId = $va_options['kn_client_id'];
        $clientSecret = $va_options['kn_client_serect'];
        $redirectUri = site_url() . '/login/';

        $client = new Google_Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope('email');
        $client->addScope('profile');

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email =  $google_account_info->email;
            $id_gg = $google_account_info->id;

            $queryResult = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$table} WHERE email=%s",$email));

            if (!empty($queryResult)) {
                $_SESSION['user'] = $queryResult[0];
                if (empty($queryResult[0]->id_google)) {
                    $data['id_google'] = $id_gg;
                    $insertRs = $wpdb->update($table, $data, ['email' => $email]);
                }
                wp_redirect(site_url() . '/my-craft-room');
                exit;
            } else {
                $data = array();
                $data['first_name'] = $google_account_info->familyName;
                $data['last_name'] = $google_account_info->givenName;
                $data['email'] = $email;
                $data['password'] = md5($email);
                $data['active'] = 1;
                $data['created_at'] = date("Y-m-d h:i:s");
                $data['trackingMd5'] = md5($email);
                $data['id_google'] = $id_gg;

                $insertRs = $wpdb->insert($table, $data);
                if (isset($insertRs)) {
                    if ($email) {
                        do_action('add_subscription',$data['first_name'], $data['last_name'], $email);
                    }

                    $queryResultAfterInsert = $wpdb->get_results(
                        $wpdb->prepare("SELECT * FROM {$table} WHERE email=%s",$email));
                    if (!empty($queryResultAfterInsert)) {
                        $_SESSION['user'] = $queryResultAfterInsert[0];
                        wp_redirect(site_url() . '/my-craft-room');
                        exit;
                    }
                }
            }
        }
    }catch (Exception $exception) {
    var_dump($exception);
//        wp_redirect(site_url() . '/login');
//        exit;
    }

//    // end login with google

    $fb = new \Facebook\Facebook([
        'app_id' => $va_options['kn_app_id'],
        'app_secret' => $va_options['kn_app_serect'],
        'default_graph_version' => 'v2.10',
    ]);

    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email', 'public_profile']; // optional
    $login_url = $helper->getLoginUrl($va_options['kn_url_callback'], $permissions);

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
                    <a class="btn_acction btn_fb mt-20" scope="public_profile, email" href="<?= $login_url ?>">
                                <span class="icon">
                                    <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_fb.svg" alt=""/>
                                </span>
                        <span class="text">Login with Facebook</span>
                    </a>
                    <a class="btn_acction btn_gg mt-20"  href="<?= $client->createAuthUrl() ?>">
                                <span class="icon">
                                    <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_gg.svg" alt=""/>
                                </span>
                        <span class="text">Login with Google</span>
                    </a>
                    <div class="sub2 mt-70">Login with email</div>
                    <div class="group mt-20">
                        <input id="email" name="email" class="input" type="mail" placeholder="Email" value="<?= $isCookie ? $accountCookie->email : '' ?>"/>
                    </div>
                    <div class="group mt-20">
                        <input id="password" name="password" class="input input_password" type="password" placeholder="Password" value="<?= $isCookie ? $accountCookie->password : '' ?>"/>
                        <i class="toggle-password"></i>
                    </div>
                    <div class="group mt-20 flexBox star midle">
                        <input id="checbox" type="checkbox" <?= $isCookie ? 'checked' : '' ?> name="remember"/>
                        <label for="checbox">Remember me</label>
                    </div>
                    <?php echo $login_message?>
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
    <?php get_template_part('template-parts/order/other-footer'); ?>
</main>

<?php get_footer();
} else {
    wp_redirect(site_url() . '/my-craft-room');
    exit;
}
?>




