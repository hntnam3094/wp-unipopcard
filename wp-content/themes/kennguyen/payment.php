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

if (!empty($_SESSION['user'])) {
    global $va_options;

    $user = $_SESSION['user'];
    $packge = [];

    if (isset($_GET['package'])) {
        if ($_GET['package'] == 'monthly') {
            $start_date = date("Y-m-d");
            $end_date = date("Y-m-d", strtotime("+1 month", strtotime($start_date)));
            $packge = [
              'id' => 1,
              'package' => 'Yearly package',
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
                'package' => 'Yearly package',
                'start_date' => $start_date,
                'end_date' => $end_date,
                'price' => $va_options['kn_year_package_price'],
                'sale_price' => $va_options['kn_year_package_sale_price']
            ];
        }
    }

    if (!empty($_POST) && !empty($_POST['id_package'])) {
        if (!empty($user)) {
            $today = date("Y-m-d");
            $data = array();

            //token
            $token = $_POST['token'];

//            //card info
//            $data['card_number'] = $_POST['creditCardNumber'];
//            $data['card_exp_month'] = $_POST['expiredMonth'];
//            $data['card_exp_year'] = $_POST['expiredYear'];
//            $data['card_cvv'] = $_POST['cvv'];

            //buyer info
            $data['name'] = $user->id;
            $data['full_name'] = $user->first_name . ' ' . $user->last_name;
            $data['email'] = $user->email;
            $data['package'] = $_POST['id_package'] == 1 ? 'Monthly' : 'Yearly';
            $data['sale_price'] = $_POST['sale_price'];
            $data['status'] = 1;


//            $two_co_api = new TwoCheckoutApi();
//            $res = $two_co_api->createCharge($data, $token);

//            $insertRs = $wpdb->insert($table_order, $data);
//            if (empty($user->start_date) && empty($user->end_date)) {
//                $data = array();
//                $data['id_customer'] = $user->id;
//                $data['full_name'] = $user->first_name . ' ' . $user->last_name;
//                $data['email'] = $user->email;
//                $data['package'] = $_POST['id_package'] == 1 ? 'Monthly' : 'Yearly';
//                $data['sale_price'] = $_POST['sale_price'];
//                $data['status'] = 1;
//                $insertRs = $wpdb->insert($table_order, $data);
//                if (isset($insertRs)) {
//                    $data = [ 'member_ship' => 1,
//                        'type_member' => $_POST['id_package'],
//                        'start_date' => $_POST['start_date'],
//                        'end_date' => $_POST['end_date']];
//
//                    $where = [ 'id' => $user->id ];
//                    $results = $wpdb->update( $table, $data, $where);
//
//                    if ($results != 0) {
//                        wp_redirect(site_url() . '/logout');
//                        exit;
//                    }
//                }
//            } else {
//                if ($today >= $user->start_date && $today <= $user->end_date) {
//                    $message = '<h2 style="color: green">Your account is still valid, please try again later!</h2>';
//                } else {
//                    $insertRs = $wpdb->insert($table_order, $data);
//                    if (isset($insertRs)) {
//                        $data = [ 'member_ship' => 1,
//                            'type_member' => $_POST['id_package'],
//                            'start_date' => $_POST['start_date'],
//                            'end_date' => $_POST['end_date']];
//
//                        $where = [ 'id' => $user->id ];
//                        $results = $wpdb->update( $table, $data, $where);
//
//                        if ($results != 0) {
//                            wp_redirect(site_url() . '/logout');
//                            exit;
//                        }
//                    }
//                }
//            }

        }
    }
    get_header();
    ?>
    <main>
        <section class="my_project pt-40 pb-100">
            <div class="wraper">
                <div class="row">
                    <div class="col-12 col-lg-8 project">
                        <div class="course_my pt-2 pb-10">
                            <h1 class="ttl_main fz-20 text-up text-bold">PAYMENT INFOMATION</h1>
                            <div class="list_detail pt-15 pb-40">
                                <div class="d-flex justify-content-between payment">
                                    <div class="mt-20">
                                        <div><b>Package: </b><?= $packge['package'] ?></div>
                                        <div><b>Expired: </b><?= $packge['start_date'] .'  ~  '. $packge['end_date'] ?></div>
                                    </div>
                                    <div class="mt-20 price">
                                        <div class="new fz-30"><?=  $packge['sale_price']; ?>$</div>
                                        <div class="old fz-17"><?=  $packge['price']; ?>$</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="manager_member">
                            <?= $message ?>
                            <div class="summary">
                                <form method="post" action="">
                                    <h3>Summary</h3>
                                    <div class="summary-item"><span class="text">Price</span><span class="price">$<?= $packge['price'] ?></span></div>
                                    <div class="summary-item"><span class="text">Sale Price</span><span class="price">$<?= $packge['sale_price'] ?></span></div>
                                    <div class="summary-item"><span class="text">Total</span><span class="price">$<?= $packge['sale_price'] ?></span></div>
                                    <div class="mt-10">
                                        <input name="id_package" type="hidden" value="<?= $packge['id'] ?>">
                                        <input name="price" type="hidden" value="<?= $packge['price'] ?>">
                                        <input name="sale_price" type="hidden" value="<?= $packge['sale_price'] ?>">
                                        <input name="start_date" type="hidden" value="<?= $packge['start_date'] ?>">
                                        <input name="end_date" type="hidden" value="<?= $packge['end_date'] ?>">
                                        <a href="#" class="btn btn-success btn-lg btn-block w-100"  pro-code="3TRROJJM4U" id="buy-button">Buy now!</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php get_footer();
} else {
    wp_redirect(home_url());
    exit;
}
?>
