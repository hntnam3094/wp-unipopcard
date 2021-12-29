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

    <main>
        <section class="course_detail pt-40 pb-80">
            <div class="wraper">
                <h1 class="ttl_main fz-40 text-up"><?= the_title() ?></h1>
                <div class="row">
                    <?= the_content(); ?>
                </div>
            </section>
        </main><!-- #main -->

<?php
get_footer();
