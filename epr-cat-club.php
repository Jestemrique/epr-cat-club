<?php
/*
Plugin name: Cat club plugin
Plugin URI: https://jestemrique.net
Description: Plugin para un club de gatos
Version: 1.0
Author: Enrique
Author URI: https:/www.jestemrique.net
License: GPLv2
*/

include_once('helpers/epr-helpers.php');
include_once('epr-admin-page.php');
include_once('epr-hide-admin-menus.php');


$epr_helper = new Helpers\epr_helper();
//$epr_helper->debug_to_console(' tipi hola');
//$epr_helper->debug_to_html(' tipi hola');



function epr_register_post_type() {


    $labels = array (
        'name' => 'Cats',
        'singular_name' => 'Cat',
        'add_new' => 'New Cat',
        'add_new_item' => 'Add New Cat',
        'edit_item' => 'Edit Cat',
        'new_item' => 'New Cat',
        'view_item' => 'View Cats',
        'search_items' => 'Search Cats',
        'not_found' => 'No Cats Found',
        'not_found_in_trash' => 'No Cats found in Trash'
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        //'supports' => false,
        'supports' => array(
            'title',
            //'editor',
            //'excerpt',
            //'custom-fields',
            //'thumbnail',
            //'page-attributes'
        ),
        'taxonomies' => array('category'),
        'rewrite' => array('slug' => 'cat'),
        'show_in_rest' => true
    );

    register_post_type('epr_cat', $args);

};

//Register the post type
add_action('init', 'epr_register_post_type');


//Adding custom metaboxes
function epr_cat_add_meta_boxes($post) {
    add_meta_box('epr_cat_meta_box', 'Cat Info.', 'epr_cat_build_meta_box', 'epr_cat', 'normal', 'default');
};

add_action( 'add_meta_boxes', 'epr_cat_add_meta_boxes');

function epr_cat_build_meta_box( $post ){
    // make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'epr_cat_meta_box_nonce' );

    //Cat's name
    $cat_name = get_post_meta( $post->ID, '_cat_name', true);
    //echo 'hola: ' . $post->ID;
    ?>
    <div>
    <h3>Name</h3>
        <p>
            <input type="text" name="cat_name" value="<?php echo $cat_name; ?>" /> 
        </p>
    </div>

    <?php $cat_sex = get_post_meta( $post->ID, '_cat_sex', true); ?>
    <div>
    <h3>Sex</h3>
        <p>
            <input type="radio" name="cat_sex" value="male" <?php checked( 'male', $cat_sex); ?> /> Male<br />
	        <input type="radio" name="cat_sex" value="female" <?php checked( 'female', $cat_sex ); ?> /> Female
        </p>
    </div>

    <?php $cat_birth_date = get_post_meta( $post->ID, '_cat_birth_date', true); ?>
    <div>
    <h3>Birth Date</h3>
        <p>
            <input type="date" name="cat_birth_date" value="<?php echo $cat_birth_date; ?>" /> 
        </p>
    </div>

    <?php $cat_color = get_post_meta( $post->ID, '_cat_color', true); ?>
    <div>
    <h3>Colour</h3>
        <p>
            <input type="text" name="cat_color" value="<?php echo $cat_color; ?>" /> 
        </p>
    </div>

    <?php $cat_sterilized = get_post_meta( $post->ID, '_cat_sterilized', true); ?>
    <div>
    <h3>Sterilized</h3>
        <p>
            <input type="radio" name="cat_sterilized" value="no" <?php checked( 'no', $cat_sterilized ); ?> /> No<br />
	        <input type="radio" name="cat_sterilized" value="yes" <?php checked( 'yes', $cat_sterilized); ?> /> Yes
        </p>
    </div>

    <?php $cat_picture = get_post_meta( $post->ID, '_cat_picture', true); ?>
    <div>
    <h3>Picture</h3>
        <p>
            <input type="text" name="cat_picture" value="<?php echo $cat_picture; ?>" /> 
        </p>
    </div>

    <?php $cat_observations = get_post_meta( $post->ID, '_cat_observations', true); ?>
    <div>
    <h3>Observations</h3>
        <p>
            <textarea name="cat_observations"  cols="80" rows="15" ><?php echo $cat_observations; ?></textarea>
        </p>
    </div>

    <?php

};

function epr_cat_save_meta_box_data( $post_id ) {
    // verify taxonomies meta box nonce
	if ( !isset( $_POST['epr_cat_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['epr_cat_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	};

    // return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	};

    // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	};

    // store custom fields values
    // $cat_name
    if ( isset( $_REQUEST['cat_name'] ) ) {
		update_post_meta( $post_id, '_cat_name', sanitize_text_field( $_POST['cat_name'] ) );
	};

    // store custom fields values
    // $cat_sex
    if ( isset( $_REQUEST['cat_sex'] ) ) {
		update_post_meta( $post_id, '_cat_sex', sanitize_text_field( $_POST['cat_sex'] ) );
	};

    // store custom fields values
    //$cat_birth_date
    if ( isset( $_REQUEST['cat_birth_date'] ) ) {
        update_post_meta( $post_id, '_cat_birth_date', sanitize_text_field( $_POST['cat_birth_date'] ) );
    };

    // store custom fields values
    //$cat_color
    if ( isset( $_REQUEST['cat_color'] ) ) {
        update_post_meta( $post_id, '_cat_color', sanitize_text_field( $_POST['cat_color'] ) );
    };

    // store custom fields values
    //$cat_sterilized
    if ( isset( $_REQUEST['cat_sterilized'] ) ) {
        update_post_meta( $post_id, '_cat_sterilized', sanitize_text_field( $_POST['cat_sterilized'] ) );
    };

    // store custom fields values
    //$cat_picture
    if ( isset( $_REQUEST['cat_picture'] ) ) {
        update_post_meta( $post_id, '_cat_picture', sanitize_text_field( $_POST['cat_picture'] ) );
    };

    // store custom fields values
    //$cat_observations
    if ( isset( $_REQUEST['cat_observations'] ) ) {
        update_post_meta( $post_id, '_cat_observations', sanitize_text_field( $_POST['cat_observations'] ) );
    };




};

add_action( 'save_post_epr_cat', 'epr_cat_save_meta_box_data' );





