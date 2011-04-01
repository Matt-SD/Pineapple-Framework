<?php

defined("PINEAPPLE") or die("Do not access this file directly.");

class Controller {

  function __construct($app, $module, $action) {
    /*
     * This could be done in a foreach loop from func_get_args(), but it's not.
     */
    $this->app = $app;
    $this->module = $module;
    $this->action = $action;
    
    $this->view = new View($app, $module, $action);
  }

}
