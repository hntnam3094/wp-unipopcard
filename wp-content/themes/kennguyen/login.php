<?php
/**
 * Template Name: Login page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

global $wpdb;
$login_message = '';
$table = $wpdb->prefix . 'customer';
if (empty($_SESSION['user'])) {
if ($_POST) {
    $email = $wpdb->escape($_POST['email']);
    $password = $wpdb->escape($_POST['password']);
    $remember = $wpdb->escape($_POST['remember']);
    $queryResult = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table} 
                            WHERE email=%s 
                            AND password=%s 
                            AND active=%d",
            $email, md5($password), 1));

    if (!empty($queryResult)) {
        $_SESSION['user'] = $queryResult[0];
        wp_redirect(site_url() . '/manager');
        exit;
    }
    $login_message = '<p style="color: red">Sai mật khẩu hoặc tài khoản!</p>';
}

//    // start login with google
//    try {
//        $clientId = '1019571594189-htjk66sgngbpo5c04c8vqjppp8ttoagb.apps.googleusercontent.com';
//        $clientSecret = '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';
//        $redirectUri = 'http://localhost:80/login/';
//
//        $client = new Google_Client();
//        $client->setClientId($clientId);
//        $client->setClientSecret($clientSecret);
//        $client->setRedirectUri($redirectUri);
//        $client->addScope('email');
//        $client->addScope('profile');
//
//        if (isset($_GET['code'])) {
//            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//            $client->setAccessToken($token['access_token']);
//
//            $google_oauth = new Google_Service_Oauth2($client);
//            $google_account_info = $google_oauth->userinfo->get();
//            $email =  $google_account_info->email;
//
//            $queryResult = $wpdb->get_results(
//                $wpdb->prepare("SELECT * FROM {$table} WHERE email=%s",$email));
//
//            if (!empty($queryResult)) {
//                $_SESSION['user'] = $queryResult[0];
//                wp_redirect(site_url() . '/manager');
//                exit;
//            } else {
//                $data = array();
//                $data['first_name'] = $google_account_info->familyName;
//                $data['last_name'] = $google_account_info->givenName;
//                $data['email'] = $email;
//                $data['password'] = md5($email);
//                $data['active'] = 1;
//                $data['trackingMd5'] = md5($email);
//
//                $insertRs = $wpdb->insert($table, $data);
//                if (isset($insertRs)) {
//                    $queryResultAfterInsert = $wpdb->get_results(
//                        $wpdb->prepare("SELECT * FROM {$table} WHERE email=%s",$email));
//                    if (!empty($queryResultAfterInsert)) {
//                        $_SESSION['user'] = $queryResultAfterInsert[0];
//                        wp_redirect(site_url() . '/manager');
//                        exit;
//                    }
//                }
//            }
//        }
//    }catch (Exception $exception) {
//        wp_redirect(site_url() . '/login');
//        exit;
//    }

//    // end login with google

    $fb = new \Facebook\Facebook([
        'app_id' => '3185286311726449',
        'app_secret' => '7416e7ff97fb45592382f9a65401d374',
        'default_graph_version' => 'v2.10',
    ]);

    $helper = $fb->getRedirectLoginHelper();
    $login_url = $helper->getLoginUrl("http://localhost/fb-callback.php");


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
                    <a class="btn_acction btn_gg mt-20" href="<?= $client->createAuthUrl() ?>">
                                <span class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_fb.svg" alt=""/>
                                </span>
                        <span class="text">Login with Google</span>
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




