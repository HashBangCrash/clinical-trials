<?php
/*
Plugin Name: Clinical Trials Custom Post Type
Description: Provides a Custom Post Type for Clinical Trials, to be used in the Nursing website
Version: 1.0.0
Plugin URI: https://github.com/hashbangcrash/clinical-trials
Github Plugin URI: hashbangcrash/clinical-trials-cpt
*/

namespace clinical_trials_cpt;

if ( ! defined( 'WPINC' ) ) {
    die;
}

include plugin_dir_path( __FILE__ ) . 'includes/acf-pro-fields.php';
//include plugin_dir_path( __FILE__ ) . 'includes/block.php';
include plugin_dir_path( __FILE__ ) . 'includes/post-type.php';

// plugin css/js
add_action( 'enqueue_block_assets', __NAMESPACE__ . '\\add_css' );
add_action( 'enqueue_block_assets', __NAMESPACE__ . '\\add_js' );

// use parent theme styles without overwriting them
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_parent_styles' );

// add bootstrap to create the js and css for accordions
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_bootstrap' );


function enqueue_bootstrap(): void
{
    wp_enqueue_style('bootstrap-styles', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-styles', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css');
    wp_enqueue_script( 'bootstrap-scripts','https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), '', true );
}


function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}


function add_css(): void
{

}

function add_js(): void
{

}

// plugin activation hooks
register_activation_hook( __FILE__, __NAMESPACE__ . '\\activation' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivation' );
register_uninstall_hook( __FILE__, __NAMESPACE__ . '\\deactivation' );


// run on plugin activation
function activation(): void
{

}

// run on plugin deactivation
function deactivation(): void
{

}

// run on plugin complete uninstall
function uninstall(): void
{

}



