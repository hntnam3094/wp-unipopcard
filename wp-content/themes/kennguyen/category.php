<?php get_header(); ?>
<?php global $va_options?>
<?php $currentCategory = get_queried_object();
function getClassBlock($typeAccount) {
    if (check_membership() >= $typeAccount) {
        return '';
    }
    return 'block';
}
?>
<main>
    <section class="course_detail pt-40 pb-80">
        <div class="wraper">
            <h1 class="ttl_main fz-40 text-up"><?= $currentCategory->name ?></h1>
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="project">
                        <div class="row list-course">
                            <?php
                            $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
                            $args = array(
                                'post_status' => 'publish',
                                'post_type'      => 'craft',
                                'cat' => $currentCategory->cat_ID,
                                'posts_per_page' => 13,
                                'paged' => $paged
                            );
                            $the_query = new WP_Query( $args );
                            ?>
                            <?php if( $the_query->have_posts() ): ?>
                                <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>

                                    <div class="column col-6 col-md-4">
                                        <a class="item mt-40 <?= getClassBlock(get_field('type_account'))  ?>" href="<?= get_the_permalink()?>">
                                            <div class="images">
                                                <div class="imgDrop"> <img src="<?= get_the_post_thumbnail( get_the_id() ) ?>" alt=""/></div>
                                            </div>
                                            <div class="content" data-mh="content">
                                                <h4 class="text-up trim trim_2"><?= get_the_title()?></h4>
                                                <div class="desc">
                                                    <?php $categories = get_the_category(get_the_ID());
                                                    $listCategory = [];
                                                    foreach($categories as $category){
                                                        array_push($listCategory, $category->name);
                                                    }
                                                    echo implode(', ', $listCategory);
                                                    ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                            <?php wp_reset_query(); ?>

                        </div>
                        <div class="mt-40 text-center">
                            <div class="pagination" id="pagination">
                                <ul class="page-numbers">
                                    <?php
                                    $totalPages = $the_query->max_num_pages;
                                    if ($totalPages > 1) {
                                        $totalDisplay = 5;
                                        $currentPage = $paged;
                                        $paginationCheck = $totalPages / $totalDisplay;
                                        if ($currentPage > 1) {
                                            echo '<li><a class="prev page-numbers" href="?page='.($currentPage - 1).'"> < </a></li>';
                                        }

                                        if ($totalPages > 10) {
                                            $middleEnd = $currentPage + round($totalDisplay / 2);
                                            $middleStart = $currentPage - round($totalDisplay / 2);
                                            $hideDotLeft = false;
                                            $hideDotRight = false;
                                            if ($middleEnd >= $totalPages) {
                                                $middleEnd = $totalPages - 1;
                                                $middleStart = $middleStart - ($totalDisplay - ($middleEnd - $middleStart));
                                                $hideDotRight = true;
                                            }

                                            if ($middleStart <= $totalDisplay) {
                                                $hideDotLeft = true;
                                                $middleStart = 2;
                                            }


                                            if($currentPage == 1) {
                                                echo '<li><span class="page-numbers current" aria-current="page">1</span></li>';
                                            } else {
                                                echo '<li><a class="page-numbers" href="?page=1">1</a></li>';
                                            }

                                            if(!$hideDotLeft) {
                                                echo '<li><span class="page-numbers dots">…</span></li>';
                                            }

                                            for ($i = $middleStart; $i <= $middleEnd; $i++) {
                                                if ($currentPage == $i) {
                                                    echo '<li><span class="page-numbers current" aria-current="page">'.$i.'</span></li>';
                                                } else {
                                                    echo '<li><a class="page-numbers" href="?page='.$i.'">'.$i.'</a></li>';
                                                }
                                            }

                                            if(!$hideDotRight) {
                                                echo '<li><span class="page-numbers dots">…</span></li>';
                                            }

                                            if($totalPages == $currentPage) {
                                                echo '<li><span class="page-numbers current" aria-current="page">'.$totalPages.'</span></li>';
                                            } else {
                                                echo '<li><a class="page-numbers" href="?page='.$totalPages.'">'.$totalPages.'</a></li>';
                                            }

                                        } else {
                                            for ($i = 1; $i <= $totalPages; $i++) {
                                                if ($currentPage == $i) {
                                                    echo '<li><span class="page-numbers current" aria-current="page">'.$i.'</span></li>';
                                                } else {
                                                    echo '<li><a class="page-numbers" href="?page='.$i.'">'.$i.'</a></li>';
                                                }
                                            }
                                        }

                                        if ($currentPage < $totalPages) {
                                            echo '<li><a class="next page-numbers" href="?page='.($currentPage + 1).'"> > </a></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
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
                            <?php get_template_part('template-parts/order/form-email'); ?>
                        </div>
                    </div>
                    <div class="list_category mt-50">
                        <?php $parentCategory = get_category($currentCategory->parent) ?>
                        <h3 class="ttl text-up fz-22"><?= $parentCategory->name ?></h3>
                        <ul class="list mt-15">
                            <?php
                            $args = array(
                                'type'      => 'post',
                                'child_of'  => 0,
                                'hide_empty' => 0,
                                'parent'    => $currentCategory->parent
                            );
                            $categories = get_categories( $args );
                            foreach ( $categories as $key => $category ) {
                                echo ' <li> <a href="/' .$parentCategory->slug.'/'.$category->slug . '">' . $category->name . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                        $args = array(
                            'post_status' => 'publish',
                            'post_type'      => 'craft',
                            'meta_key' => 'craft_featured',
                            'meta_value' => 1,
                            'showposts' => 5
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
                                                    <a class="item mt-20 '. getClassBlock(get_field('type_account')) .'" href="'.get_the_permalink().'">
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
