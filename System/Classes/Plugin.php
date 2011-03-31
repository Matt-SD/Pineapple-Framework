<?php

defined("PINEAPPLE") or die("Do not access this file directly.");

class Plugin {

  function __construct($pluginsClass, $app, $pluginName) {
    $this->plugins = $pluginsClass;
    $this->app = $app;
    $this->pluginName = $pluginName;
  }

}
