<?php
/**
* The Home Page template.
*
* Learn more: http://codex.wordpress.org/Template_Hierarchy
*
* @package Local Tour Guide
*/

$args = array(
    'post_type' => 'tour',
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => 5,
);
$tours = get_posts($args);

$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => 5,
);
$news = get_posts($args);

get_header(); ?>

<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <?php if ( !empty($tours) ) : ?>

        <header class="page-header">
            <h1 class="page-title">
                <?php _e('Latest Tours', 'ltg')?>
            </h1>
        </header><!-- .page-header -->
            <?php /* Start the Loop */ ?>
            <?php foreach($tours as $post) : setup_postdata($post); ?>

                <?php get_template_part( 'summary', get_post_type() ); ?>

            <?php endforeach; ?>

            <?php ltg_content_nav( 'nav-below' ); ?>

        <?php else : ?>

            <?php get_template_part( 'no-results', 'archive' ); ?>

        <?php endif; ?>

    </div><!-- #content -->
</section><!-- #primary -->

<div id="secondary" class="widget-area" role="complementary">
    <?php if ( !empty($news) ) : ?>

        <header class="page-header">
            <h1 class="page-title">
                <?php _e('Latest News', 'ltg')?>
            </h1>
        </header><!-- .page-header -->
        <?php /* Start the Loop */ ?>
        <?php foreach($news as $post) : setup_postdata($post); ?>

            <?php get_template_part( 'summary', get_post_type() ); ?>

        <?php endforeach; ?>

        <?php ltg_content_nav( 'nav-below' ); ?>

    <?php else : ?>

        <?php get_template_part( 'no-results', 'archive' ); ?>

    <?php endif; ?>

</div><!-- #secondary -->

<?php get_footer(); ?>