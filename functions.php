<?php
$labels = array(
    'name'                          => 'Tootegrupid',
    'singular_name'                 => 'Tootegrupp',
    'search_items'                  => 'Otsi tootegruppe',
    'popular_items'                 => 'Popid tootegrupid',
    'all_items'                     => 'Koik tootegrupid',
    'parent_item'                   => 'Ylemine tootegrupp',
    'edit_item'                     => 'Muuda tootegruppi',
    'update_item'                   => 'Uuenda tootegruppi',
    'add_new_item'                  => 'Lisa uus tootegrupp',
    'new_item_name'                 => 'Uus tootegrupp',
    'separate_items_with_commas'    => 'Eralda tootegrupid komadega',
    'add_or_remove_items'           => 'Lisa voi eemalda tootegruppe',
    'choose_from_most_used'         => 'Choose from most used Brands'
    );

$args = array(
    'label'                         => 'Tootegrupid',
    'labels'                        => $labels,
    'public'                        => true,
    'hierarchical'                  => true,
    'show_ui'                       => true,
    'show_in_nav_menus'             => true,
    'args'                          => array( 'orderby' => 'term_order' ),
    'rewrite'                       => array( 'slug' => 'pood/tooted', 'with_front' => false ),
    'query_var'                     => true
);

register_taxonomy( 'tootegrupid', 'tooted', $args );


register_post_type( 'tooted',
    array(
        'labels'                => array(
            'name'              => __( 'Tooted' ),
            'singular_name'     => __( 'Toode' )
            ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'rewrite'               => array( 'slug' => 'pood', 'with_front' => false ),
        'has_archive'           => true
    )
);






add_theme_support( 'post-thumbnails' );
add_action( 'init', 'create_my_post_types' );
	


?>