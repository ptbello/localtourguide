<?php
// Register Custom Post Type
add_action( 'init', 'init_custom' );
function init_custom()
{
    register_cpt();
    register_cr();
    register_conn();
}

function register_cpt()
{
    register_cpt_tour();
    register_cpt_booking();
}
function register_cr()
{
    $registered = get_option('ltg_cr_created');
    if( empty($registered) ) {
        register_cpt_caps('tour');
        register_cpt_caps('booking');
        register_cr_guide();
        register_cr_tourist();
        add_option('ltg_cr_created', true);
    }
}
function register_conn()
{
    if( function_exists('p2p_register_connection_type') ) {

        p2p_register_connection_type( array(
                'name' => 'booking_tour',
                'from' => 'booking',
                'to' => 'tour',
                'cardinality' => 'many-to-one',
                'title' => array( 'from' => 'Tour', 'to' => 'Bookings' ),
                'admin_box' => array('show' => 'from'),
            )
        );
        p2p_register_connection_type( array(
                'name' => 'booking_tourist',
                'from' => 'booking',
                'to' => 'user',
                // 'to_query_vars' => array( 'role' => 'tourist' ),
                'cardinality' => 'many-to-many',
                'title' => array( 'from' => 'Participants', 'to' => 'Bookings' ),
                'admin_box' => array('show' => 'from'),
            )
        );
    }
}

function register_cpt_tour() {
    $slug = 'tour';
    $labels = array(
        'name'                => _x( 'Tours', 'Post Type General Name', 'ltg' ),
        'singular_name'       => _x( 'Tour', 'Post Type Singular Name', 'ltg' ),
        'menu_name'           => __( 'Tour', 'ltg' ),
        'parent_item_colon'   => __( 'Parent Tour:', 'ltg' ),
        'all_items'           => __( 'All Tours', 'ltg' ),
        'view_item'           => __( 'View Tour', 'ltg' ),
        'add_new_item'        => __( 'Add New Tour', 'ltg' ),
        'add_new'             => __( 'New Tour', 'ltg' ),
        'edit_item'           => __( 'Edit Tour', 'ltg' ),
        'update_item'         => __( 'Update Tour', 'ltg' ),
        'search_items'        => __( 'Search tours', 'ltg' ),
        'not_found'           => __( 'No tours found', 'ltg' ),
        'not_found_in_trash'  => __( 'No tours found in Trash', 'ltg' ),
    );
    $args = array(
        'label'               => __( 'tour', 'ltg' ),
        'description'         => __( 'Guided tours', 'ltg' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'revisions', 'comments' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 20,
        //'menu_icon'           => '',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => $slug,
        'map_meta_cap'        => true,
    );
    register_post_type( $slug, $args );
}

function register_cpt_caps( $slug, $roles = array('administrator') )
{
    $cpt_caps = get_post_type_object($slug)->cap;
    foreach( (array) $roles as $role_slug ) {
        $role = get_role( $role_slug );
        foreach($cpt_caps as $cap) $role->add_cap( $cap );
    }
}

function register_cpt_booking() {
    $slug = 'booking';
    $labels = array(
        'name'                => _x( 'Bookings', 'Post Type General Name', 'ltg' ),
        'singular_name'       => _x( 'Booking', 'Post Type Singular Name', 'ltg' ),
        'menu_name'           => __( 'Booking', 'ltg' ),
        'parent_item_colon'   => __( 'Parent Booking:', 'ltg' ),
        'all_items'           => __( 'All Bookings', 'ltg' ),
        'view_item'           => __( 'View Booking', 'ltg' ),
        'add_new_item'        => __( 'Add New Booking', 'ltg' ),
        'add_new'             => __( 'New Booking', 'ltg' ),
        'edit_item'           => __( 'Edit Booking', 'ltg' ),
        'update_item'         => __( 'Update Booking', 'ltg' ),
        'search_items'        => __( 'Search bookings', 'ltg' ),
        'not_found'           => __( 'No bookings found', 'ltg' ),
        'not_found_in_trash'  => __( 'No bookings found in Trash', 'ltg' ),
    );
    $args = array(
        'label'               => __( 'booking', 'ltg' ),
        'description'         => __( 'Guided tours\' bookings', 'ltg' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'author', 'revisions' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => false,
        'menu_position'       => 20,
        //'menu_icon'           => '',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'capability_type'     => $slug,
        //'map_meta_cap'        => true,
    );
    register_post_type( $slug, $args );
}

function register_cr_guide()
{
    $slug = 'guide';
    $label = __('Tour Guide', 'ltg');
    //remove_role( $slug );
    $tour_caps = clone get_post_type_object('tour')->cap;
    $caps_exclude_keys = array(
        'publish_posts',
        'edit_published_posts',
        'delete_others_posts',
        'edit_others_posts',
        'read_private_posts',
        'edit_private_posts',
        'delete_private_posts',
    );
    foreach($caps_exclude_keys as $caps_exclude_key) {
        unset($tour_caps->$caps_exclude_key);
    }

    $guide = clone_role('subscriber', $slug, $label);
    foreach($tour_caps as $cap) $guide->add_cap( $cap );
}

function register_cr_tourist()
{
    $slug = 'tourist';
    $label = __('Tourist', 'ltg');
    //remove_role( $slug );

    $guide = clone_role('subscriber', $slug, $label);
}


function clone_role($source_slug, $destination_slug, $destination_label)
{
    global $wp_roles;
    if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();

    $source = $wp_roles->get_role($source_slug);

    $wp_roles->add_role($destination_slug, $destination_label, $source->capabilities);
    return get_role( $destination_slug );
}

add_filter('wp_dropdown_users', 'register_cr_guide_as_tour_author');
function register_cr_guide_as_tour_author( $output )
{
    global $post;
    if( $post->post_type == 'tour') {
        $guides = get_users( array('role' => 'guide') );
        foreach($guides as $guide) {
            if($post->post_author == $guide->ID) continue;
            // the current post author is already included by default, so we skip him here
            $output .= '<option value="' . $guide->ID . '">' . $guide->user_login . '</option>';
        }
        // remove </select> from somewhere in the middle and re-add it at the end
        $output = str_replace('</select>', '', $output);
        $output .= '</select>';
    }
    return $output;
}

add_action('template_redirect', 'register_virtual_urls');
function register_virtual_urls()
{
    global $wp_query;
    $virtual_slugs = array(
        'booking_create',
        'booking_accept',
        'booking_refuse',
    );

    $virtual_slug = $wp_query->query_vars['pagename'];
    if( in_array($virtual_slug, $virtual_slugs) )
    {
        $wp_query->is_404 = NULL;
        $wp_query->is_page = 1;
        $wp_query->post_count = 1;
        status_header( 200 );
        locate_template( array("$virtual_slug.php"), TRUE);
        exit;
    }
}
