<?php

class Node_Controller extends Controller {

  function install() {
    $this->app->plugins->DB->query("CREATE TABLE IF NOT EXISTS `node`
      (`ID` int(11) NOT NULL AUTO_INCREMENT,
       `title` varchar(255) NOT NULL,
       `slug` varchar(255) NOT NULL,
       `content` text NOT NULL,
       `c-timestamp` varchar(25) NOT NULL,
       `m-timestamp` varchar(25) DEFAULT NULL, 
       PRIMARY KEY (`ID`),
       UNIQUE KEY `slug` (`slug`))
      ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;");
    
    $this->app->plugins->DB->query("INSERT INTO `node`
      (`ID`, `title`, `slug`, `content`, `c-timestamp`, `m-timestamp`)
      VALUES (1, 'Home Page', 'home-page', '<p>Welcome to your new Pineapple installation!</p>', '1301677771', NULL);");
  }
  
  function action_fallback($pageSlug) {
  
    $pageQuery = $this->app->plugins->DB->query("SELECT * FROM `node` WHERE `slug`='%s'", $pageSlug);
    $page = mysql_fetch_array($pageQuery);
    
    foreach($page as $key => $value) {
      $this->view->set($key, $value);
    }
    
    $this->view->render();
  }

}
