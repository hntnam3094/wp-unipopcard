<?php
/**
 * Template Name: Thank you page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

global $wpdb;
global $va_options;

$message = [];
$table = $wpdb->prefix . 'customer';
$table_order = $wpdb->prefix . 'order';
include_once dirname( __FILE__ ).'/auth.php';
if (!empty($_GET) && isset($_GET['refno'])) {
    //get order detail
    $orderReference = $_GET['refno'];

    $jsonRpcRequest = array (
        'method' => 'getOrder',
        'params' => array($sessionID, $orderReference),
        'id' => $i++,
        'jsonrpc' => '2.0'
    );

    $dataOrder = callRPC((Object)$jsonRpcRequest, $host, true);
    $emailOrder = $dataOrder->BillingDetails->Email;
    $idOrder = $_GET['merchartno'];
    $orderData = json_encode($dataOrder);

    $productName = $dataOrder->Items[0]->ProductDetails->Name;
    $idPackage = $_GET['id_package'];
//end get order detail

    $today = date("Y-m-d");
    $monthExpired = "+".get_field('expired', $idPackage)." month";
    $typeMember = 1;
    if (get_field('expired', $idPackage) >= 12) {
        $typeMember = 2;
    }
    $packge = [];

    if ($idPackage) {
        $start_date = date("Y-m-d");
        $end_date = date("Y-m-d", strtotime($monthExpired, strtotime($start_date)));
        $packge = [
            'id' => 1,
            'package' => get_the_title(),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'price' => get_field('price', $idPackage),
            'sale_price' => get_field('sale_price', $idPackage)
        ];
    }

    $queryResultRefno = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table_order}
                            WHERE refno=%s ", $orderReference));

    $queryOrder = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table_order} 
                            WHERE id=%d ", $idOrder));
    if (empty($queryResult) && $dataOrder != null && !empty($queryOrder)) {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            // create new order detail
            $dataOrder = array();
            $dataOrder['id_customer'] = $user->id;
            $dataOrder['status'] = 1;
            $dataOrder['refno'] = $orderReference;
            $dataOrder['orderData'] = $orderData;
            $insertRs = $wpdb->update($table_order, $dataOrder, ['id' => $idOrder]);

            if ($insertRs) {
                $dataUser = array();
                if ($today >= $user->start_date && $today <= $user->end_date) {
                    $endDate = date("Y-m-d",strtotime($monthExpired,strtotime($user->end_date)));
                    $dataUser = [ 'member_ship' => 1,
                        'type_member' => $typeMember,
                        'start_date' => $packge['start_date'],
                        'end_date' => $endDate
                    ];
                } else {
                    $dataUser = [ 'member_ship' => 1,
                        'type_member' => $typeMember,
                        'start_date' => $packge['start_date'],
                        'end_date' => $packge['end_date']
                    ];
                }
                $where = ['id' => $user->id];
                $results = $wpdb->update($table, $dataUser, $where);

                if ($results != 0) {
                    $queryResultExist = $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT * FROM {$table}
                            WHERE id=%s ", $user->id));

                    if (!empty($queryResultExist)) {
                        $_SESSION['user'] = $queryResultExist[0];
                    }
                    $message = [
                        'text1' => 'Your account active package success!',
                        'text2' => 'Enjoy your Premium time!',
                        'action' => 'home'
                    ];
                }
            }
        } else {
            $queryResult = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM {$table}
                            WHERE email=%s ", $emailOrder));

            if (empty($queryResult)) {
                $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                $pass = array();
                $alphaLength = strlen($alphabet) - 1;
                for ($i = 0; $i < 8; $i++) {
                    $n = rand(0, $alphaLength);
                    $pass[] = $alphabet[$n];
                }

                $random_pass = implode($pass);
                $queryResult = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT * FROM {$table_order}
                                            WHERE id=%d ", $idOrder));
                $fullname_split = explode(" ",$queryResult[0]->full_name);

                $first_name = $fullname_split[0];
                $last_name = $fullname_split[1];

                //create new customer with random password + package
                $data = array();
                $data['first_name'] = $first_name;
                $data['last_name'] = $last_name;
                $data['email'] = $emailOrder;
                $data['password'] = md5($random_pass);
                $data['member_ship'] = 1;
                $data['type_member'] = $typeMember;
                $data['start_date'] = $packge['start_date'];
                $data['end_date'] = $packge['end_date'];
                $data['active'] = 1;
                $data['created_at'] = date("Y-m-d h:i:s");
                $data['trackingMd5'] = md5($emailOrder);

                $insertRs = $wpdb->insert($table, $data);
                if (isset($insertRs)) {
                    // get info of user by email
                    $queryResultInsert = $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT * FROM {$table}
                            WHERE email=%s ", $emailOrder));

                    if (!empty($queryResultInsert)) {
                        $newUser = $queryResultInsert[0];
                        // create new order detail
                        $dataOrder = array();
                        $dataOrder['id_customer'] = $newUser->id;
                        $dataOrder['status'] = 1;
                        $dataOrder['refno'] = $orderReference;
                        $dataOrder['orderData'] = $orderData;
                        $insertRs = $wpdb->update($table_order, $dataOrder, ['id' => $idOrder]);

                        $message = [
                            'text1' => 'Your account active package success!',
                            'text2' => 'Please check your email to get password for your account and login by your email',
                            'action' => 'login'
                        ];
                        do_action('forget_password_email', $emailOrder, $random_pass, true);
                    }
                }
            } else {
                //get info of customer
                $queryResultExist = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT * FROM {$table}
                            WHERE email=%s ", $queryOrder[0]->email));

                if (!empty($queryResultExist)) {
                    $existUser = $queryResultExist[0];
                    // create new order detail
                    $dataOrder = array();
                    $dataOrder['id_customer'] = $existUser->id;
                    $dataOrder['status'] = 1;
                    $dataOrder['refno'] = $orderReference;
                    $dataOrder['orderData'] = $orderData;
                    $insertRs = $wpdb->update($table_order, $dataOrder, ['id' => $idOrder]);

                    if ($insertRs) {
                        $dataUser = array();
                        if ($today >= $existUser->start_date && $today <= $existUser->end_date) {
                            $endDate = date("Y-m-d",strtotime($monthExpired,strtotime($existUser->end_date)));
                            $dataUser = [ 'member_ship' => 1,
                                'type_member' => $typeMember,
                                'start_date' => $packge['start_date'],
                                'end_date' => $endDate
                            ];
                        } else {
                            $dataUser = [ 'member_ship' => 1,
                                'type_member' => $typeMember,
                                'start_date' => $packge['start_date'],
                                'end_date' => $packge['end_date']
                            ];
                        }
                        $where = [ 'id' => $existUser->id ];
                        $results = $wpdb->update($table, $dataUser, $where);
                        if (isset($results)) {
                            $message = [
                                'text1' => 'Your account active package success!',
                                'text2' => 'Please login to get your Premium package! <br><b>Email: '.$existUser->email.' </b> ',
                                'action' => 'login'
                            ];
                        }
                    }
                }
            }
        }
    }
}


$queryUser = [];
if (isset($_SESSION['user'])) {
    $queryUser = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table}
                            WHERE id=%d ", $user->id));
} else {
    $queryUser = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table}
                            WHERE email=%s ", $emailOrder));
}

$premium_account = [];
if (!empty($queryUser)) {
    $premium_account = $queryUser[0];
}

get_header()
?>
<div class="jumbotron text-center pt-50 pb50">
    <h1 class="display-3">Thank You!</h1>
    <p class="lead text-success"><strong><?= $message['text1'] ?></strong></p>
    <p class="lead"><?php if (!empty($message)) { ?>
            <strong>Premium : <?= !empty($premium_account->start_date) ? $premium_account->start_date : '' ?>
                ~  <?= !empty($premium_account->end_date) ? $premium_account->end_date : '' ?></strong></p>
            <?php } ?>
    <p class="lead"><?= $message['text2'] ?></p>
    <hr>
    <p>
        Having trouble? <a href="">Contact us</a>
    </p>
    <p class="lead">
        <?php
            if ($message['action'] == 'home') { ?>
                <a class="btn btn-success" href="<?= home_url() ?>">
                    HOME
                </a>
        <?php    } else { ?>
                <a class="btn btn-success" href="<?php site_url() ?>/login">
                    LOGIN
                </a>
        <?php    }
        ?>

    </p>
</div>
<?php
get_footer()
?>
