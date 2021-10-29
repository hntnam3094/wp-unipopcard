<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()): the_post(); ?>
<main>
    <section class="course_detail pt-40 pb-40">
        <div class="wraper">
            <div class="row">
                <div class="col-12 col-lg-1">
                    <div class="shared_comment mt-100">
                        <div class="item">
                            <div class="ttl">SHARE</div><a class="icon" href=""> <img src="<?php bloginfo('template_directory') ?>/common/images/shared_01.svg" alt=""/></a><a class="icon" href=""> <img src="<?php bloginfo('template_directory') ?>/common/images/shared_02.svg" alt=""/></a>
                        </div>
                        <div class="item mt-15">
                            <div class="ttl">COMMENT</div><a class="icon" href="#comment"> <img src="<?php bloginfo('template_directory') ?>/common/images/shared_03.svg" alt=""/></a><a class="icon" href=""> <img src="<?php bloginfo('template_directory') ?>/common/images/shared_04.svg" alt=""/></a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 content_main">
                    <div class="heading">
                        <h1 class="ttl_main fz-20 text-up text-center">SEPTEMBER 2021 MEMBER MAKE: CREPE PAPER MOKARA ORCHID</h1>
                        <div class="mt-30 text-center"> <a class="btn_more" href="#"><span class="block main fz-22">You Can Make This!</span><span class="block sub">BECOME A MEMBER  </span></a></div>
                    </div>
                    <div class="boding mt-30">
                        <?php the_content();?>
                    </div>
                    <div class="resource mt-30">
                        <ul class="list_download fz-20">
                            <li class="mt-20"> <a href="#"> <span class="txt trim trim_1">Photo Tutorial</span>
                                    <soan class="button">Click Download & Print</soan></a></li>
                            <li class="mt-20"> <a href="#"> <span class="txt trim trim_1">PDF Instructions</span>
                                    <soan class="button">Click Download & Print</soan></a></li>
                            <li class="mt-20"> <a href="#"> <span class="txt trim trim_1">PDF Tempalate</span>
                                    <soan class="button">Click Download & Print</soan></a></li>
                            <li class="mt-20"> <a href="#"> <span class="txt trim trim_1">SVG Cut Files</span>
                                    <soan class="button">Click Download & Print</soan></a></li>
                        </ul>
                    </div>
                    <div class="mt-50 text-center"> <a class="btn_more" href="#"><span class="block main fz-22">You Can Make This!</span><span class="block sub">BECOME A MEMBER  </span></a></div>
                    <div class="comment mt-80 pb-30" id="comment">
                        <div class="fb-comments" data-href="https://developers.facebook.com/docs/plugins/comments#configurator" data-width="" data-numposts="5"></div>
                    </div>
                </div>
                <div class="col-12 col-lg-3 sidebar">
                    <div class="footer">
                        <ul class="social flexBox midle">
                            <li> <a href="#"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_01.svg" alt=""/></a></li>
                            <li> <a href="#"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_02.svg" alt=""/></a></li>
                            <li> <a href="#"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_03.svg" alt=""/></a></li>
                            <li> <a href="#"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_04.svg" alt=""/></a></li>
                            <li> <a href="#"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_05.svg" alt=""/></a></li>
                        </ul>
                        <div class="text mt-20">
                            <p>Join our email list to learn about new projects, discounts, and membership perks!</p>
                        </div>
                        <div class="form_submit pt-20">
                            <form action="">
                                <input class="input" type="text" placeholder="Your Email Adress"/>
                                <input class="submit" type="submit" value="JOIN NOW"/>
                            </form>
                        </div>
                    </div>
                    <div class="more_corse mt-50 category">
                        <h3 class="ttl text-up fz-22">MORE TO LOVE</h3>
                        <div class="course_main">
                            <div class="row">
                                <div class="col-4 col-lg-12"><a class="item mt-20" href="#">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product_more.png" alt=""/></div></a></div>
                                <div class="col-4 col-lg-12"><a class="item mt-20" href="#">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product_more.png" alt=""/></div></a></div>
                                <div class="col-4 col-lg-12"><a class="item mt-20" href="#">
                                        <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/product_more.png" alt=""/></div></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php endwhile;?>
<?php endif;?>
<?php get_footer(); ?>
