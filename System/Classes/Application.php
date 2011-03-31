<?php

defined("PINEAPPLE") or die("Do not access this file directly.");

/*
 * This is the only static class. It is used for storing things (eg: class instances)
 */

class Application {

  protected $instances,
            $config;
  
  function __construct() {
    /*
     * Tell PHP to autoload class files using $this->autoload();
     */
    spl_autoload_register(array($this, "autoload"));
     
    /*
     * Load the config data
     */
    $configFiles = scandir("System/Config/");
      
    foreach($configFiles as $fileName) {
      if(($fileName == "." || $fileName == "..") == false) {
        $configContents = parse_ini_file("System/Config/{$fileName}");
        $configName = basename($fileName, ".ini");
        
        $this->config[$configName] = $configContents;
      }
    }
    
    /*
     * Load the Plugins & URL classes
     */
    $this->plugins = new Plugins($this);
    $this->url = new URL($this);
    
    /*
     * Dispatch to the right module
     */
    // Get the Module, Controller & Action names
    $moduleName = ucwords($this->url->module);
    $controllerName = $moduleName . "_Controller";
    $actionName = "action_" . $this->url->action;
    
    // Prepare the View class
    $this->view = new View($this, $moduleName, $this->url->action);
    
    // Load the Module & instantiate it
    include("Modules/{$moduleName}/Controller.php");
    $controller = new $controllerName($this, $moduleName, $this->url->action, $this->view);
    
    if(method_exists($controller, $actionName)) {
      // Run the action requested
      call_user_func_array(array($controller, $actionName), $this->url->query);
      
    } else if(method_exists($controller, "action_fallback")) {
      // Run the fallback action
      call_user_func_array(array($controller, "action_fallback"), $this->url->query);
      
    } else {
      // There's no action, so throw an error
      trigger_error("PINEAPPLE ERROR: No action could be executed.", E_USER_ERROR);
      
    }
  }
  
  function config() {
    $args = func_get_args();
    
    if(count($args) < 1) {
      trigger_error("PINEAPPLE ERROR: Can not retrieve configuration data. Not enough data given.", E_USER_ERROR);
      return false;
    }
    
    $config = $this->config;
    
    foreach($args as $key) {
      if(isset($config[$key])) {
        $config = $config[$key];
      } else {
        trigger_error("PINEAPPLE ERROR: Could not find key \"{$key}\" in configuration data.", E_USER_ERROR);
        return false;
      }
    }
    
    return $config;
  }
  
  function autoload($className) {
    /*
     * Get the file name
     */
    $fileName = $className . ".php";
    
    /*
     * Load the file, or throw an error
     */
    if(file_exists("System/Classes/{$fileName}")) {
      include("System/Classes/{$fileName}");
    } else {
      trigger_error("PINEAPPLE ERROR: Could not auto-load file for class name \"{$className}\".", E_USER_ERROR);
    }
  }

}
