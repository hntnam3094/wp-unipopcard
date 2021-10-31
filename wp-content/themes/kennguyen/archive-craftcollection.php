<?php get_header(); ?>
<?php $craftcollection = get_post_type_object( 'craftcollection' );
$parentCategoryId = get_category_by_slug('craft-collection') !== null ? get_category_by_slug('craft-collection')->cat_ID : 0;
$isShowPost = check_membership() == 1 ? '' : 'block';
?>
<main>
    <section class="category pt-50 pb-50">
        <div class="wraper">
            <h1 class="ttl_main fz-40 text-up"><?= $craftcollection->labels->name ?> </h1>
            <div class="heading">
                <h2 class="ttl_sub fz-31 text-up mt-40">Your <?php echo date('F');?> CRAFT COLLECTION</h2>
                <?php if (check_membership() != 1) {
                    echo '<div class="text">
                    <p>See a project you want to make?
                        <a href="/upgrade-today">Become a member</a> to unlock this month’s collection and start crafting your favorites. When the month is up, you’ll get a new craft collection — and you can still access these projects anytime.</p>
                </div>';
                } ?>
            </div>
            <div class="tab_category mt-30">
                <div class="row">
                    <?php
                    $categoryNameSelected = get_query_var('category');
                    if (!empty($categoryNameSelected)) {
                        $categoryNameSelected = str_replace('-and-', '&', $categoryNameSelected);
                    }
                    $args = array(
                        'type'      => 'post',
                        'child_of'  => 0,
                        'hide_empty' => 0,
                        'parent'    => $parentCategoryId
                    );
                    $categories = get_categories( $args );
                    foreach ( $categories as $key => $category ) {
                        $active = $categoryNameSelected == $category->name ? 'active' : '';
                        if (empty($categoryNameSelected) && $key == 0) {
                            $active = 'active';
                            $categoryNameSelected = $category->name;
                        }
                        echo '<div class="col-12 col-md-6 col-lg-3 item">  <a class="' . $active . '" href="?category=' . str_replace('&', '-and-', $category->name) . '">' . $category->name . '</a></div>';
                    }
                        ?>
                </div>
            </div>
            <div class="course_main mt-10">
                <div class="row">
                    <?php
                    if (empty($categoryNameSelected)) {
                        $categoryIdSelected = 0;
                    } else {
                        $categoryIdSelected = get_cat_ID($categoryNameSelected);
                    }

                    $args = array(
                        'post_status' => 'free',
                        'post_type'      => 'craftcollection',
                        'cat' => $categoryIdSelected
                    );
                    $the_query = new WP_Query( $args );
                    ?>
                    <?php if( $the_query->have_posts() ): ?>
                        <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a class="item mt-20" href="<?= get_the_permalink()?>">
                                    <div class="imgDrop">
                                        <?php echo get_the_post_thumbnail( get_the_id() ); ?>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?>


                    <?php
                    $args = array(
                        'post_status' => 'sale',
                        'post_type'      => 'craftcollection',
                    );
                    $the_query = new WP_Query( $args );
                    ?>
                    <?php if( $the_query->have_posts() ): ?>
                        <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a class="item mt-20 <?= $isShowPost ?>" href="<?= get_the_permalink() ?>">
                                    <div class="imgDrop"> <?php echo get_the_post_thumbnail( get_the_id() ); ?>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?>

                </div>
                <?php if (check_membership() != 1) {
                    echo '<div class="mt-30 text-center"> <a class="btn_more" href="/upgrade-today">
                        <span class="block fz-31">JOIN NOW</span><span class="block sub">To Unlock ALL Collection Projects!</span>
                    </a>
                </div>';
                } ?>
            </div>
            <div class="couse_intro mt-40">
                <div class="heading">
                    <h2 class="ttl_sub fz-31 text-up">
                        <?php
                        $args = array(
                            'type'      => 'post',
                            'child_of'  => 0,
                            'hide_empty' => 0,
                            'parent'    => $parentCategoryId
                        );
                        $categories = get_categories( $args );
                        $listCategoriesShow = [];
                        foreach ( $categories as $category ) {
                            if (count(get_term_meta($category->term_id, 'show_category')) > 0 && get_term_meta($category->term_id, 'show_category')[0] == 'yes') {
                                array_push($listCategoriesShow, $category->name);
                            }
                        }
                        echo date('F').' '.implode(' & ', $listCategoriesShow);
                        ?>
                        </h2>
                    <?php if (check_membership() != 1) {
                       echo '<div class="text">
                        <p>These designs are only available until the end of the month. <a href="/upgrade-today">Become a member</a> to download them today!</p>
                    </div>';
                    }?>
                </div>
                <div class="course_main mt-10">
                    <div class="row">
                        <?php
                        $args = array(
                            'post_status' => 'free',
                            'posts_per_page' => -1,
                            'post_type'      => 'craftcollection',
                            'showposts' => 5
                        );
                        $the_query = new WP_Query( $args );
                        ?>
                        <?php if( $the_query->have_posts() ): ?>
                            <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <div class="col-4 col-md-3 col-lg-2">
                                    <a class="item mt-20" href="<?= get_the_permalink() ?>">
                                        <div class="imgDrop"> <?php echo get_the_post_thumbnail( get_the_id() ); ?></div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>

                        <?php
                        $args = array(
                            'post_status' => 'sale',
                            'posts_per_page' => -1,
                            'post_type'      => 'craftcollection',
                            'showposts' => 5
                        );
                        $the_query = new WP_Query( $args );
                        ?>
                        <?php if( $the_query->have_posts() ): ?>
                            <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <div class="col-4 col-md-3 col-lg-2">
                                    <a class="item mt-20 <?= $isShowPost ?>" href="<?= get_the_permalink() ?>">
                                        <div class="imgDrop"> <?php echo get_the_post_thumbnail( get_the_id() ); ?></div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </div>
                    <?php if (check_membership() != 1) {
                        echo '<div class="mt-30 text-center"> <a class="btn_more" href="/upgrade-today"> <span class="block fz-31">JOIN NOW</span><span class="block sub">To Unlock ALL Collection Projects!</span></a></div>';
                    } ?>
                </div>
            </div>
            <div class="key_bonus mt-40">
                <div class="heading">
                    <h2 class="ttl_sub fz-31 text-up">WEEKLY BONUS</h2>
                    <div class="text">
                        <p>Every week we post a free project that you can download anytime and share with others!</p>
                    </div>
                </div>
                <div class="course_main mt-10">
                    <div class="row">
                        <?php
                        $args = array(
                            'post_status' => 'free',
                            'posts_per_page' => -1,
                            'post_type'      => 'craftcollection',
                            'showposts' => 5
                        );
                        $the_query = new WP_Query( $args );
                        ?>
                        <?php if( $the_query->have_posts() ): ?>
                            <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <div class="col-4 col-md-3 col-lg-2">
                                    <a class="item mt-20" href="<?= get_the_permalink() ?>">
                                        <div class="imgDrop"> <?php echo get_the_post_thumbnail( get_the_id() ); ?></div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
