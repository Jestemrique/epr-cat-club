<?php

//   //Log information in browser's console.
//   function debug_to_console($data) {
//     $output = $data;
//     if ( is_array($output) )
//         $output = implode(',', $output);
//     echo "hola";
//     //echo "<script>console.log('Debug Objects:-> " . $output . "' );</script>";
//   }//End debug_to_console()

//   //Log information rendered in html
//   function debug_to_html($data) {
//     $output = $data;
//     if ( is_array($output) )
//         $output = implode(',', $output);
//     echo $output;
//   }//End debug_to_html()


//********************************************************* */

//debug_to_console("hola");


function my_epr_menu() {
    add_menu_page( 
            'My EPR Title', 
            'My EPR Menu',
            'edit_posts', 
            'epr-sample-page', 
            'my_epr_page_contents', 
            'dashicons-menu',
            3
        );
};

add_action('admin_menu', 'my_epr_menu');

function my_epr_page_contents() {
    //debug_to_html("hola");

    ?>
			<h1><?php esc_html_e( 'Welcome to my custom admin page.', 'my-plugin-textdomain' ); ?></h1>
	<?php
}


//****** */
//Apply styles.
function register_my_plugin_scripts() {
    wp_register_style( 'my-epr-plugin', plugins_url( 'styles/epr-admin-styles.css', __FILE__ ) );
    //wp_register_script( 'my-plugin', plugins_url( 'ddd/js/plugin.js' ) );
};

add_action( 'admin_enqueue_scripts', 'register_my_plugin_scripts' );

function load_my_plugin_scripts( $hook ) {
    //echo '<h1 style="color: crimson;">' . esc_html( $hook ) . '</h1>';
    // Load only on ?page=sample-page
    if( $hook != 'toplevel_page_epr-sample-page' ) {
        return;
    };
    //echo '<h1 style="color: crimson;">' . esc_html( $hook ) . ' AFTER </h1>';
    // Load style & scripts.
    wp_enqueue_style( 'my-epr-plugin' );
    //wp_enqueue_script( 'my-plugin' );
};

add_action( 'admin_enqueue_scripts', 'load_my_plugin_scripts');







