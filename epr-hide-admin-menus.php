<?php
// function debugToConsole($msg) { 
//     echo "<script>console.log(".json_encode($msg).")</script>";
// };





function epr_remove_menu_pages() {
    //global $user_ID;
    $user = wp_get_current_user();

//    debugToConsole($user);
    if (in_array('author', (array) $user->roles)){
        remove_menu_page( 'edit.php?post_type=page' );
        remove_menu_page( 'edit-comments.php' );
        remove_menu_page( 'themes.php' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'index.php' );
        remove_menu_page( 'edit.php' );

    };
}//end epr_remove_menu_page()

add_action( 'admin_init', 'epr_remove_menu_pages' );



