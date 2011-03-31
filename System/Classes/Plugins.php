<?php

defined("PINEAPPLE") or die("Do not access this file directly.");

class Plugins {

  function __construct($app) {
    /*
     * Set some variables
     */
    $this->app = $app;
    $this->methods = new stdClass;
    
    /*
     * Load plugin files & instances
     */
    $pluginFiles = scandir("Plugins/");
    
    foreach($pluginFiles as $pluginFile) {
      if(($pluginFile == "." || $pluginFile == "..") == false) {
        if(is_dir("Plugins/{$pluginFile}")) {
          // Since plugins can be in a directory, we need to load the plugin file within
          include("Plugins/{$pluginFile}/Plugin.{$pluginFile}.php");
          
        } else {
          // If it's just a file, then it's just a file
          include("Plugins/{$pluginFile}");
          
        }
        
        /*
         * Plugin name & class name
         */
        $pluginName = basename($pluginFile, ".php");
        $pluginClass = $pluginName . "_Plugin";
        
        /*
         * Instantiate the class & get its methods, if the class doesn't exist, throw an error.
         */
        if(class_exists($pluginClass)) {
          $this->{$pluginName} = new $pluginClass($this, $this->app, $pluginName);
          $this->methods->{$pluginName} = get_class_methods($pluginClass);
        } else {
          trigger_error("Plugin file {$pluginFile} does not contain class name {$pluginClass}.");
        }
      }
    }
  }
  
  function hook() {
    $args = func_get_args();
    
    if(count($args) < 1) {
      /*
       * If no hook name (the first arg) then we must destroy the world
       */
      trigger_error("PINEAPPLE ERROR: In order to run a hook, a name for the hook must be supplied.", E_USER_ERROR);
    }
    
    /*
     * Get the hook name, & remove it from the $args
     */
    $hookName = "hook_" . $args[0];
    array_shift($args);
    
    /*
     * Workout which files have the correct hook & run it if they do
     */
    foreach($this->methods as $pluginName => $pluginMethods) {
      $pluginMethodNames = array_flip($pluginMethods);
      
      if(isset($pluginMethodNames[$hookName])) {
        call_user_func_array(array($this->{$pluginName}, $hookName), $args);
      }
    }
  }
  
  function filter() {
    $args = func_get_args();
    
    if(count($args) < 1) {
      /*
       * If no filter name (the first arg) then we must destroy the world
       */
      trigger_error("PINEAPPLE ERROR: In order to run a hook, a name for the hook must be supplied.", E_USER_ERROR);
    }
    
    /*
     * Get the hook name, & remove it from the $args
     */
    $hookName = "filter_" . $args[0];
    array_shift($args);
    
    /*
     * Workout which files have the correct hook & run it if they do
     */
    foreach($this->methods as $pluginName => $pluginMethods) {
      $pluginMethodNames = array_flip($pluginMethods);
      
      if(isset($pluginMethodNames[$hookName])) {
        $returnData = call_user_func_array(array($this->{$pluginName}, $hookName), $args);
      }
    }
    
    return $returnData;
  }
  
}
