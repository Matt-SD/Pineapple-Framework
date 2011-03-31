<?php

/*
 * THIS IS PURELY A TEST PLUGIN.
 */

class Test_Plugin {

  public function hook_chicken() {
    /*
     * Return the arguments given to us or if there were none, just fart.
     */
    if(count(func_get_args())) {
      print_r(func_get_args());
    } else {
      echo "* fart noise *";
    }
  }
  
  public function filter_turkey($text) {
    /*
     * Add "PENIS" to the text given & return it.
     */
    $text = $text . " <strong>PENIS</strong>";
    return $text;
  }
  
  public function ostrich() {
    /*
     * This is a function that can be directly accessed.
     */
    echo "I'm an Ostrich! I go MOOOOOO!";
  }
  
  private function camelHump() {
    /*
     * This function can only be accessed from within this plugin itself.
     */
    echo "Na na n-na na!";
  }

}
