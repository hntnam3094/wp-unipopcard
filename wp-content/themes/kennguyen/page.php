<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>

        <main id="main" class="site-main">
            <section class="course_detail pt-40 pb-40">
                <div class="wraper">
                    <?php

                    // Start the Loop.
                    while ( have_posts() ) :
                        the_post();


                        the_content();
//                get_template_part( 'template-parts/content/content', 'page' );

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }

                    endwhile; // End the loop.
                    ?>
                </div>
            </section>
        </main><!-- #main -->

<?php
get_footer();
