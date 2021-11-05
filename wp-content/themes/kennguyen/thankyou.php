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
include_once dirname( __FILE__ ).'./auth.php';
if (!empty($_GET) && isset($_GET['refno'])) {
    //get order detail
    $orderReference = $_GET['refno'];
//
//    $jsonRpcRequest = array (
//        'method' => 'getOrder',
//        'params' => array($sessionID, $orderReference),
//        'id' => $i++,
//        'jsonrpc' => '2.0'
//    );
//
//    $dataOrder = callRPC((Object)$jsonRpcRequest, $host, true);
    $emailOrder = '123321@gmail.com';
//    $productName = $dataOrder->Items[0]->ProductDetails->Name;

    $idPackage = $_GET['id_package'];
//end get order detail
    $user = $_SESSION['user'];

    $today = date("Y-m-d");
    $packge = [];

    if ($idPackage == 1) {
        $start_date = date("Y-m-d");
        $end_date = date("Y-m-d", strtotime("+1 month", strtotime($start_date)));
        $packge = [
            'id' => 1,
            'package' => $va_options['kn_monthly_package_title'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'price' => $va_options['kn_monthly_package_price'],
            'sale_price' => $va_options['kn_monthly_package_sale_price']
        ];
    } else {
        $start_date = date("Y-m-d");
        $end_date = date("Y-m-d", strtotime("+1 year", strtotime($start_date)));
        $packge = [
            'id' => 2,
            'package' => $va_options['kn_yearly_package_title'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'price' => $va_options['kn_year_package_price'],
            'sale_price' => $va_options['kn_year_package_sale_price']
        ];
    }

//    $queryResult = $wpdb->get_results(
//        $wpdb->prepare(
//            "SELECT * FROM {$table_order}
//                            WHERE refno=%s ", $orderReference));
//
//    if (empty($queryResult) && $dataOrder != null) {
//
//    }

    if (isset($_SESSION['user'])) {
        // create new order detail
        $dataOrder = array();
        $dataOrder['id_customer'] = $user->id;
        $dataOrder['email'] = $user->email;
        $dataOrder['full_name'] = $user->first_name . ' ' . $user->last_name;
        $dataOrder['package'] = $idPackage == 1 ? 'Monthly' : 'Yearly';
        $dataOrder['price'] = $packge['price'];
        $dataOrder['sale_price'] = $packge['sale_price'];
        $dataOrder['status'] = 1;
        $dataOrder['bought_date'] = $today;
        $dataOrder['refno'] = $orderReference;
        $insertRs = $wpdb->insert($table_order, $dataOrder);

        if (isset($insertRs)) {
            $dataUser = array();
            $dataUser = [ 'member_ship' => 1,
                'type_member' => $idPackage,
                'start_date' => $packge['start_date'],
                'end_date' => $packge['end_date']
            ];
            $where = ['id' => $user->id];
            $results = $wpdb->update($table, $dataUser, $where);
            if ($results != 0) {
                $message = [
                    'text1' => 'Your account active package success!',
                    'text2' => 'Please login agian to active your Premium package',
                    'action' => 'logout'
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

            //create new customer with random password + package
            $data = array();
            $data['first_name'] = '';
            $data['last_name'] = '';
            $data['email'] = $emailOrder;
            $data['password'] = md5($random_pass);
            $data['member_ship'] = 1;
            $data['type_member'] = $idPackage;
            $data['start_date'] = $packge['start_date'];
            $data['end_date'] = $packge['end_date'];
            $data['active'] = 1;
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
                    $dataOrder['email'] = $newUser->email;
                    $dataOrder['full_name'] = $newUser->first_name . ' ' . $newUser->last_name;
                    $dataOrder['package'] = $idPackage == 1 ? 'Monthly' : 'Yearly';
                    $dataOrder['price'] = $packge['price'];
                    $dataOrder['sale_price'] = $packge['sale_price'];
                    $dataOrder['status'] = 1;
                    $dataOrder['bought_date'] = $today;
                    $dataOrder['refno'] = $orderReference;
                    $wpdb->insert($table_order, $dataOrder);
                    $message = [
                        'text1' => 'Your account active package success!',
                        'text2' => 'Please check your email to get password for your account and login by your email <br><b>Email: '.$newUser->email.' </b> ',
                        'action' => 'login'
                    ];
                    do_action('forget_password_email', $emailOrder, $random_pass);
                }
            }
        } else {
            //get info of customer
            $queryResultExist = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM {$table} 
                            WHERE email=%s ", $emailOrder));

            if (!empty($queryResultExist)) {
                $existUser = $queryResultExist[0];
                // create new order detail
                $dataOrder = array();
                $dataOrder['id_customer'] = $existUser->id;
                $dataOrder['email'] = $existUser->email;
                $dataOrder['full_name'] = $existUser->first_name . ' ' . $existUser->last_name;
                $dataOrder['package'] = $idPackage == 1 ? 'Monthly' : 'Yearly';
                $dataOrder['price'] = $packge['price'];
                $dataOrder['sale_price'] = $packge['sale_price'];
                $dataOrder['status'] = 1;
                $dataOrder['bought_date'] = $today;
                $dataOrder['refno'] = $orderReference;

                $insertRs = $wpdb->insert($table_order, $dataOrder);
                if (isset($insertRs)) {
                    $dataUser = array();
                    $dataUser = [ 'member_ship' => 1,
                        'type_member' => $idPackage,
                        'start_date' => $packge['start_date'],
                        'end_date' => $packge['end_date']
                    ];
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


get_header()
?>
<div class="jumbotron text-center pt-50 pb50">
    <h1 class="display-3">Thank You!</h1>
    <p class="lead text-success"><strong><?= $message['text1'] ?></strong></p>
    <p class="lead"><?php if (!empty($message)) { ?>
            <strong>Premium : <?= $packge['start_date'] ?>  ~  <?= $packge['end_date'] ?></strong></p>
            <?php } ?>
    <p class="lead"><?= $message['text2'] ?></p>
    <hr>
    <p>
        Having trouble? <a href="">Contact us</a>
    </p>
    <p class="lead">
        <?php
            if ($message['action'] == 'logout') { ?>
                <a class="btn btn-danger" href="logout.html" data-bs-toggle="modal" data-bs-target="#modal_logout">
                    Logout
                </a>
        <?php    } else { ?>
                <a class="btn btn-success" href="<?php site_url() ?>/login">
                    login
                </a>
        <?php    }
        ?>

    </p>
</div>
<?php
get_footer()
?>
