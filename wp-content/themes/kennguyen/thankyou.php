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
$table = $wpdb->prefix . 'customer';
$table_order = $wpdb->prefix . 'order';
var_dump($_GET);
if (isset($_GET['id_package'])) {
    $idPackage = $_GET['id_package'];
    $user = $_SESSION['user'];
    $today = date("Y-m-d");
    $packge = [];
    if ($_GET['id_package'] == 1) {
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

    $data = array();
    $dataUser = array();
    //buyer info
    $data['name'] = $user->id;
    $data['full_name'] = $user->first_name . ' ' . $user->last_name;
    $data['email'] = $user->email;
    $data['package'] = $idPackage == 1 ? 'Monthly' : 'Yearly';
    $data['sale_price'] = $packge['sale_price'];
    $data['status'] = 1;
    $data['bought_date'] = $today;

    $dataUser = [ 'member_ship' => 1,
        'type_member' => $idPackage,
        'start_date' => $packge['start_date'],
        'end_date' => $packge['end_date']
    ];

//    $insertRs = $wpdb->insert($table_order, $data);
//    if (empty($user->start_date) && empty($user->end_date)) {
//        $insertRs = $wpdb->insert($table_order, $data);
//        if (isset($insertRs)) {
//            $where = [ 'id' => $user->id ];
//            $results = $wpdb->update( $table, $dataUser, $where);
//
//            if ($results != 0) {
//                wp_redirect(site_url() . '/logout');
//                exit;
//            }
//        }
//    } else {
//        if (isset($insertRs)) {
//            $where = ['id' => $user->id];
//            $results = $wpdb->update($table, $dataUser, $where);
//
//            if ($results != 0) {
//                wp_redirect(site_url() . '/logout');
//                exit;
//            }
//        }
//    }
}

get_header()
?>
<div class="jumbotron text-center pt-50 pb50">
    <h1 class="display-3">Thank You!</h1>
    <p class="lead text-success"><strong>Your account active package success!</strong></p>
    <p class="lead"><strong>Your membership term: <?= $packge['start_date'] ?>  ~  <?= $packge['end_date'] ?></strong></p>
    <p class="lead">Please login agian to active your package membership</p>
    <hr>
    <p>
        Having trouble? <a href="">Contact us</a>
    </p>
    <p class="lead">
        <a class="btn btn-primary" href="logout.html" data-bs-toggle="modal" data-bs-target="#modal_logout">
            Logout
        </a>
    </p>
</div>
<?php
get_footer()
?>
