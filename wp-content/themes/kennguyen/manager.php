<?php
/**
 * Template Name: Manager page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

if (!empty($_SESSION['user'])) {
$user = $_SESSION['user'];
global $wpdb;
global $va_options;
$table = $wpdb->prefix . 'customer_download';
$table = $wpdb->prefix . 'customer';
$table_order = $wpdb->prefix . 'order';
$limit = 9;
$isButtonLoad = true;
$message = '';

if (!empty($_POST)) {
    $isButtonLoad = false;
    if ($_POST['isLoad']) {
        $limit += $_POST['limit'];
    }
}

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

    $insertRs = $wpdb->insert($table_order, $data);
    if (empty($user->start_date) && empty($user->end_date)) {
        $insertRs = $wpdb->insert($table_order, $data);
        if (isset($insertRs)) {
            $where = [ 'id' => $user->id ];
            $results = $wpdb->update( $table, $dataUser, $where);

            if ($results != 0) {
                wp_redirect(site_url() . '/logout');
                exit;
            }
        }
    } else {
        if (isset($insertRs)) {
            $where = ['id' => $user->id];
            $results = $wpdb->update($table, $dataUser, $where);

            if ($results != 0) {
                wp_redirect(site_url() . '/logout');
                exit;
            }
        }
    }
}
$queryResult = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM {$table} WHERE id_customer=%d LIMIT %d",$user->id,$limit));
$arrayPost = [];
if (!empty($queryResult)) {
   foreach ($queryResult as $item) {
       $categories = get_the_category($item->id_post);
       $listCategory = [];
       foreach ($categories as $category) {
           array_push($listCategory, $category->name);
       }
       $categoryItem =  implode(', ', $listCategory);

       $post = [
         'thumbnail' => get_the_post_thumbnail($item->id_post),
         'title' => get_the_title($item->id_post),
         'category' => $categoryItem,
         'url' => get_the_permalink($item->id_post)
       ];

       array_push($arrayPost, $post);
   }
}
get_header();
?>
<main>
    <section class="my_project pt-40 pb-100">
        <div class="wraper">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="manager_member">
                        <div class="info flexBox midle">
                            <div class="avatar">
                                <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/avatar.png" alt=""/></div>
                            </div>
                            <div class="name">
                                <div class="fz-18">Account of</div>
                                <div class="fz-24"><?= $user->first_name .' '. $user->last_name ?></div>
                            </div>
                        </div>
                        <div class="info_course">
                            <ul>
                                <li class="mt-40"><a class="active" href="<?php site_url() ?>/manager">
                                        <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01_on.svg" alt=""/></div>
                                        <div class="txt">My Downloaded Projects</div></a></li>
                                <li class="mt-40"><a href="<?php site_url() ?>/upgrade-today">
                                        <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_02.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_02_on.svg" alt=""/></div>
                                        <div class="txt">Upgrade Today</div></a></li>
                                <li class="mt-40"><a href="<?php site_url() ?>/account">
                                        <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_03.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_03_on.svg" alt=""/></div>
                                        <div class="txt">Account Settings</div></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 project">
                    <div class="course_my pt-40 pb-50">
                        <h1 class="ttl_main fz-20 text-center text-up">My Downloaded Projects</h1>
                        <div class="row">
                            <?php if (isset($arrayPost)) {
                                foreach ($arrayPost as $post) { ?>
                                    <div class="column col-6 col-md-4">
                                        <a class="item mt-30" href="<?= $post['url'] ?>">
                                            <div class="images">
                                                <div class="imgDrop">
                                                    <?= $post['thumbnail'] ?>
                                                </div>
                                            </div>
                                            <div class="content" data-mh="content">
                                                <h4 class="text-up trim trim_2"> <?= $post['title'] ?></h4>
                                                <div class="desc"> <?= $post['category'] ?></div>
                                            </div>
                                        </a>
                                    </div>
                            <?php    }
                            } ?>
                            <?php
                                if ($limit == count($arrayPost)) { ?>
                                    <div class="mt-40 text-center">
                                        <form method="post" action="">
                                            <input name="isLoad" type="hidden" value="true">
                                            <input name="limit" type="hidden" value="<?= $limit ?>">
                                            <button type="submit" class="btn_more fz-20 load-more-manager" >LOAD MORE </button>
                                        </form>
                                    </div>
                            <?php    }
                            ?>
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
