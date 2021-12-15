<?php get_header(); ?>
<?php
function getClassBlock($typeAccount) {
    if (check_membership() >= $typeAccount) {
        return '';
    }
    return 'block';
}
?>
    <main>
        <?php get_template_part('template-parts/home/banner'); ?>
        <?php get_template_part('template-parts/home/video'); ?>

      <section class="project pt-40 pb-40">
        <div class="wraper">
          <div class="heading flexBox midle">
            <h2 class="ttl_main fz-40 text-up">EXPLORE OUR PROJECTS</h2>
            <div class="sort">
              <div class="dropdown">
                  <?php $category = get_query_var('category');
                  if (empty($category)) {
                      $category = "ALL CATEGORIES";
                  }
                  ?>
                <div class="dropdown-toggle" id="dropdownMenuButton1" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $category;?></div>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="/">ALL CATEGORIES</a></li>
                    <?php
                    $cat_args = array(
                        'parent'  => 0,
                        'hide_empty' => 0,
                        'order'    => 'ASC',
                    );
                    $categories = get_categories($cat_args); foreach ($categories as $category) {
                        echo '<li><a class="dropdown-item" href="?category='.$category->name.'">'.$category->name.'</a></li>';
                    }?>
                </ul>
              </div>
            </div>
            <div class="search_project">
              <input class="input" type="text" placeholder="Search..." id="input-search-data" onkeypress="handle(event)"/>
              <input class="submit" type="submit" id="btn-search-data"/>
            </div>
          </div>
          <div class="content_main">
            <div class="row" id="listCollectionNew">
                <?php
                $category = get_query_var('category');
                $keyword = get_query_var('q');
                if (empty($category)) {
                    $category = 0;
                } else {
                    $category = get_cat_ID($category);
                }
                $args = array(
                    'post_status' => 'publish',
                    'post_type'      => 'craft',
                    'cat' => $category,
                    's'		=> $keyword,
                    'showposts' => 11,
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $the_query = new WP_Query( $args );
                ?>
                <?php if( $the_query->have_posts() ): ?>
                    <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <div class="column col-6 col-md-3">
                            <a class="item mt-40 <?= getClassBlock(get_field('type_account'))  ?>" href="<?= get_the_permalink() ?>">
                                <div class="images">
                                    <div class="imgDrop"> <?php echo get_the_post_thumbnail( get_the_ID() ); ?></div>
                                </div>
                                <div class="content" data-mh="content">
                                    <h4 class="text-up trim trim_2"><?php echo get_the_title();?></h4>
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
          </div>
            <div class="text-center">
                <div class="spinner-border" role="status" id="div-loading-data" style="display: none"></div>
            </div>
          <div class="mt-40 text-center">
              <a class="btn_more fz-20" id="btn-load-more">LOAD MORE </a>
          </div>
        </div>
      </section>
      <?php get_template_part('template-parts/home/slider'); ?>
    </main>

<?php get_footer(); ?>
