<?php

class Site_Controller extends Controller {

  function action_index() {
    $queryResult = $this->app->plugins->DB->query("SELECT * FROM `test` WHERE `name`='%s'", "TEST");
    $pageContent = mysql_fetch_array($queryResult);
    $this->view->set("contentTitle", $pageContent['name']);
    $this->view->set("content", $pageContent['content']);
    
    $this->view->render();
  }
  
  /*
   * More of a placeholder action than anything else, since its content is in the View file.
   */
  function action_404() {
    $this->set("PageTitle", "Error 404");
    $this->view->render();
  }

}
