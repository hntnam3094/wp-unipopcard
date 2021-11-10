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
if (isset($_GET['package'])) {
    if ($_GET['package'] == 'monthly') {
        $start_date = date("Y-m-d");
        $end_date = date("Y-m-d", strtotime("+1 month", strtotime($start_date)));
        $packge = [
          'id' => 1,
          'package' =>  $va_options['kn_monthly_package_title'],
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
}

if (!empty($_POST) && !empty($_POST['isCheckExistPackage'])) {
    $user = $_SESSION['user'];
    $today = date("Y-m-d");

    if ($today >= $user->start_date && $today <= $user->end_date) {
        $return = array(
            'message' => 'Your account is still valid, please try again later!',
            'code' => 201
        );
        wp_send_json($return);
    } else {
        $return = array(
            'message' => 'Save!',
            'code' => 200
        );
        wp_send_json($return);
    }
}

$args = array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key' => '_wp_page_template',
            'value' => 'payment.php', // template name as stored in the dB
        )
    )
);
$my_query = new WP_Query($args);
$post   = get_post( 155 );
$output =  apply_filters( 'the_content', $my_query->posts[0]->post_content);
var_dump($output);
get_header();
?>
<main>
    <section class="payment pt-50 pb-50">
        <div class="wraper">
            <form action="">
                <div class="row flexBox center">
                    <div class="col-12 col-lg-8">
                        <h1 class="ttl fz-50 text-center">Lorem Ipsum is Simply Dummy</h1>
                        <h2 class="fz-36 text-center mt-15">Lorem Ipsum is Simply Dummy </h2>
                        <div class="text mt-20 text-center">Lorem Ipsum is simply dummy text of:  the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of</div>
                    </div>
                </div>
                <div class="row mt-40">
                    <div class="col-12 col-lg-6">
                        <div class="content_main">
                            <div class="ttl_col">Confirm Payment</div>
                            <div class="content">
                                <h4 class="fz-24">Order Summary</h4>
                                <div class="mt-15"></div>
                                <div class="item bg_box flexBox space mt-10">
                                    <div class="child_left"><?= $packge['package'] ?></div>
                                    <div class="child_right"> <span class="block"><?= $packge['sale_price'] ?>$</span><span class="block">Future Payments: <?= $packge['price'] ?>$ for each month, starling in 7 days</span></div>
                                </div>
                                <div class="item bg_box flexBox space mt-10">
                                    <div class="child_left"> <span class="fz-30">Total</span></div>
                                    <div class="child_right">
                                        <div class="flexBox midle end"> <span class="mask">USD </span><span class="fw_midle fz-30"><?= $packge['sale_price'] ?></span></div>
                                    </div>
                                </div>
                                <div class="item bg_box mt-30 flexBox space">
                                    <input id="check-payment" type="radio"/>
                                    <label class="label text-center" for="check">By checking this box I confirm I've read and agreed to the Terms of Service, Privacy Policy & Cancellation Policy. I understand that by agreeing I also give my consent to receive further communications from KenNguyen - I Know I can opt-out from this at any given time.</label>
                                </div>
                                <div class="group mt-30">
                                    <input id="id_package" name="id_package" type="hidden" value="<?= $packge['id'] ?>">
                                    <a class="btn_submit" style="cursor: pointer"  pro-code="3TRROJJM4U" id="buy-button">Complete Purchase</a>
                                </div>
                                <div class="group mt-30 text-center"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/card.svg" alt=""/></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="content_right">
                            <div class="right_box">
                                <div class="text">
                                    <p>Lorem Ipsum is simply dummy text of:  the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
                                    <p>Lorem Ipsum is </p>
                                </div>
                                <div class="img">
                                    <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product_more.png" alt=""/></div>
                                </div>
                            </div>
                            <h2 class="ttl fz-24 mt-30">Here's what you'll get:</h2>
                            <div class="img_main mt-30">
                                <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/banner.png" alt=""/></div>
                            </div>
                            <div class="list_check mt-30">
                                <div class="group flexBox space mt-20">
                                    <input type="checkbox" checked="checked" id="list_check1"/>
                                    <label for="list_check1">Lorem Ipsum is simply dummy text of:  the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of</label>
                                </div>
                                <div class="group flexBox space mt-20">
                                    <input type="checkbox" checked="checked" id="list_check2"/>
                                    <label for="list_check2">Lorem Ipsum is simply dummy text of:  the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of</label>
                                </div>
                                <div class="group flexBox space mt-20">
                                    <input type="checkbox" checked="checked" id="list_check3"/>
                                    <label for="list_check3">Lorem Ipsum is simply dummy text of:  the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of</label>
                                </div>
                                <div class="group flexBox space mt-20">
                                    <input type="checkbox" checked="checked" id="list_check4"/>
                                    <label for="list_check4">Lorem Ipsum is simply dummy text of:  the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of</label>
                                </div>
                                <div class="group flexBox space mt-20">
                                    <input type="checkbox" checked="checked" id="list_check5"/>
                                    <label for="list_check5">Lorem Ipsum is simply dummy text of:  the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of</label>
                                </div>
                            </div>
                            <h2 class="ttl fz-24 mt-30">You'll ALSO get</h2>
                            <div class="list_check mt-30">
                                <div class="group flexBox space mt-20">
                                    <input type="checkbox" checked="checked" id="list_check6"/>
                                    <label for="list_check6">Lorem Ipsum is simply dummy text of:  the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of</label>
                                </div>
                                <div class="group flexBox space mt-20">
                                    <input type="checkbox" checked="checked" id="list_check7"/>
                                    <label for="list_check7">Lorem Ipsum is simply dummy text of:  the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of</label>
                                </div>
                            </div>
                            <div class="right_box2 mt-30">
                                <div class="img">
                                    <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product_more.png" alt=""/></div>
                                </div>
                                <div class="text">
                                    <h4 class="ttl fz-20">30-Day Money-Back Guarantee</h4>
                                    <div class="txt mt-15">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived</div>
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
