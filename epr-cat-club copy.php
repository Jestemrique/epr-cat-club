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
        'supports' => false,
        // 'supports' => array(
        //     'title',
        //     'editor',
        //     'excerpt',
        //     'custom-fields',
        //     'thumbnail',
        //     'page-attributes'
        // ),
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
    //add_meta_box('epr_cat_meta_box', 'Cats box', 'epr_cat_build_meta_box', 'epr_cat', 'side', 'low');
    add_meta_box('epr_cat_meta_box', 'Cats box', 'epr_cat_build_meta_box', 'epr_cat', 'normal', 'default');
};

add_action( 'add_meta_boxes', 'epr_cat_add_meta_boxes');

function epr_cat_build_meta_box( $post ){
    // make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'epr_cat_meta_box_nonce' );

    //$cat_name = get_post_meta( $post->ID, '_epr_cat_name', true);
    $cat_name = get_post_meta( $post->ID, '_cat_name', true);
    echo 'hola: ' . $post->ID;
    ?>
    <div>
    <h3>CAT's Name</h3>
        <p>
            <input type="text" name="cat_name" value="<?php echo $cat_name; ?>" /> 
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
	// cholesterol string
	// if ( isset( $_REQUEST['name'] ) ) {
	// 	update_post_meta( $post_id, '_epr_cat_name', sanitize_text_field( $_POST['name'] ) );
	// };
    if ( isset( $_REQUEST['cat_name'] ) ) {
		update_post_meta( $post_id, '_cat_name', sanitize_text_field( $_POST['cat_name'] ) );
	};
};

add_action( 'save_post_epr_cat', 'epr_cat_save_meta_box_data' );





