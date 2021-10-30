<?php get_header(); ?>
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
              <input class="input" type="text" placeholder="Search..."/>
              <input class="submit" type="submit"/>
            </div>
          </div>
          <div class="content_main">
            <div class="row">
                <?php
                $category = get_query_var('category');
                if (empty($category)) {
                    $category = 0;
                } else {
                    $category = get_cat_ID($category);
                }
                $args = array(
                    'post_status' => array('free', 'sale'),
                    'post_type'      => array('craftcollection', 'craftacademy'),
                    'cat' => $category,
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $the_query = new WP_Query( $args );
                ?>
                <?php if( $the_query->have_posts() ): ?>
                    <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <div class="column col-6 col-md-3">
                            <a class="item block mt-40" href="detail.html">
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
          <div class="mt-40 text-center"> <a class="btn_more fz-20" href="category.htnl">LOAD MORE </a></div>
        </div>
      </section>
      <?php get_template_part('template-parts/home/slider'); ?>
    </main>

<?php get_footer(); ?>
