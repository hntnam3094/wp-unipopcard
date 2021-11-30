<?php
global $va_options;
if ($_POST['message_type'] == 'RECURRING_INSTALLMENT_SUCCESS') {

    $table = $wpdb->prefix.'customer';
    $data = array();
    $data['first_name'] = 1111111;
    $data['last_name'] = 2222222;
    $data['email'] = 321321321313;
    $data['password'] = 444444444;
    $data['created_at'] = date("Y-m-d h:i:s");
    $data['trackingMd5'] = json_encode($_POST);

    $insertRs = $wpdb->insert($table, $data);

    $insMessage = array();
    foreach ($_POST as $k => $v) {
        $insMessage[$k] = $v;
    }

    # Validate the Hash
    $hashSecretWord = "tango"; # Input your secret word
    $hashSid = 1303908; #Input your seller ID (2Checkout account number)
    $hashOrder = $insMessage['sale_id'];
    $hashInvoice = $insMessage['invoice_id'];
    $StringToHash = strtoupper(md5($hashOrder . $hashSid . $hashInvoice . $hashSecretWord));

    if ($StringToHash != $insMessage['md5_hash']) {
        die('Hash Incorrect');
    }

    switch ($insMessage['fraud_status']) {
        case 'pass':

            break;
        case 'fail':
            # Do something when sale fails fraud review.
            break;
        case 'wait':
            # Do something when sale requires additional fraud review.
            break;
    }
}

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
                    <?php
                    $args = array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'post_type'      => 'package',
                        'orderby' => 'id',
                        'order'   => 'ASC',
                    );
                    $the_query = new WP_Query( $args );6
                    ?>
                    <?php if( $the_query->have_posts() ):  ?>
                        <?php
                        $i = 1;
                        while( $the_query->have_posts() ) : $the_query->the_post();
                            $slug = basename(get_permalink(get_the_ID()));
                            $i++;

                        ?>
                            <div style="margin-bottom: 30px" class="item_package text-center <?= $i % 2 == 0 ? 'package_month' : 'package_year' ?>">
                                <div class="info_main">
                                    <h3 class="ttl fz-31"><?=  get_the_title() ?></h3>
                                    <div class="price center midle flexBox mt-20">
                                        <div class="new fz-45"><?=  get_field('sale_price', get_the_ID()) ?>$</div>
                                        <div class="old fz-22"><?=  get_field('price', get_the_ID()) ?>$</div>
                                    </div>
                                    <div class="fz-22 mt-10">Full Acess</div>
                                    <div class="fz-20 mt-15 price_detail"><?=  get_field('description', get_the_ID()) ?></div>
                                    <a class="button mt-20" href="<?php site_url() ?>/payment?package=<?= $slug ?>">JOIN NOW</a>
                                </div>
                                <div class="info_other toggle_parent">
                                    <div class="toggle_content">
                                        <div class="list_detail mt-30 pt-15 pb-40">
                                            <?php
                                                if (!empty(get_field('content_package', get_the_ID())['content_package_item'])) {
                                                    foreach (get_field('content_package', get_the_ID())['content_package_item'] as $key => $item) {
                                                        ?>
                                                        <dl class="mt-20">
                                                            <dt><?= $item['content'] ?></dt>
                                                            <dd><?= $item['value'] ?></dd>
                                                        </dl>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </div><a class="button mt-40" href="<?php site_url() ?>/payment?package=<?= $slug ?>">JOIN NOW</a>
                                    </div>
                                    <div class="toggle_btn">
                                        <div class="short">View more </div>
                                        <div class="long">
                                            Collapse</div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
<!--                    <div class="item_package text-center package_month">-->
<!--                        <div class="info_main">-->
<!--                            <h3 class="ttl fz-31">--><?//=  $va_options['kn_monthly_package_title']; ?><!--</h3>-->
<!--                            <div class="price center midle flexBox mt-20">-->
<!--                                <div class="new fz-45">--><?//=  $va_options['kn_monthly_package_sale_price']; ?><!--$</div>-->
<!--                                <div class="old fz-22">--><?//=  $va_options['kn_monthly_package_price']; ?><!--$</div>-->
<!--                            </div>-->
<!--                            <div class="fz-22 mt-10">Full Acess</div>-->
<!--                            <div class="fz-20 mt-15 price_detail">--><?//=  $va_options['kn_monthly_package_detail']; ?><!--</div>-->
<!--                            <a class="button mt-20" href="--><?php //site_url() ?><!--/payment?package=monthly">JOIN NOW</a>-->
<!--                        </div>-->
<!--                        <div class="info_other toggle_parent">-->
<!--                            <div class="toggle_content">-->
<!--                                <div class="list_detail mt-30 pt-15 pb-40">-->
<!--                                    --><?php //$args = array(
//                                        'post_type'      => 'packagecontent',
//                                    );
//                                    $the_query = new WP_Query( $args );
//                                    ?>
<!--                                    --><?php //if( $the_query->have_posts() ): ?>
<!--                                        --><?php //while( $the_query->have_posts() ) : $the_query->the_post(); ?>
<!--                                        --><?php //if(in_array('month', get_field('monthly_or_yearly_package'))){?>
<!--                                            <dl class="mt-20">-->
<!--                                                <dt>--><?//= the_field('content')?><!--</dt>-->
<!--                                                <dd>--><?//= the_field('value')?><!--</dd>-->
<!--                                            </dl>-->
<!--                                            --><?php //}?>
<!--                                        --><?php //endwhile; ?>
<!--                                    --><?php //endif; ?>
<!--                                    --><?php //wp_reset_query(); ?>
<!--                                </div><a class="button mt-40" href="--><?php //site_url() ?><!--/payment?package=monthly">JOIN NOW</a>-->
<!--                            </div>-->
<!--                            <div class="toggle_btn">-->
<!--                                <div class="short">View more </div>-->
<!--                                <div class="long">-->
<!--                                    Collapse</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="item_package text-center package_year">-->
<!--                        <div class="info_main">-->
<!--                            <h3 class="ttl fz-31">--><?//=  $va_options['kn_yearly_package_title']; ?><!--</h3>-->
<!--                            <div class="price center midle flexBox mt-20">-->
<!--                                <div class="new fz-45">--><?//=  $va_options['kn_year_package_sale_price']; ?><!--$</div>-->
<!--                                <div class="old fz-22">--><?//=  $va_options['kn_year_package_price']; ?><!--$</div>-->
<!--                            </div>-->
<!--                            <div class="fz-22 mt-10">Full Acess</div>-->
<!--                            <div class="fz-20 mt-15 price_detail">--><?//=  $va_options['kn_year_package_detail']; ?><!--</div>-->
<!--                            <a class="button mt-20" href="--><?php //site_url() ?><!--/payment?package=yearly">JOIN NOW </a>-->
<!--                        </div>-->
<!--                        <div class="info_other toggle_parent">-->
<!--                            <div class="toggle_content">-->
<!--                                <div class="list_detail mt-30 pt-15 pb-40">-->
<!--                                    --><?php //$args = array(
//                                        'post_type'      => 'packagecontent',
//                                    );
//                                    $the_query = new WP_Query( $args );
//                                    ?>
<!--                                    --><?php //if( $the_query->have_posts() ): ?>
<!--                                        --><?php //while( $the_query->have_posts() ) : $the_query->the_post(); ?>
<!--                                            --><?php //if(in_array('year', get_field('monthly_or_yearly_package'))){?>
<!--                                                <dl class="mt-20">-->
<!--                                                    <dt>--><?//= the_field('content')?><!--</dt>-->
<!--                                                    <dd>--><?//= the_field('value')?><!--</dd>-->
<!--                                                </dl>-->
<!--                                            --><?php //}?>
<!--                                        --><?php //endwhile; ?>
<!--                                    --><?php //endif; ?>
<!--                                    --><?php //wp_reset_query(); ?>
<!--                                </div><a class="button mt-40" href="--><?php //site_url() ?><!--/payment?package=yearly">JOIN NOW</a>-->
<!--                            </div>-->
<!--                            <div class="toggle_btn">-->
<!--                                <div class="short">View more </div>-->
<!--                                <div class="long">-->
<!--                                    Collapse</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
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
