<?php

defined("PINEAPPLE") or die("Do not access this file directly.");

class Template {

  function __construct($app) {
    /*
     * Set some variables
     */
    $this->app = $app;
    
    $this->config = $this->app->config("Pineapple");
    $this->name = $this->config['template'];
    
    $this->directory = $this->config['location'] . "/Templates/{$this->name}";
  }

}
