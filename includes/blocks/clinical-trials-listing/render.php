<?php
namespace clinical_trials_cpt\render;

// get all posts that are open for enrollment

use const clinical_trials_cpt\post_type\custom_taxonomy;

$meta_query_open = array(
    // limit to trials that are either marked as open, or are marked with a date range encompassing today's date
    array(
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
);

$meta_query_opening_soon = array(
	// limit to trials that are either marked as opening soon, or are marked with a date range in the future of today's date
	array(
		'relation'		=> 'OR',
		array(
			'key'		=> 'enrollment_status',
			'compare'	=> '=',
			'value'		=> 'opening_soon'
		),
		array(
			'key'		=> 'enrollment_start_date',
			'compare'	=> '>',
			'value'		=> date('Y-m-d'),
			'type'      => 'DATE'
		),
	)
);

$meta_query_closed = array(
    // limit to trials that are either marked as closed, or are marked with a date range past today's date
    array(
        'relation'		=> 'OR',
        array(
            'key'		=> 'enrollment_status',
            'compare'	=> '=',
            'value'		=> 'closed'
        ),
        array(
            'key'		=> 'enrollment_last_date',
            'compare'	=> '<',
            'value'		=> date('Y-m-d'),
            'type'      => 'DATE'
        ),
    )
);

$main_query_open = array(
    'post_type'      => 'clinical-trials',
    'posts_per_page' => -1,
    'meta_query' => $meta_query_open,
);
$main_query_opening_soon = array(
    'post_type'      => 'clinical-trials',
    'posts_per_page' => -1,
    'meta_query' => $meta_query_opening_soon,
);

$main_query_closed = array(
	'post_type'      => 'clinical-trials',
	'posts_per_page' => -1,
	'meta_query' => $meta_query_closed,
);

// if block is filtering to specific posts by categories, then add
// a condition to the meta query to only get those posts
if (get_field('limit_trials_listing_to_specified_categories') && get_field('include_specified_categories')) {
    $tax_query = array(
        array(
            'taxonomy' => custom_taxonomy,
            'terms' => get_field('include_specified_categories'),
        )
    );
    $main_query_open['tax_query'] = $tax_query;
	$main_query_opening_soon['tax_query'] = $tax_query;
	$main_query_closed['tax_query'] = $tax_query;
}
$query = new \WP_Query();
// get all posts that are open for enrollment
$trials_open_for_enrollment = $query->query($main_query_open);
/* @var $trials_open_for_enrollment WP_Post[] */

$query = new \WP_Query();
// get all posts that are opening soon for enrollment
$trials_opening_soon_for_enrollment = $query->query($main_query_opening_soon);
/* @var $trials_opening_soon_for_enrollment WP_Post[] */

$query = new \WP_Query();
// get all posts that are not open for enrollment
$trials_closed_for_enrollment = $query->query($main_query_closed);
/* @var $trials_closed_for_enrollment WP_Post[] */



function generate_accordion($trials, $button_type, $class_type, $h2 ) {
	$accordion_content = "";
	foreach ($trials as $row_index=>$clinical_trial) {
		$accordion_content .= "
            <div class='card mb-4'>
                <div class='card-success' id='heading-{$class_type}-{$row_index}'>
                    <h2 class='mb-0'>
                        <button 
                        class='btn btn-{$button_type} btn-block text-left dropdown-toggle' 
                        type='button' 
                        data-toggle='collapse' 
                        data-target='#collapse-{$class_type}-{$row_index}' 
                        aria-expanded='true' aria-controls='collapse-{$class_type}-{$row_index}'
                        >
                            {$clinical_trial->post_title}
                        </button>
                    </h2>
                </div>
        
                <div 
                id='collapse-{$class_type}-{$row_index}' 
                class='collapse' 
                aria-labelledby='heading-{$class_type}-{$row_index}' 
                data-parent='#accordion-trials-{$class_type}'
                >
                    <div class='card-body p-2'>
                        {$clinical_trial->post_content}
                    </div>
                </div>
            </div>
        ";
	}
	return "
    <div class='clinical-trials-listing clinical-trials-{$class_type} clinical-trials-body mt-4 mb-4' id='accordion-trials-{$class_type}'>
    <h2>{$h2}</h2>
        {$accordion_content}
    </div>
    ";
}

/**
 * Print out all the trials in acordions in the appropriate secions
 */

$h2_open = "Trials Open For Enrollment";
if (!empty($trials_open_for_enrollment)) {
	echo generate_accordion($trials_open_for_enrollment, 'success', 'open', $h2_open);
} else {
	echo "<div class='clinical-trials-listing clinical-trials-open clinical-trials-body mt-4 mb-4'>
    <h2>{$h2_open}</h2>
    No trials open for enrollment.
    </div>";
}

$h2_opening = "Trials Opening Soon For Enrollment";
if (!empty($trials_opening_soon_for_enrollment)) {
	echo generate_accordion($trials_opening_soon_for_enrollment, 'info','opening-soon', $h2_opening);
} else {
	echo "<div class='clinical-trials-listing clinical-trials-opening-soon clinical-trials-body mt-4 mb-4'>
    <h2>{$h2_opening}</h2>
    No trials opening soon.
    </div>";
}

$h2_closed = "Trials Closed For Enrollment";
if (!empty($trials_closed_for_enrollment)) {
	echo generate_accordion($trials_closed_for_enrollment, 'warning', 'closed', $h2_closed);
} else {
	echo "<div class='clinical-trials-listing clinical-trials-closed clinical-trials-body mt-4 mb-4'>
    <h2>{$h2_closed}</h2>
    No trials closed for enrollment.
    </div>";
}
