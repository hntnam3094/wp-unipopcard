<?php
global $va_options;
include_once dirname( __FILE__ ).'/auth.php';

$SearchOptions = new stdClass();
$SearchOptions->Enabled = True;

$jsonRpcRequest = array (
    'jsonrpc' => '2.0',
    'id' => $i++,
    'method' => 'searchProducts',
    'params' => array($sessionID, $SearchOptions)
);
$listProducts = callRPC((Object)$jsonRpcRequest, $host, true);
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
                    <?php if( $listProducts ):  ?>
                        <?php
                        $i = 1;
                        foreach ($listProducts->Items as $key => $item) {
                            $productCode = $item->ProductCode;
                            $productName = $item->ProductName;
                            $isFeatured = '';
                            if (isset($item->ProductGroup)) {
                                $isFeatured = $item->ProductGroup->Name == 'Is featured';
                            }
                            $shortDescription = $item->ShortDescription;
                            $longDescription = $item->LongDescription;
                            $regularAmount = 0;
                            if (isset($item->PricingConfigurations[0]) && isset($item->PricingConfigurations[0]->Prices->Regular[0])) {
                                $regularAmount = $item->PricingConfigurations[0]->Prices->Regular[0]->Amount;
                            }
                            $renewalAmount = 0;
                            if (isset($item->PricingConfigurations[0]) && isset($item->PricingConfigurations[0]->Prices->Renewal[0])) {
                                $renewalAmount = $item->PricingConfigurations[0]->Prices->Renewal[0]->Amount;
                            }
                            //$billingCycle = $item->SubscriptionInformation->BillingCycle;
                            //$unitCycle = $item->SubscriptionInformation->BillingCycleUnits;
                        ?>
                            <div style="margin-bottom: 30px" class="item_package text-center <?= !$isFeatured ? 'package_month' : 'package_year' ?>">
                                <div class="info_main">
                                    <h3 class="ttl fz-31"><?=  $productName ?></h3>
                                    <div class="price center midle flexBox mt-20">
                                        <div class="new fz-45"><?=  $regularAmount ?>$</div>
                                        <?php if($renewalAmount) { ?>
                                        <div class="old fz-22"><?=  $renewalAmount ?>$</div>
                                        <?php } ?>
                                    </div>
                                    <?= $shortDescription ?>
                                    <a class="button mt-20" href="<?php site_url() ?>/payment?package_code=<?= $productCode ?>" target="_blank">JOIN NOW</a>
                                </div>
                                <div class="info_other toggle_parent">
                                    <div class="toggle_content">
                                        <div class="list_detail mt-30 pt-15 pb-40">
                                            <?= $longDescription ?>
                                        </div><a class="button mt-40" href="<?php site_url() ?>/payment?package_code=<?= $productCode ?>" target="_blank">JOIN NOW</a>
                                    </div>
                                    <div class="toggle_btn">
                                        <div class="short">View more </div>
                                        <div class="long">
                                            Collapse</div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
