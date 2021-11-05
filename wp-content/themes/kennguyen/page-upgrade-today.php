<?php
global $va_options;
get_header()
?>
<main>
    <section class="category pt-50 pb-50 upgrade">
        <div class="wraper">
            <h1 class="ttl_main fz-40 text-up text-center">Endless Referrals. Ready? </h1>
            <div class="text text-center">Join over 25,000+ others actively finding leads and making sales with UpViral.</div>
        </div>
        <div class="content_main mt-30 pt-100 pb-100">
            <div class="wraper">
                <div class="flexBox package center">
                    <div class="item_package text-center package_month">
                        <div class="info_main">
                            <h3 class="ttl fz-31"><?= $va_options['kn_monthly_name']; ?></h3>
                            <div class="price center midle flexBox mt-20">
                                <div class="new fz-45"><?=  $va_options['kn_monthly_package_sale_price']; ?>$</div>
                                <div class="old fz-22"><?=  $va_options['kn_monthly_package_price']; ?>$</div>
                            </div>
                            <div class="fz-22 mt-10">Full Acess</div>
                            <div class="fz-20 mt-15 price_detail">After 7 days,<br>$<?=  $va_options['kn_monthly_package_price']; ?>/month<br>(paid month)</div>
                            <a class="button mt-20" href="<?php site_url() ?>/payment?package=monthly">JOIN NOW</a>
                        </div>
                        <div class="info_other toggle_parent">
                            <div class="toggle_content">
                                <div class="list_detail mt-30 pt-15 pb-40">
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                </div><a class="button mt-40" href="<?php site_url() ?>/payment?package=monthly">JOIN NOW</a>
                            </div>
                            <div class="toggle_btn">
                                <div class="short">Xem thêm </div>
                                <div class="long">
                                    Thu gọn</div>
                            </div>
                        </div>
                    </div>
                    <div class="item_package text-center package_year">
                        <div class="info_main">
                            <h3 class="ttl fz-31"><?= $va_options['kn_yearly_name']; ?></h3>
                            <div class="price center midle flexBox mt-20">
                                <div class="new fz-45"><?=  $va_options['kn_year_package_sale_price']; ?>$</div>
                                <div class="old fz-22"><?=  $va_options['kn_year_package_price']; ?>$</div>
                            </div>
                            <div class="fz-22 mt-10">Full Acess</div>
                            <div class="fz-20 mt-15 price_detail">After 7 days,<br>$<?=  $va_options['kn_year_package_price']; ?>/month<br>(paid month)</div>
                            <a class="button mt-20" href="<?php site_url() ?>/payment?package=yearly">JOIN NOW </a>
                        </div>
                        <div class="info_other toggle_parent">
                            <div class="toggle_content">
                                <div class="list_detail mt-30 pt-15 pb-40">
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                    <dl class="mt-20">
                                        <dt>16 curated DIY projects (patterns + tutorials) </dt>
                                        <dd>$160 VALUE</dd>
                                    </dl>
                                </div><a class="button mt-40" href="<?php site_url() ?>/payment?package=yearly">JOIN NOW</a>
                            </div>
                            <div class="toggle_btn">
                                <div class="short">Xem thêm </div>
                                <div class="long">
                                    Thu gọn</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="question pt-40 pb-100">
        <div class="wraper">
            <div class="flexBox">
                <div class="col-12 col-lg-6">
                    <h2 class="ttl_main text-up fz-60">Have questions?<br>We’re here to<br>help you!</h2>
                    <div class="content pt-30">
                        <?php
                        $args = array(
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'post_type'      => 'questionanswer',
                        );
                        $the_query = new WP_Query( $args );
                        $countPosts = $the_query->found_posts;
                        $firstListDataCount = round($countPosts / 2) > 0 ? round($countPosts / 2) - 1 : 1;
                        $count = 0;
                        ?>
                        <?php if( $the_query->have_posts() ): ?>
                            <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                               <?php if ($firstListDataCount > $count) {?>
                                <div class="item toggle_parent mt-50">
                                    <div class="toggle_btn fz-24"><?= get_the_title()?></div>
                                    <div class="toggle_content">
                                        <div class="text"><?= get_the_content()?></div>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if ($firstListDataCount == $count) {
                                    echo '</div>
                                        </div>';
                                    echo '<div class="col-12 col-lg-6">
                                        <div class="content pt-100">';
                                } ?>
                                <?php if ($firstListDataCount <= $count) {?>
                                    <div class="item toggle_parent mt-50">
                                        <div class="toggle_btn fz-24"><?= get_the_title()?></div>
                                        <div class="toggle_content">
                                            <div class="text"><?= get_the_content()?></div>
                                        </div>
                                    </div>
                                <?php }?>
                                <?php $count++?>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
<!--                        <div class="item toggle_parent mt-50">-->
<!--                            <div class="toggle_btn fz-24">Can I cancel at any time?</div>-->
<!--                            <div class="toggle_content">-->
<!--                                <div class="text">Yes. There are no contracts or hidden fees so you can cancel your monthly or yearly service at any time.</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="item toggle_parent mt-50">-->
<!--                            <div class="toggle_btn fz-24">Can I cancel at any time?</div>-->
<!--                            <div class="toggle_content">-->
<!--                                <div class="text">Yes. There are no contracts or hidden fees so you can cancel your monthly or yearly service at any time.</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="item toggle_parent mt-50">-->
<!--                            <div class="toggle_btn fz-24">Can I cancel at any time?</div>-->
<!--                            <div class="toggle_content">-->
<!--                                <div class="text">Yes. There are no contracts or hidden fees so you can cancel your monthly or yearly service at any time.</div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
<!--                <div class="col-12 col-lg-6">-->
<!--                    <div class="content pt-100">-->
<!--                        <div class="item toggle_parent mt-50">-->
<!--                            <div class="toggle_btn fz-24">Can I cancel at any time?</div>-->
<!--                            <div class="toggle_content">-->
<!--                                <div class="text">Yes. There are no contracts or hidden fees so you can cancel your monthly or yearly service at any time.</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="item toggle_parent mt-50">-->
<!--                            <div class="toggle_btn fz-24">Can I cancel at any time?</div>-->
<!--                            <div class="toggle_content">-->
<!--                                <div class="text">Yes. There are no contracts or hidden fees so you can cancel your monthly or yearly service at any time.</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="item toggle_parent mt-50">-->
<!--                            <div class="toggle_btn fz-24">Can I cancel at any time?</div>-->
<!--                            <div class="toggle_content">-->
<!--                                <div class="text">Yes. There are no contracts or hidden fees so you can cancel your monthly or yearly service at any time.</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="item toggle_parent mt-50">-->
<!--                            <div class="toggle_btn fz-24">Can I cancel at any time?</div>-->
<!--                            <div class="toggle_content">-->
<!--                                <div class="text">Yes. There are no contracts or hidden fees so you can cancel your monthly or yearly service at any time.</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </section>
</main>
<?php get_footer() ?>
