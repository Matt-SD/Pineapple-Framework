<?php

class Site_Controller extends Controller {

  function install() {
    $this->app->writeConfig("Site", array(
      "indexNode" => "home-page"
    ));
  }

  function action_index() {
    /*
     * Load the Node module & the home-page config value
     */
    $nodeModule = $this->app->module("Node");
    $homePage = $this->app->config("Site", "indexNode");
    
    /*
     * run Node's action_fallback()
     */
    $nodeModule->action_fallback($homePage);
  }
  
  /*
   * More of a placeholder action than anything else, since its content is in the View file.
   */
  function action_404() {
    $this->view->set("PageTitle", "Error 404");
    $this->view->render();
  }

}
