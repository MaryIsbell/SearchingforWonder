<?php
/**
 * ACF related functions and definitions
 *
 * @package Wondercat
 **/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * 
 * tie taxonomy to form field
 * 
 **/
// NOTE: update the '1' to the ID of your form
add_filter( 'gform_pre_render_1', 'cat_tech_update_populate_type' );
add_filter( 'gform_pre_validation_1', 'cat_tech_update_populate_type' );
add_filter( 'gform_pre_submission_filter_1', 'cat_tech_update_populate_type' );
add_filter( 'gform_admin_pre_render_1', 'cat_tech_update_populate_type' );
function cat_tech_update_populate_type( $form ) {
  
    foreach( $form['fields'] as &$field )  {
  
        //NOTE: replace 5 with your checkbox field id
        $field_id = 5;
        //NOTE: replace 'technology' with your custom taxonomy name
        $custom_taxonomy = 'technology';
        if ( $field->id != $field_id ) {
            continue;
        }
  
        $terms = get_terms( array(
                'taxonomy' =>  $custom_taxonomy,
                'hide_empty' => false,
                'orderby'   =>'title',
                'order'   =>'ASC',
            ) ); 
        $input_id = 1;
        foreach( $terms as $term ) {
            
            // Check if 'in_glossary' meta value is 'yes'
            $in_glossary = get_term_meta( $term->term_id, 'in_glossary', true );
            if ( strtolower($in_glossary) !== 'yes' ) {
                continue;
            }
  
            //skipping index that are multiples of 10 (multiples of 10 create problems as the input IDs)
            if ( $input_id % 10 == 0 ) {
                $input_id++;
            }
  
            $choices[] = array( 'text' => $term->name, 'value' => $term->name);
            $inputs[] = array( 'label' => $term->name, 'id' => "{$field_id}.{$input_id}");
  
            $input_id++;
        }
        array_push($field->choices,"i-want-to-propose-a-new-term","i-need-help-deciding");
        
  
        $field->choices = $choices;
        $field->inputs = $inputs;
  
    }
  
    return $form;
}
// NOTE: update the '1' to the ID of your form
add_filter( 'gform_pre_render_1', 'cat_tech_update_populate_type_experience' );
add_filter( 'gform_pre_validation_1', 'cat_tech_update_populate_type_experience' );
add_filter( 'gform_pre_submission_filter_1', 'cat_tech_update_populate_type_experience' );
add_filter( 'gform_admin_pre_render_1', 'cat_tech_update_populate_type_experience' );
function cat_tech_update_populate_type_experience( $form ) {
  
    foreach( $form['fields'] as &$field )  {
  
        //NOTE: replace 5 with your checkbox field id
        $field_id = 4;
        //NOTE: replace 'technology' with your custom taxonomy name
        $custom_taxonomy = 'experience';
        if ( $field->id != $field_id ) {
            continue;
        }
  
        $terms = get_terms( array(
                'taxonomy' =>  $custom_taxonomy,
                'hide_empty' => false,
                'orderby'   =>'title',
                'order'   =>'ASC',
            ) ); 
        $input_id = 1;
        foreach( $terms as $term ) {
  
            // Check if 'in_glossary' meta value is 'yes'
            $in_glossary = get_term_meta( $term->term_id, 'in_glossary', true );
            if ( strtolower($in_glossary) !== 'yes' ) {
                continue;
            }

            //skipping index that are multiples of 10 (multiples of 10 create problems as the input IDs)
            if ( $input_id % 10 == 0 ) {
                $input_id++;
            }
  
            $choices[] = array( 'text' => $term->name, 'value' => $term->name);
            $inputs[] = array( 'label' => $term->name, 'id' => "{$field_id}.{$input_id}");
  
            $input_id++;
        }
  array_push($field->choices,"i-want-to-propose-a-new-term","i-need-help-deciding");
        $field->choices = $choices;
        $field->inputs = $inputs;
  
    }
  
    return $form;
}


//save acf json
add_filter('acf/settings/save_json', 'wondercat_json_save_point');
 
function wondercat_json_save_point( $path ) {
    
    // update path
    $path = get_stylesheet_directory(__FILE__) . '/acf-json'; //replace w get_stylesheet_directory() for theme	    
    
    // return
    return $path;
    
}


// load acf json
add_filter('acf/settings/load_json', 'wondercat_json_load_point');

function wondercat_json_load_point( $paths ) {
    
    // remove original path (optional)
    unset($paths[0]);
    
    
    // append path
    $paths[] = get_stylesheet_directory(__FILE__)  . '/acf-json';//replace w get_stylesheet_directory() for theme
    
    
    // return
    return $paths;
    
}
