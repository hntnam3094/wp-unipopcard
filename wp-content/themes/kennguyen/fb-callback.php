<?php
/**
 * Template Name: fb-callback page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

global $wpdb;
global $va_options;
$table = $wpdb->prefix . 'customer';
require_once 'vendor/autoload.php';
$appId = $va_options['kn_app_id'];
$fb = new \Facebook\Facebook([
    'app_id' => $va_options['kn_app_id'],
    'app_secret' => $va_options['kn_app_serect'],
    'default_graph_version' => 'v2.10',
]);

$helper = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state']=$_GET['state'];

try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (! isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}

// Logged in
echo '<h3>Access Token</h3>';

$accessToken_value = $accessToken->getValue();
// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
echo '<h3>Metadata</h3>';
var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
//$tokenMetadata->validateAppId((string)$va_options['kn_app_id']);
$tokenMetadata->validateAppId((string)$va_options['kn_app_id']);
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
        exit;
    }

    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
}

if ((string)$accessToken) {
    $response = $fb->get('/me?fields=id,first_name,last_name,name,email',(string)$accessToken);
    $me = $response->getGraphUser();
    $email = $me->getEmail();

    $queryResult = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM {$table} WHERE id_facebook=%s", $me->getId()));

    if (!empty($queryResult)) {
        $_SESSION['user'] = $queryResult[0];
        if (empty($queryResult[0]->id_facebook)) {
            $data['id_facebook'] = $me->getId();
            $insertRs = $wpdb->update($table, $data, ['email' => $email]);
        }
        wp_redirect(site_url() . '/manager');
        exit;
    } else {
        $queryResultEmail = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM {$table} WHERE email=%s", $email));
        if (!empty($queryResultEmail)) {
            $_SESSION['user'] = $queryResultEmail[0];
            if (empty($queryResultEmail[0]->id_facebook)) {
                $data['id_facebook'] = $me->getId();
                $insertRs = $wpdb->update($table, $data, ['email' => $email]);
            }
            wp_redirect(site_url() . '/manager');
            exit;
        } else {
            $data = array();
            $data['first_name'] = $me->getFirstName();
            $data['last_name'] = $me->getLastName();
            $data['email'] = '';
            $data['password'] = '';
            $data['active'] = 1;
            $data['created_at'] = date("Y-m-d h:i:s");
            $data['trackingMd5'] = md5($email);
            $data['id_facebook'] = $me->getId();

            if (!empty($email)) {
                $data['email'] = $email;
            }

            $insertRs = $wpdb->insert($table, $data);
            if (isset($insertRs)) {
                $queryResultAfterInsert = $wpdb->get_results(
                    $wpdb->prepare("SELECT * FROM {$table} WHERE id_facebook=%s",$me->getId()));
                if (!empty($queryResultAfterInsert)) {
                    $_SESSION['user'] = $queryResultAfterInsert[0];
                    wp_redirect(site_url() . '/manager');
                    exit;
                }
            }
        }
    }
}
