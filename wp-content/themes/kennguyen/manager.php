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
                                <div class="fz-24">Anna</div>
                            </div>
                        </div>
                        <div class="info_course">
                            <ul>
                                <li class="mt-40"><a class="active" href="<?php site_url() ?>/manager">
                                        <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01_on.svg" alt=""/></div>
                                        <div class="txt">My Downloaded Projects</div></a></li>
                                <li class="mt-40"><a href="upgrade.html">
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
                            <div class="column col-6 col-md-4"><a class="item mt-30" href="detail.html">
                                    <div class="images">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product.png" alt=""/></div>
                                    </div>
                                    <div class="content" data-mh="content">
                                        <h4 class="text-up trim trim_2">CHRISTMAS BOUQUET</h4>
                                        <div class="desc">Category Christmas</div>
                                    </div></a></div>
                            <div class="column col-6 col-md-4"><a class="item mt-30" href="detail.html">
                                    <div class="images">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product.png" alt=""/></div>
                                    </div>
                                    <div class="content" data-mh="content">
                                        <h4 class="text-up trim trim_2">CHRISTMAS BOUQUET</h4>
                                        <div class="desc">Category Christmas</div>
                                    </div></a></div>
                            <div class="column col-6 col-md-4"><a class="item mt-30" href="detail.html">
                                    <div class="images">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product.png" alt=""/></div>
                                    </div>
                                    <div class="content" data-mh="content">
                                        <h4 class="text-up trim trim_2">CHRISTMAS BOUQUET</h4>
                                        <div class="desc">Category Christmas</div>
                                    </div></a></div>
                            <div class="column col-6 col-md-4"><a class="item mt-30" href="detail.html">
                                    <div class="images">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product.png" alt=""/></div>
                                    </div>
                                    <div class="content" data-mh="content">
                                        <h4 class="text-up trim trim_2">CHRISTMAS BOUQUET</h4>
                                        <div class="desc">Category Christmas</div>
                                    </div></a></div>
                            <div class="column col-6 col-md-4"><a class="item mt-30" href="detail.html">
                                    <div class="images">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product.png" alt=""/></div>
                                    </div>
                                    <div class="content" data-mh="content">
                                        <h4 class="text-up trim trim_2">CHRISTMAS BOUQUET</h4>
                                        <div class="desc">Category Christmas</div>
                                    </div></a></div>
                            <div class="column col-6 col-md-4"><a class="item mt-30" href="detail.html">
                                    <div class="images">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product.png" alt=""/></div>
                                    </div>
                                    <div class="content" data-mh="content">
                                        <h4 class="text-up trim trim_2">CHRISTMAS BOUQUET</h4>
                                        <div class="desc">Category Christmas</div>
                                    </div></a></div>
                            <div class="column col-6 col-md-4"><a class="item mt-30" href="detail.html">
                                    <div class="images">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product.png" alt=""/></div>
                                    </div>
                                    <div class="content" data-mh="content">
                                        <h4 class="text-up trim trim_2">CHRISTMAS BOUQUET</h4>
                                        <div class="desc">Category Christmas</div>
                                    </div></a></div>
                            <div class="column col-6 col-md-4"><a class="item mt-30" href="detail.html">
                                    <div class="images">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product.png" alt=""/></div>
                                    </div>
                                    <div class="content" data-mh="content">
                                        <h4 class="text-up trim trim_2">CHRISTMAS BOUQUET</h4>
                                        <div class="desc">Category Christmas</div>
                                    </div></a></div>
                            <div class="column col-6 col-md-4"><a class="item mt-30" href="detail.html">
                                    <div class="images">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product.png" alt=""/></div>
                                    </div>
                                    <div class="content" data-mh="content">
                                        <h4 class="text-up trim trim_2">CHRISTMAS BOUQUET</h4>
                                        <div class="desc">Category Christmas</div>
                                    </div></a></div>
                        </div>
                        <div class="mt-40 text-center"> <a class="btn_more fz-20" href="#">LOAD MORE </a></div>
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
