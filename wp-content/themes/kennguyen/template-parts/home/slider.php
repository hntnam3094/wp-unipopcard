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
                            <div class="video">
                                <div class="imgDrop custom-slider">
                                    <iframe width="100%" data-src="" frameborder="0" allowfullscreen="" src="<?= the_field('url')?> ?>"></iframe>
                                </div>
                                <h4 class="ttl mt-15 text-center"><?= get_the_title()?></h4>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
            </div>
        </div>
    </div>
</section>
