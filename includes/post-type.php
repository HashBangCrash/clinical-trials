<?php
namespace clinical_trials_cpt\post_type;

add_action( 'init', __NAMESPACE__ . '\\create_post_type' );

function create_post_type(): void
{
    register_post_type( 'clinical-trials',
        array(
            'labels'      => array(
                'name'          => __( 'Clinical Trials' ),
                'singular_name' => __( 'Clinical Trial' ),
                'add_new'       => __( 'Add Clinical Trial' ),
                'add_new_item'  => __( 'Add Clinical Trial' ),
                'edit_item'     => __( 'Edit Clinical Trial' )
            ),
            'taxonomies'  => array( 'category' ),
            'supports'    => array( 'title', 'editor', 'revisions' ),
            'public'      => true,
            'show_ui'     => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'show_in_rest' => true,
            'has_archive' => true,
            'rewrite'     => array(
                'slug'       => 'clinical-trials',
                'with_front' => false
            ),
        )
    );
}

