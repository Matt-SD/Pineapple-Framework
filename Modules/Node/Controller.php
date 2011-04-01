<?php

class Node_Controller extends Controller {
  
  function action_fallback($pageSlug) {
  
    $pageQuery = $this->app->plugins->DB->query("SELECT * FROM `Node` WHERE `slug`='%s'", $pageSlug);
    $page = mysql_fetch_array($pageQuery);
    
    foreach($page as $key => $value) {
      $this->view->set($key, $value);
    }
    
    $this->view->render();
  }

}
