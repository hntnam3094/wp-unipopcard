<?php
/**
 * Template Name: Craft page template
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

get_header();
global $va_options, $post;
$parentCategory = get_category_by_slug($post->post_name);
$parentCategoryId = $parentCategory != null ? $parentCategory->cat_ID : 0;
$parentCategorySlug = $parentCategory != null ? $parentCategory->slug : '';
function getClassBlock($typeAccount) {
    if (check_membership() >= $typeAccount) {
        return '';
    }
    return 'block';
}
$year = date('Y');
$month = date('n');
$listAllCatID = [];
?>
<main>
    <section class="category pt-50 pb-50">
        <div class="wraper">
            <h1 class="ttl_main fz-40 text-up"><?= $parentCategory->name ?></h1>
            <div class="heading">
                <h2 class="ttl_sub fz-31 text-up mt-40">Your <?php echo strtoupper(date('F'));?> <?= $parentCategory->name ?></h2>
<!--                --><?php //if (check_membership() < 1) {
//                    echo '<div class="text">
//                    <p>See a project you want to make?
//                        <a href="/upgrade-today">Become a member</a> to unlock this month’s collection and start crafting your favorites. When the month is up, you’ll get a new craft collection — and you can still access these projects anytime.</p>
//                </div>';
//                } ?>
            </div>
            <div class="course_main mt-30">
                <div class="row">
                    <?php
                    $args = array(
                        'type'      => 'post',
                        'child_of'  => 0,
                        'hide_empty' => 0,
                        'parent'    => $parentCategoryId
                    );
                    $categories = get_categories( $args );
                    $count = 1;
                    foreach ( $categories as $key => $category ) {
                        if (get_term_meta($category->term_id, 'feature_category')[0] == 'yes') {
                            array_push($listAllCatID, $category->cat_ID);
                            if ($count == 5) {
                                $count = 1;
                            }
                        ?>
                        <div class="col-12 col-lg-3 mt-30">
                            <div class="row tab_category">
                                <div class="col-12 tab item_0<?=$count++?>"><span><?= $category->name?> </span></div>
                            </div>
                            <div class="row">
                                <?php
                                $args = array(
                                    'post_status' => 'publish',
                                    'post_type'      => 'craft',
                                    'year' => $year,
                                    'monthnum' => $month,
                                    'cat' => $category->cat_ID,
                                    'showposts' => 2
                                );
                                $the_query = new WP_Query( $args );
                                ?>
                                <?php if( $the_query->have_posts() ): ?>
                                    <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                        <div class="col-6 col-md-12">
                                            <a class="item mt-20 <?= getClassBlock(get_field('type_account'))  ?>" href="<?= get_the_permalink()?>">
                                                <div class="imgDrop">
                                                    <?php echo get_the_post_thumbnail( get_the_id() ); ?>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>
                            </div>
                        </div>
                    <?php }}?>
                </div>
<!--                --><?php //if (check_membership() < 1) {
//                    echo '<div class="mt-30 text-center"> <a class="btn_more" href="/upgrade-today">
//                        <span class="block fz-31">JOIN NOW</span><span class="block sub">To Unlock ALL Collection Projects!</span>
//                    </a>
//                </div>';
//                } ?>
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
                        $listCatId = [];
                        foreach ( $categories as $category ) {
                            if (count(get_term_meta($category->term_id, 'show_category')) > 0 && get_term_meta($category->term_id, 'show_category')[0] == 'yes') {
                                array_push($listCategoriesShow, $category->name);
                                array_push($listCatId, $category->cat_ID);
                            }
                        }
                        echo date('F').' '.implode(' & ', $listCategoriesShow);
                        ?>
                    </h2>
<!--                    --><?php //if (check_membership() < 1) {
//                        echo '<div class="text">
//                        <p>These designs are only available until the end of the month. <a href="/upgrade-today">Become a member</a> to download them today!</p>
//                    </div>';
//                    }?>
                </div>
                <div class="course_main mt-10">
                    <div class="row">
                        <?php
                        $args = array(
                            'post_status' => 'publish',
                            'post_type'      => 'craft',
                            'year' => $year,
                            'monthnum' => $month,
                            'cat' => $listCatId,
                            'showposts' => 12
                        );
                        $the_query = new WP_Query( $args );
                        ?>
                        <?php if( $the_query->have_posts() ): ?>
                            <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <div class="col-6 col-md-4 col-lg-2">
                                    <a class="item mt-20 <?= getClassBlock(get_field('type_account'))  ?>" href="<?= get_the_permalink()?>">
                                        <div class="imgDrop">
                                            <?php echo get_the_post_thumbnail( get_the_id() ); ?>
                                        </div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </div>
<!--                    --><?php //if (check_membership() < 1) {
//                        echo '<div class="mt-30 text-center"> <a class="btn_more" href="/upgrade-today"> <span class="block fz-31">JOIN NOW</span><span class="block sub">To Unlock ALL Collection Projects!</span></a></div>';
//                    } ?>
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
                            'post_status' => 'publish',
                            'post_type'      => 'craft',
                            'meta_key' => 'weekly_bonus',
                            'meta_value' => 1,
                            'cat' => $listAllCatID,
                            'showposts' => 6
                        );
                        $the_query = new WP_Query( $args );
                        ?>
                        <?php if( $the_query->have_posts() ): ?>
                            <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <div class="col-4 col-md-3 col-lg-2">
                                    <a class="item mt-20 <?= getClassBlock(get_field('type_account'))  ?>" href="<?= get_the_permalink() ?>">
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
