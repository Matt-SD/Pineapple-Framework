<?php

class View {

  protected $variables;

  function __construct($app, $module, $action) {
    /*
     * Set some variables
     */
    $this->app = $app;
    $this->module = $module;
    $this->action = $action;
    $this->set("pageTitle", null);
    $this->set("contentTitle", null);
    
    /*
     * Create an instance of the Template class
     */
    $this->template = new Template($app);
    
    /*
     * Add some system variables to $variables
     */
    $this->set("system", $this->app->config("Pineapple"));
  }
  
  function set($name, $value) {
    /*
     * Set a variable for the view file
     */
    $this->variables[$name] = $value;
  }
  
  function render($file = null) {
    extract($this->variables);
    
    /*
     * Load the template layout file or throw an error if it doesn't exist.
     */
    $templateFile = "Templates/{$this->template->name}/Layout.php";
    if(file_exists($templateFile)) {
      include($templateFile);
      
    } else {
      trigger_error("PINEAPPLE ERROR: No layout file in theme \"{$this->template->name}\".", E_USER_ERROR);
      
    }
  }
  
  function view() {
    extract($this->variables);
  
    /*
     * Action files are appended to these array values
     */
    $locationArray = array(
      "Templates/{$this->template->name}/Views/{$this->module}.",
      "Modules/{$this->module}/Views/"
    );
    
    /*
     * Load either the action file, or the fallback & output it.
     */
    foreach($locationArray as $filePath) {
      $fileFound = false;
      
      ob_start();
      
      // Work out which file to load
      if(file_exists($filePath . $this->action . ".php")) {
        include($filePath . $this->action . ".php");
        
        $fileFound = true;
        
      } else if(file_exists($filePath . "fallback.php")) {
        include($filePath . "fallback.php");
        
        $fileFound = true;
      }
      
      // Output its contents
      echo ob_get_clean();
      
      if($fileFound) {
        break;
        
      }
    }
  }

}
