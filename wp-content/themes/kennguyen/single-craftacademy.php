<?php get_header(); ?>
<?php global $va_options?>
<main>
    <section class="course_detail pt-40 pb-40">
        <div class="wraper">
            <div class="row">
                <div class="col-12 col-lg-1">
                    <div class="shared_comment mt-100">
                        <div class="item">
                            <div class="ttl">SHARE</div>
                            <a class="icon" href="#" id="btn-share-facebook">
                                <img src="<?php bloginfo('template_directory') ?>/common/images/shared_01.svg" alt=""/>
                            </a>
                            <a class="icon" href="#" id="btn-share-pinterest">
                                <img src="<?php bloginfo('template_directory') ?>/common/images/shared_02.svg" alt=""/>
                            </a>
                        </div>
                        <div class="item mt-15">
                            <div class="ttl">COMMENT</div><a class="icon" href="#comment">
                                <img src="<?php bloginfo('template_directory') ?>/common/images/shared_03.svg" alt=""/>
                            </a>
                            <a class="icon" href="">
                                <img src="<?php bloginfo('template_directory') ?>/common/images/shared_04.svg" alt=""/>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 content_main">
                    <div class="heading">
                        <h1 class="ttl_main fz-20 text-up text-center"><?= get_the_title()?></h1>
                        <div class="mt-30 text-center"> <a class="btn_more" href="/upgrade-today"><span class="block main fz-22">You Can Make This!</span><span class="block sub">BECOME A MEMBER  </span></a></div>
                    </div>
                    <div class="boding mt-30">
                        <?= get_the_content()?>
                    </div>
                    <div class="resource mt-30">
                        <ul class="list_download fz-20">
                            <?php
                            $rows = get_field('list_file');
                            if( $rows ) {
                                foreach( $rows as $row ) {
                                    echo '
                                <li class="mt-20">
                                    <a href="'.$row['file']['url'].'" download>
                                        <span class="txt trim trim_1">'.$row['file_name'].'</span>
                                        <soan class="button">Click Download & Print</soan>
                                    </a>
                                </li>
                                ';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="mt-50 text-center"> <a class="btn_more" href="/upgrade-today"><span class="block main fz-22">You Can Make This!</span><span class="block sub">BECOME A MEMBER  </span></a></div>
                    <div class="comment mt-80 pb-30" id="comment" class="fb-comments">
                        <div class="fb-comments" data-href="https://developers.facebook.com/docs/plugins/comments#configurator" data-width="" data-numposts="5"></div>
                    </div>
                </div>
                <div class="col-12 col-lg-3 sidebar">
                    <div class="footer">
                        <ul class="social flexBox midle">
                            <li> <a href="<?= $va_options['sn_facebook']; ?>"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_01.svg" alt=""/></a></li>
                            <li> <a href="<?= $va_options['sn_instagram']; ?>"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_02.svg" alt=""/></a></li>
                            <li> <a href="<?= $va_options['sn_pinterest']; ?>"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_03.svg" alt=""/></a></li>
                            <li> <a href="<?= $va_options['sn_youtube']; ?>"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_04.svg" alt=""/></a></li>
                            <li> <a href="<?= $va_options['sn_email']; ?>"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_05.svg" alt=""/></a></li>
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
                    <?php
                    $args = array(
                        'post_status' => 'free',
                        'post_type'      => 'craftcollection',
                        'cat' => wp_get_post_categories(get_the_ID())
                    );
                    $currentId = get_the_ID();
                    $the_query = new WP_Query( $args );
                    ?>
                    <?php if( $the_query->have_posts() ): ?>
                    <div class="more_corse mt-50 category">
                        <h3 class="ttl text-up fz-22">MORE TO LOVE</h3>
                        <div class="course_main">
                            <div class="row">
                                <?php while( $the_query->have_posts() ) : $the_query->the_post();
                                    if (get_the_ID() != $currentId) {
                                        echo '<div class="col-4 col-lg-12">
                                                    <a class="item mt-20" href="'.get_the_permalink().'">
                                                        <div class="imgDrop">
                                                            '.get_the_post_thumbnail( get_the_id() ).'
                                                        </div>
                                                    </a>
                                                </div>';
                                    }
                                    ?>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
