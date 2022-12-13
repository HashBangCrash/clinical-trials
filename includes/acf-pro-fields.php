<?php

/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 2019-02-01
 * Time: 1:47 PM
 */

namespace clinical_trials_cpt\acf_pro_fields;

add_action( 'init', __NAMESPACE__ . '\\register_acf_blocks', 5 );
add_action( 'acf/init', __NAMESPACE__ . '\\create_fields' );

function register_acf_blocks() {
    register_block_type( plugin_dir_path(__FILE__) . 'blocks/clinical-trials-listing/block.json' );
}


function create_fields() {
    // check function exists


    // fields for the custom post type
    if ( function_exists( 'acf_add_local_field_group' ) ) {
        acf_add_local_field_group(array(
            'key' => 'group_638661b5e84bf',
            'title' => 'Clinical Trials Fields',
            'fields' => array(
                array(
                    'key' => 'field_63866ca035d9c',
                    'label' => 'Enrollment Status',
                    'name' => 'enrollment_status',
                    'type' => 'radio',
                    'instructions' => 'Mark the trial enrollment status. Either use a date range for open enrollment, or manually specify if the trial is currently open or closed.',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        'date_range' => 'Use date range',
                        'open' => 'Open',
                        'closed' => 'Closed',
                    ),
                    'allow_null' => 0,
                    'other_choice' => 0,
                    'default_value' => '',
                    'layout' => 'vertical',
                    'return_format' => 'value',
                    'save_other_choice' => 0,
                ),
                array(
                    'key' => 'field_638666f4e8a01',
                    'label' => 'Enrollment Start Date',
                    'name' => 'enrollment_start_date',
                    'type' => 'date_picker',
                    'instructions' => 'Date when enrollment opens (assumes 12:00am in the morning)',
                    'required' => 1,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_63866ca035d9c',
                                'operator' => '==',
                                'value' => 'date_range',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'display_format' => 'Y-m-d',
                    'return_format' => 'Y-m-d',
                    'first_day' => 0,
                ),
                array(
                    'key' => 'field_63866738e8a02',
                    'label' => 'Enrollment Last Date',
                    'name' => 'enrollment_last_date',
                    'type' => 'date_picker',
                    'instructions' => 'Last date enrollment is open, ending at 11:59pm. The day after this date is considered closed.',
                    'required' => 1,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_63866ca035d9c',
                                'operator' => '==',
                                'value' => 'date_range',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'display_format' => 'Y-m-d',
                    'return_format' => 'Y-m-d',
                    'first_day' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'clinical-trials',
                    ),
                ),
            ),
            'menu_order' => -1,
            'position' => 'acf_after_title',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'excerpt',
                1 => 'discussion',
                2 => 'comments',
                3 => 'featured_image',
                4 => 'categories',
                5 => 'tags',
                6 => 'send-trackbacks',
            ),
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));
    }

    // fields for the block editor
    acf_add_local_field_group(array(
        'key' => 'group_6398d8aa5140e',
        'title' => 'clinical trial selector',
        'fields' => array(
            array(
                'key' => 'field_6398d9571330c',
                'label' => 'Limit trials listing to specified categories',
                'name' => 'limit_trials_listing_to_specified_categories',
                'aria-label' => '',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui_on_text' => 'Show all trials',
                'ui_off_text' => 'Limit by categories',
                'ui' => 1,
            ),
            array(
                'key' => 'field_6398d8ab1b6e3',
                'label' => 'Include Specified Categories',
                'name' => 'include_specified_categories',
                'aria-label' => '',
                'type' => 'taxonomy',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_6398d9571330c',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'taxonomy' => 'category',
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'id',
                'field_type' => 'checkbox',
                'multiple' => 0,
                'allow_null' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'clinical-trials-cpt/clinical-trials-listing',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
}

