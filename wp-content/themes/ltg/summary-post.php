<?php
/**
 * @package Local Tour Guide
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
        <div class="entry-meta">
            <?php ltg_posted_on(); ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <div class="entry-summary">
        <?php the_excerpt(); ?>
        <?php ltg_more(); ?>
    </div><!-- .entry-summary -->
</article><!-- #post-## -->
<hr />
