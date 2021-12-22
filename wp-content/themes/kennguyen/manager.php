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

$table = $wpdb->prefix . 'customer_download';
$limit = 9;
$isButtonLoad = true;
$message = '';

if (!empty($_POST)) {
    $isButtonLoad = false;
    if ($_POST['isLoad']) {
        $limit += $_POST['limit'];
    }
}

$queryResult = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM {$table} WHERE id_customer=%d LIMIT %d",$user->id,$limit));
$arrayPost = [];
if (!empty($queryResult)) {
   foreach ($queryResult as $item) {
       if (get_post($item->id_post) != null) {
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
                        <?php
                        if (isset($_SESSION['user'])) {
                            $user = $_SESSION['user'];
                            $today = date("Y-m-d");
                            $expired_date = [];
                            $level_membership = 'Not active';
                            if (!empty($user->start_date) && !empty($user->end_date)) {
                                if ($today >= $user->start_date && $today <= $user->end_date) {
                                    $now = time();
                                    $number_end = strtotime($user->end_date);
                                    $days_left = $number_end - $now;
                                    $total_days = round($days_left / (60 * 60 * 24));

                                    $date_formate = date('l,F j, Y', strtotime($user->end_date));
                                    $expired_date = [
                                        'days_left' => $total_days,
                                        'date_format' => $date_formate
                                    ];
                                } else {
                                    $expired_date = [
                                    ];
                                }
                            }

                            if ($user->type_member != 0) {
                                if ($user->type_member == 1) {
                                    $level_membership = 'Monthly member';
                                }

                                if ($user->type_member == 2) {
                                    $level_membership = 'Yearly member';
                                }
                            }
                        }
                        ?>
                        <div class="info_course">
                            <ul>
                                <li class="mt-40"><a class="active" href="<?php site_url() ?>/my-craft-room">
                                        <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01_on.svg" alt=""/></div>
                                        <div class="txt">My Downloaded Projects</div></a></li>
                                <?php if (empty($expired_date)) {
                                    ?>
                                    <li class="mt-40"><a href="<?php site_url() ?>/upgrade-today">
                                            <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_02.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_02_on.svg" alt=""/></div>
                                            <div class="txt">Upgrade Today</div></a></li>
                                    <?php
                                }
//                                else {
//                                    ?>
<!--                                    <li class="mt-40"><a href="--><?php //site_url() ?><!--/history">-->
<!--                                            <div class="icon"> <img src="--><?php //bloginfo('template_directory') ?><!--/common/images/icon/acc_03.svg" alt=""/><img class="on" src="--><?php //bloginfo('template_directory') ?><!--/common/images/icon/acc_02_on.svg" alt=""/></div>-->
<!--                                            <div class="txt">History order</div></a></li>-->
<!--                                    --><?php
//                                }?>

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
                            <?php if (isset($arrayPost) && count($arrayPost) > 0) {
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
                            <?php    } } else { ?>
                                <div class="column col-6 col-md-4 pt-5">
                                    <p>You don't download anything yet!</p>
                                </div>
                                <?php }
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
