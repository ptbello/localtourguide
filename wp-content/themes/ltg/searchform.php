<?php
/**
 * The template for displaying search forms in Local Tour Guide
 *
 * @package Local Tour Guide
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="navbar-search form-search pull-right">
		<label for="s" class="screen-reader-text"><?php _e( 'Search', 'ltg' ); ?></label>
        <div class="input-append">
		    <input type="text" class="search-query span2" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'ltg' ); ?>" />
            <button type="submit" class="btn"><i class="icon-search"></i></button>
        </div>
	</form>
