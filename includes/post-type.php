<?php
namespace clinical_trials_cpt\post_type;

const custom_taxonomy = "clinical-trial-category";

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
            'supports'    => array( 'title', 'editor', 'revisions', 'thumbnail'),
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

    register_taxonomy(
        custom_taxonomy,
        array('clinical-trials'),
        array('label' => __('Categories'),
        'hierarchical' => true,
		'rewrite' => array('slug' => custom_taxonomy),
		'show_admin_column' => true,
		'show_in_rest' => true,
		)
    );
    // good practice to explicitely register the taxonomy for the CPT after both are defined, even though
    // the custom taxonomy specifies the post type to attach to
    register_taxonomy_for_object_type('clinical-category', 'clinical-trials');

}
