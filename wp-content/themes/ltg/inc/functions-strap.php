<?php

/**
 * Bootstrap menu class injection
 */
function bootstrap_menu_objects($sorted_menu_items, $args)
{
    if($args->theme_location == 'primary')
    {//
        $current = array('current-menu-ancestor', 'current-menu-item');
        $registry = array();
        foreach($sorted_menu_items as $i => $item) {
            $is_current = array_intersect( (array) $item->classes, $current );
            if ( !empty($is_current) ) $item->classes[] = 'active';
            $registry[$item->ID] = $i;
            if($item->menu_item_parent) {
                $parent_index = $registry[$item->menu_item_parent];
                if( !in_array('dropdown', $sorted_menu_items[$parent_index]->classes) ) {
                    $sorted_menu_items[$parent_index]->classes[] = 'dropdown';
                }
            }
        }
        //print_r($sorted_menu_items);print_r($args);exit;
    }
    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'bootstrap_menu_objects', 10, 2 );


/**
 * Custom Bootstrap Walker
 */
class Bootstrap_Nav_Menu extends Walker_Nav_Menu {
    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        if(is_array($args)) $args = json_decode(json_encode($args)); // convert to object
        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $dropdown = in_array('dropdown', $classes);
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        if($depth > 0) $class_names = str_replace('dropdown', 'dropdown-submenu', $class_names);

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= $dropdown                    ? ' class="dropdown-toggle" data-toggle="dropdown" data-target="#"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        if($dropdown && $depth == 0) $item_output .= ' <b class="caret"></b>';
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/**
 * Bootstrap styled Caption shortcode.
 * Hat tip: http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
add_filter( 'img_caption_shortcode', 'bootstrap_img_caption_shortcode', 10, 3 );

function bootstrap_img_caption_shortcode( $output, $attr, $content )  {

    /* We're not worried abut captions in feeds, so just return the output here. */
    if ( is_feed() )  return '';

    extract(shortcode_atts(array(
                'id'	=> '',
                'align'	=> 'alignnone',
                'width'	=> '',
                'caption' => ''
            ), $attr));

    if ( 1 > (int) $width || empty($caption) )
        return $content;

    if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

    return '<div ' . $id . 'class="thumbnail ' . esc_attr($align) . '">'
        . do_shortcode( $content ) . '<div class="caption">' . $caption . '</div></div>';
}

/**
 * Bootstrap styled Comment form.
 */
add_filter( 'comment_form_defaults', 'bootstrap_comment_form_defaults', 10, 1 );

function bootstrap_comment_form_defaults( $defaults )
{
    /*    */

    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $defaults['fields'] =  array(
        'author' => '<div class="control-group comment-form-author">' .
            '<label for="author" class="control-label">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
            '<div class="controls"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  class="span3"' . $aria_req . ' /></div>' .
            '</div>',
        'email'  => '<div class="control-group comment-form-email">' .
            '<label for="email" class="control-label">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
            '<div class="controls"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"  class="span3"' . $aria_req . ' /></div>' .
            '</div>',
        'url'    => '<div class="control-group comment-form-url">' .
            '<label for="url" class="control-label">' . __( 'Website' ) . '</label>' .
            '<div class="controls"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  class="span3" /></div>' .
            '</div>',
    );
    $defaults['comment_field'] = '<div class="control-group comment-form-comment">' .
        '<label for="comment" class="control-label">' . _x( 'Comment', 'noun' ) . '</label>' .
        '<div class="controls"><textarea id="comment" name="comment" aria-required="true" class="span6" rows="8"></textarea>' .
        '<span class="help-block form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</span></div>' .
        '</div>';

    $defaults['comment_notes_after'] = '';

    return $defaults;
}

add_filter( 'embed_oembed_html', 'bootstrap_oembed_html', 10, 1 );

function bootstrap_oembed_html( $html )
{
    return '<div class="embed-container">' . $html . '</div>';
}

