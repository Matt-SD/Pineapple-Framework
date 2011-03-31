<?php

defined("PINEAPPLE") or die("Do not access this file directly.");

class URL {

  function __construct($app) {
    $this->app = $app;
    
    /*
     * Raw URL string
     */
    $this->raw = isset($_GET['url']) ? $_GET['url'] : 'site/index';
    
    /*
     * URL as a filtered array (no empty values)
     */
    $urlArray = explode("/", $this->raw);
    foreach($urlArray as $key => $value) {
      if(is_null($value) || $value == "") {
        unset($urlArray[$key]);
      }
    }
    
    if(!isset($urlArray[1])) {
      $urlArray[1] = 'index';
    }
    
    $this->array = $urlArray;
    
    /*
     * Module name & action name
     */
    list($this->module, $this->action) = array_slice($urlArray, 0, 2);
    
    /*
     * The Query array
     */
    $this->query = (count($urlArray) > 2) ? array_slice($urlArray, 2) : array();
  }

}
