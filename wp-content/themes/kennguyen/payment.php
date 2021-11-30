<?php
/**
 * Template Name: Payment page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */
if(!session_id()) {
    session_start();
}
include_once 'TwoCheckoutApi.php';
include_once 'libary/lib/Twocheckout.php';
global $wpdb;
$table = $wpdb->prefix . 'customer';
$table_order = $wpdb->prefix . 'order';
$message = '';

global $va_options;



$packge = [];
$getProduct = '';
if (isset($_GET['package_code'])) {
//    $args = [
//        'post_type'      => 'package',
//        'posts_per_page' => 1,
//        'post_name__in'  => $_GET['package']
//    ];
//    $_SESSION['packageId'] = get_the_ID();
//    $q = get_posts( $args );
//    $month = "+".get_field('expired', get_the_ID())." month";
//    $start_date = date("Y-m-d");
//    $end_date = date("Y-m-d", strtotime($month, strtotime($start_date)));
//    $packge = [
//        'id' => 1,
//        'package' =>  get_the_title(),
//        'start_date' => $start_date,
//        'end_date' => $end_date,
//        'price' => get_field('price', get_the_ID()),
//        'sale_price' => get_field('sale_price', get_the_ID())
//    ];
    include_once dirname( __FILE__ ).'/auth.php';
    $jsonRpcRequest = array (
        'jsonrpc' => '2.0',
        'id' => $i++,
        'method' => 'getProductByCode',
        'params' => array($sessionID, $_GET['package_code'])
    );
    $getProduct = callRPC((Object)$jsonRpcRequest, $host, true);

//    $month = "+".$getProduct->SubscriptionInformation->BillingCycle." month";
//    $start_date = date("Y-m-d");
//    $end_date = date("Y-m-d", strtotime($month, strtotime($start_date)));
    $packge = [
        'id' => 1,
        'package' =>  $getProduct->ProductName,
//        'start_date' => $start_date,
//        'end_date' => $end_date,
        'price' => $getProduct->PricingConfigurations[0]->Prices->Renewal[0]->Amount,
        'sale_price' => $getProduct->PricingConfigurations[0]->Prices->Regular[0]->Amount
    ];
}

if (!empty($_POST) && isset($_POST['isCheckExist'])) {
    $email = $_POST['email'];

    $queryResult = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table_order} WHERE email=%s AND status=%d ",$email, 1));

   if (empty($queryResult)) {
       $return = array(
        'message' => 'New member!',
        'code' => 200
        );
        wp_send_json($return);
   } else {
       $return = array(
           'message' => 'Old member!',
           'code' => 201
       );
       wp_send_json($return);
   }
}


$user = [];
$messageSale = '';
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    $queryResult = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table_order} WHERE email=%s AND status=%d ",$user->email, 1));

    if (!empty($queryResult)) {
        $packge['sale_price'] = $packge['price'];
    } else {
        $messageSale = $getProduct->ShortDescription;
    }
} else {
    $messageSale = $getProduct->ShortDescription;
}

if (!empty($_POST) && isset($_POST['isCreateOrder'])) {
    if (!isset($_SESSION['user'])) {
        $order = [
            'id_customer' => 0,
            'email' => $_POST['email'] ?? '',
            'full_name' => $_POST['full_name'] ?? '',
            'package' => $getProduct->ProductName ?? '',
            'price' => $_POST['price'] ?? '',
            'sale_price' => $_POST['sale_price'] ?? '',
            'status' => 0,
            'bought_date' => date("Y-m-d H:i:s"),
            'refno' => '',
        ];

        $insertRs = $wpdb->insert($table_order, $order);
        if (isset($insertRs)) {
            $return = array(
                'message' => 'Successful!',
                'idOrder' => $wpdb->insert_id,
                'code' => 200
            );
            wp_send_json($return);
        } else {
            $return = array(
                'message' => 'Failed!',
                'code' => 201
            );
            wp_send_json($return);
        }
    } else {
        $email = $_POST['email'];
        $queryResult = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table} WHERE email=%s",$email));

        if (empty($queryResult)) {
            $data['email'] = $email;
            $insertRs = $wpdb->update($table, $data, ['id' => $user->id]);
        }

        $order = [
            'id_customer' => 0,
            'email' => $_POST['email'] ?? '',
            'full_name' => $_POST['full_name'] ?? '',
            'package' => $getProduct->ProductName ?? '',
            'price' => $_POST['price'] ?? 0,
            'sale_price' => $_POST['sale_price'] ?? 0,
            'status' => 0,
            'bought_date' => date("Y-m-d H:i:s"),
            'refno' => '',
        ];

        $queryResult1 = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table_order} WHERE email=%s AND status=%d ",$user->email, 1));

        if (!empty($queryResult1)) {
            $order['sale_price'] = $packge['price'];
        }


        $insertRs = $wpdb->insert($table_order, $order);
        if (isset($insertRs)) {
            $return = array(
                'message' => 'Successful!',
                'idOrder' => $wpdb->insert_id,
                'price' => $order['sale_price'],
                'code' => 200
            );
            wp_send_json($return);
        } else {
            $return = array(
                'message' => 'Failed!',
                'code' => 201
            );
            wp_send_json($return);
        }
    }
}


function validateEmail($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
        return false;
    }
}

get_header();
$paymentID = 155;
?>
<main>
    <section class="payment pt-50 pb-50">
        <div class="wraper">
            <form action="">
                <div class="row flexBox center">
                    <div class="col-12 col-lg-8">
                        <h1 class="ttl fz-50 text-center"><?= get_field('main_title', $paymentID) ?></h1>
                        <h2 class="fz-36 text-center mt-15"><?= get_field('sub_title', $paymentID) ?></h2>
                        <div class="text mt-20 text-center"><?= nl2br(get_field('summary', $paymentID)) ?></div>
                    </div>
                </div>
                <div class="row mt-40">
                    <div class="col-12 col-lg-6">
                        <div class="content_main">
                            <div class="ttl_col">Confirm Payment</div>
                            <div class="content">
                                <h4 class="fz-24">Contact Information</h4>
                                <div class="row content_group">
                                    <div class="col-12 col-md-6">
                                        <div class="group icon icon_name">
                                            <input id="payment_first_name" class="input" type="text" placeholder="First Name*" value="<?= isset($user->first_name) ? $user->first_name : '' ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="group icon icon_name">
                                            <input id="payment_last_name" class="input" type="text" placeholder="Last Name*" value="<?= isset($user->last_name) ? $user->last_name : '' ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="group icon icon_mail">
                                            <input id="payment_email" class="input" type="mail" placeholder="Email*" value="<?= isset($user->email) ? $user->email : '' ?>" <?= isset($_SESSION['user']) ?  validateEmail($user->email) ? 'readonly' : '' : '' ?>/>
                                        </div>
                                    </div>
                                    <?php
                                    if (empty($user)) {
                                        ?>
                                        <span style="font-size: 11px;font-style: italic;
                                                line-height: 1;
                                                max-width: 400px;
                                                text-align: center;
                                                margin: 0 auto;
                                                margin-top: 10px;">If you have not registered an
                                                account at KenNguyen, this email will become your login email after payment,
                                                so please enter the correct email address.
                                            </span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="content">
                                <h4 class="fz-24">Order Summary</h4>
                                <div class="mt-15"></div>
                                <div class="item bg_box flexBox space mt-10">
                                    <div class="child_left"><?= $packge['package'] ?></div>
                                    <div class="child_right"> <span id="total_price_1" class="block"><?= $packge['sale_price'] ?>$</span><span class="block"><?= trim(str_replace('fz-20 mt-15 price_detail','',str_replace('fz-22 mt-10','',$messageSale))) ?></span></div>
                                </div>
                                <div class="item bg_box flexBox space mt-10">
                                    <div class="child_left"> <span class="fz-30">Total</span></div>
                                    <div class="child_right">
                                        <div class="flexBox midle end"> <span class="mask">USD </span><span id="total_price_2" class="fw_midle fz-30">$ <?= $packge['sale_price'] ?></span></div>
                                    </div>
                                    <span id="message" style="font-size: 9px;color: red;font-style: italic;"></span>
                                </div>
                                <div class="item bg_box mt-30 flexBox space">
                                    <input id="check-payment" type="radio"/>
                                    <label class="label text-center" for="check">By checking this box I confirm I've read and agreed to the Terms of Service, Privacy Policy & Cancellation Policy. I understand that by agreeing I also give my consent to receive further communications from KenNguyen - I Know I can opt-out from this at any given time.</label>
                                </div>
                                <div class="group mt-30">
                                    <input id="id_package" name="id_package" type="hidden" value="<?= $getProduct->ProductCode ?>">
                                    <a class="btn_submit" style="cursor: pointer"  pro-code="3TRROJJM4U" id="buy-button">PAYMENT</a>
                                </div>
                                <div class="group mt-30 text-center"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/card.svg" alt=""/></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="content_right">
                            <div class="right_box">
                                <div class="text">

                                    <p><?= isset(get_field('group_1', $paymentID)['group_text']) ? nl2br(get_field('group_1', $paymentID)['group_text']) : '' ?></p>

                                </div>
                                <div class="img">
                                    <div class="imgDrop"> <img src="<?= isset(get_field('group_1', $paymentID)['group_image']) ? get_field('group_1', $paymentID)['group_image'] : '' ?>" alt=""/></div>
                                </div>
                            </div>
                            <h2 class="ttl fz-24 mt-30"><?= isset(get_field('group_2', $paymentID)['group_title_1']) ? get_field('group_2', $paymentID)['group_title_1'] : '' ?></h2>
                            <div class="img_main mt-30">
                                <div class="imgDrop"> <img src="<?= isset(get_field('group_2', $paymentID)['group_image']) ? get_field('group_2', $paymentID)['group_image'] : '' ?>" alt=""/></div>
                            </div>
                            <div class="list_check mt-30">
                                <?php if (get_field('list_content_1', $paymentID))
                                            foreach (get_field('list_content_1', $paymentID) as $key => $item) {
                                                $idKey = 'list_check' . $key;
                                                ?>
                                                <div class="group flexBox space mt-20">
                                                    <input type="checkbox" checked="checked" id="<?= $idKey ?>"/>
                                                    <label for="<?= $idKey ?>"><?= $item['content_text'] ?></label>
                                                </div>
                                 <?php }
                                    ?>
                            </div>
                            <h2 class="ttl fz-24 mt-30"><?= get_field('group_2', $paymentID)['group_title_2'] ?></h2>
                            <div class="list_check mt-30">
                                <?php if (get_field('list_content_2', $paymentID))
                                    foreach (get_field('list_content_2', $paymentID) as $key => $item) {
                                        $keytmp = $key + count(get_field('list_content_1', $paymentID));
                                        $idKey = 'list_check' . $keytmp;
                                        ?>
                                        <div class="group flexBox space mt-20">
                                            <input type="checkbox" checked="checked" id="<?= $idKey ?>"/>
                                            <label for="<?= $idKey ?>"><?= $item['content_text'] ?></label>
                                        </div>
                                    <?php }
                                ?>
                            </div>
                            <div class="right_box2 mt-30">
                                <div class="img">
                                    <div class="imgDrop"> <img src="<?= isset(get_field('group_3', $paymentID)['group_image']) ? get_field('group_3', $paymentID)['group_image'] : '' ?>" alt=""/></div>
                                </div>
                                <div class="text">
                                    <h4 class="ttl fz-20"><?= isset(get_field('group_3', $paymentID)['group_title']) ? get_field('group_3', $paymentID)['group_title'] : '' ?></h4>
                                    <div class="txt mt-15"><?= isset(get_field('group_3', $paymentID)['group_text']) ? nl2br(get_field('group_3', $paymentID)['group_text']) : '' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
<?php get_footer();?>
