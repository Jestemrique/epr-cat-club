<?php

//Helpers
namespace Helpers;

class epr_helper {



  //Log information in browser's console.
  public function debug_to_console($data) {
    $output = $data;
    if ( is_array($output) )
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects:-> " . $output . "' );</script>";
  }//End debug_to_console()

  //Log information rendered in html
  public function debug_to_html($data) {
    $output = $data;
    if ( is_array($output) ){
        $output = implode(',', $output);
    }
    echo $output;
  }//End debug_to_html()



}//End epr_helper




