<?php
/**
 * @package Local Tour Guide
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
    </header><!-- .entry-header -->
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->
    <footer class="row-fluid entry-meta">
        <span class="span3">
            <?php the_field('min_ppl'); ?> - <?php the_field('max_ppl'); ?> <?php _e('participants', 'ltg'); ?>
        </span>
        <span class="span3">
             € <?php the_field('price_pp'); ?>/<?php _e('participant', 'ltg'); ?>
        </span>
        <span class="span3">
            <?php the_field('duration_h'); ?>H:<?php the_field('duration_m'); ?>'
        </span>
        <span class="span3">
            <?php ltg_more(); ?>
        </span>
    </footer><!-- .entry-meta -->
</article><!-- #post-## -->
<hr />
