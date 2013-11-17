<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Local Tour Guide
 */
?>
	<div id="secondary" class="widget-area" role="complementary">
        <h3><?php the_field('min_ppl'); ?> - <?php the_field('max_ppl'); ?> <small> <?php _e('participants', 'ltg'); ?></small></h3>
        <hr />
        <h3>€ <?php the_field('price_pp'); ?> <small> /<?php _e('participant', 'ltg'); ?></small></h3>
        <hr />
        <h3><small><?php _e('duration:', 'ltg'); ?> </small> <?php the_field('duration_h'); ?>h:<?php the_field('duration_m'); ?>'</h3>
        <hr />
        <img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php the_field('lat'); ?>,<?php the_field('lng'); ?>&zoom=12&size=270x270&sensor=false">
        <script>

        </script>
    </div><!-- #secondary -->
