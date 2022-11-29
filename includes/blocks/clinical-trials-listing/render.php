<?php
namespace clinical_trials_cpt\render;

// get all posts that are open for enrollment
$trials_open_for_enrollment = get_posts([

    'post_type'      => 'clinical-trials',
    'posts_per_page' => -1,
    'meta_query' => array(
        // limit to trials that are either marked as open, or are marked with a date range encompassing today's date
        'relation'		=> 'OR',
        array(
            'key'		=> 'enrollment_status',
            'compare'	=> '=',
            'value'		=> 'open'
        ),
        array(
            'relation' => 'AND',
            array(
                'key'		=> 'enrollment_start_date',
                'compare'	=> '<=',
                'value'		=> date('Y-m-d'),
                'type'      => 'DATE'
            ),
            array(
                'key'		=> 'enrollment_last_date',
                'compare'	=> '>=',
                'value'		=> date('Y-m-d'),
                'type'      => 'DATE'
            ),
        ),

    ),
]);
/* @var $trials_open_for_enrollment WP_Post[] */

// get all posts that are not open for enrollment
$trials_closed_for_enrollment = get_posts([
    'post_type'      => 'clinical-trials',
    'posts_per_page' => -1,
    'meta_query' => array(
        // limit to trials that are either marked as closed, or are marked with a date range not encompassing today's date
        'relation'		=> 'OR',
        array(
            'key'		=> 'enrollment_status',
            'compare'	=> '=',
            'value'		=> 'closed'
        ),
        array(
            'relation' => 'OR',
            array(
                'key'		=> 'enrollment_start_date',
                'compare'	=> '>',
                'value'		=> date('Y-m-d'),
                'type'      => 'DATE'
            ),
            array(
                'key'		=> 'enrollment_last_date',
                'compare'	=> '<',
                'value'		=> date('Y-m-d'),
                'type'      => 'DATE'
            ),
        ),

    ),
]);
/* @var $trials_closed_for_enrollment WP_Post[] */

if (!empty($trials_open_for_enrollment)) {
    $accordion_content = "";
    foreach ($trials_open_for_enrollment as $row_index=>$clinical_trial) {

        $fold_title = get_sub_field( 'title' );
        $fold_content = get_sub_field( 'content' );
        $accordion_content = "
            <div class='card'>
                <div class='card-header' id='heading-{$row_index}'>
                    <h2 class='mb-0'>
                        <button 
                        class='btn btn-link btn-block text-left' 
                        type='button' 
                        data-toggle='collapse' 
                        data-target='#collapse-{$row_index}' 
                        aria-expanded='true' aria-controls='collapse-{$row_index}'
                        >
                            {$clinical_trial->post_title}
                        </button>
                    </h2>
                </div>
        
                <div 
                id='collapse-{$row_index}' 
                class='collapse show' 
                aria-labelledby='heading-{$row_index}' 
                data-parent='#accordionExample'
                >
                    <div class='card-body'>
                        {$clinical_trial->post_content}
                    </div>
                </div>
            </div>
        ";
    }
    echo "
    <div>
        {$accordion_content}
    </div>
    ";
} else {
    echo "no open trials";
}
if (!empty($trials_closed_for_enrollment)) {
    $accordion_content = "";
    foreach ($trials_closed_for_enrollment as $row_index=>$clinical_trial) {

        $fold_title = get_sub_field( 'title' );
        $fold_content = get_sub_field( 'content' );
        $accordion_content = "
            <div class='card'>
                <div class='card-header' id='heading-{$row_index}'>
                    <h2 class='mb-0'>
                        <button 
                        class='btn btn-link btn-block text-left' 
                        type='button' 
                        data-toggle='collapse' 
                        data-target='#collapse-{$row_index}' 
                        aria-expanded='true' aria-controls='collapse-{$row_index}'
                        >
                            {$clinical_trial->post_title}
                        </button>
                    </h2>
                </div>
        
                <div 
                id='collapse-{$row_index}' 
                class='collapse show' 
                aria-labelledby='heading-{$row_index}' 
                data-parent='#accordionExample'
                >
                    <div class='card-body'>
                        {$clinical_trial->post_content}
                    </div>
                </div>
            </div>
        ";
    }
    echo "
    <div>
    <h2>Closed</h2>
        {$accordion_content}
    </div>
    ";
} else {
    echo "no closed trials";
}
