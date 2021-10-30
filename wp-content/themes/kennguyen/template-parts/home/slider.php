<section class="video_show pt-50 pb-40">
    <div class="wraper">
        <div class="content_main">
            <div class="screenshot_slider owl-carousel">
                <?php $args = array(
                    'post_type'      => 'slider',
                    'showposts' => 5
                );
                $the_query = new WP_Query( $args );
                ?>
                <?php if( $the_query->have_posts() ): ?>
                    <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <div class="item">
                            <a class="video" href="<?= the_field('url')?>">
                                <div class="imgDrop"><?= get_the_post_thumbnail( get_the_id(), 'collection-thumb', array() ); ?></div>
                                <h4 class="ttl mt-15 text-center"><?= get_the_title()?></h4>
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
            </div>
        </div>
    </div>
</section>
