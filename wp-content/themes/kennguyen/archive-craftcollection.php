<?php get_header(); ?>
<?php $craftcollection = get_post_type_object( 'craftcollection' ); ?>
<main>
    <section class="category pt-50 pb-50">
        <div class="wraper">
            <h1 class="ttl_main fz-40 text-up"><?= $craftcollection->labels->name ?> </h1>
            <div class="heading">
                <h2 class="ttl_sub fz-31 text-up mt-40">Your SEPTEMBER CRAFT COLLECTION</h2>
                <div class="text">
                    <p>See a project you want to make?
                        <a href='#'>Become a member</a> to unlock this month’s collection and start crafting your favorites. When the month is up, you’ll get a new craft collection — and you can still access these projects anytime.</p>
                </div>
            </div>
            <div class="tab_category mt-30">
                <div class="row">
                    <?php
                    $args = array(
                        'type'      => 'post',
                        'child_of'  => 0,
                        'hide_empty' => 0,
                        'parent'    => 5
                    );
                    $categories = get_categories( $args );
                    foreach ( $categories as $category ) { ?>
                        <?php echo '<div class="col-12 col-md-6 col-lg-3 item">  <a class="active" href="/category/'.$category->slug.'" target="_blank">'.$category->name.'</a></div>' ; ?>
                    <?php } ?>
                </div>
            </div>
            <div class="course_main mt-10">
                <div class="row">
                    <div class="col-6 col-md-4 col-lg-3">
                        <a class="item mt-20" href="detail.html">
                            <div class="imgDrop">
                                <img src="common/images/product2.png" alt=""/>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <a class="item mt-20 block" href="detail.html">
                            <div class="imgDrop"> <img src="common/images/product2.png" alt=""/>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <a class="item mt-20 block" href="detail.html">
                            <div class="imgDrop"> <img src="common/images/product2.png" alt=""/>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3"> <a class="item mt-20 block" href="detail.html">
                            <div class="imgDrop"> <img src="common/images/product2.png" alt=""/></div></a></div>
                    <div class="col-6 col-md-4 col-lg-3"> <a class="item mt-20 block" href="detail.html">
                            <div class="imgDrop"> <img src="common/images/product2.png" alt=""/></div></a></div>
                    <div class="col-6 col-md-4 col-lg-3"> <a class="item mt-20 block" href="detail.html">
                            <div class="imgDrop"> <img src="common/images/product2.png" alt=""/></div></a></div>
                    <div class="col-6 col-md-4 col-lg-3"> <a class="item mt-20 block" href="detail.html">
                            <div class="imgDrop"> <img src="common/images/product2.png" alt=""/></div></a></div>
                    <div class="col-6 col-md-4 col-lg-3"> <a class="item mt-20 block" href="detail.html">
                            <div class="imgDrop"> <img src="common/images/product2.png" alt=""/></div></a></div>
                </div>
                <div class="mt-30 text-center"> <a class="btn_more" href=""> <span class="block fz-31">JOIN NOW</span><span class="block sub">To Unlock ALL Collection Projects!</span></a></div>
            </div>
            <div class="couse_intro mt-40">
                <div class="heading">
                    <h2 class="ttl_sub fz-31 text-up">September SVG CUT FILES & PRINTABLES</h2>
                    <div class="text">
                        <p>These designs are only available until the end of the month. <a href='#'>Become a member</a> to download them today!</p>
                    </div>
                </div>
                <div class="course_main mt-10">
                    <div class="row">
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20" href="detail.html">
                                <div class="imgDrop"> <img src="common/images/product3.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20 block" href="detail.html">
                                <div class="imgDrop"> <img src="common/images/product3.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20 block" href="detail.html">
                                <div class="imgDrop"> <img src="common/images/product3.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20 block" href="detail.html">
                                <div class="imgDrop"> <img src="common/images/product3.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20 block" href="detail.html">
                                <div class="imgDrop"> <img src="common/images/product3.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20 block" href="detail.html">
                                <div class="imgDrop"> <img src="common/images/product3.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20 block" href="detail.html">
                                <div class="imgDrop"> <img src="common/images/product3.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20 block" href="detail.html">
                                <div class="imgDrop"> <img src="common/images/product3.png" alt=""/></div></a></div>
                    </div>
                    <div class="mt-30 text-center"> <a class="btn_more" href=""> <span class="block fz-31">JOIN NOW</span><span class="block sub">To Unlock ALL Collection Projects!</span></a></div>
                </div>
            </div>
            <div class="key_bonus mt-40">
                <div class="heading">
                    <h2 class="ttl_sub fz-31 text-up">YWEEKLY BONUS</h2>
                    <div class="text">
                        <p>Every week we post a free project that you can download anytime and share with others!</p>
                    </div>
                </div>
                <div class="course_main mt-10">
                    <div class="row">
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20" href="#">
                                <div class="imgDrop"> <img src="common/images/product4.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20" href="#">
                                <div class="imgDrop"> <img src="common/images/product4.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20" href="#">
                                <div class="imgDrop"> <img src="common/images/product4.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20" href="#">
                                <div class="imgDrop"> <img src="common/images/product4.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20" href="#">
                                <div class="imgDrop"> <img src="common/images/product4.png" alt=""/></div></a></div>
                        <div class="col-4 col-md-3 col-lg-2"> <a class="item mt-20" href="#">
                                <div class="imgDrop"> <img src="common/images/product4.png" alt=""/></div></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
$args = array(
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'post_type'      => 'craftcollection'
);
$the_query = new WP_Query( $args );
?>
<?php if( $the_query->have_posts() ): ?>
    <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <?php the_title() ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_query(); ?>


<?php get_footer(); ?>
