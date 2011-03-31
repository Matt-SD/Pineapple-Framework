<?php

class DB_Plugin extends Plugin {

  protected $connection;
  
  private function connect() {
    $info = $this->app->config("DB");
    
    /*
     * Connect to the database server & validate the connection
     */
    $this->connection = mysql_connect($info['server'], $info['username'], $info['password']);
    if(!$this->connection) {
      trigger_error("PINEAPPLE ERROR: DB PLUGIN: Could not connect to the database server with the given information.", E_USER_ERROR);
      return false;
    }
    
    /*
     * Connect to the database itself & validate it
     */
     if(!mysql_select_db($info['name'], $this->connection)) {
       trigger_error("PINEAPPLE ERROR: DB PLUGIN: Could not select database. Database name ({$info['name']}) given does not exist.", E_USER_ERROR);
       return false;
     }
  }

  public function query() {
    $args = func_get_args();
    
    /*
     * Throw an error if no arguments are given
     */
    if(count($args) < 1) {
      trigger_error("PINEAPPLE ERROR: DB PLUGIN: Not enough arguments supplied to execute query.", E_USER_ERROR);
      return false;
    }
    
    /*
     * If there is no active connection, create one.
     */
    if(is_null($this->connection)) {
      $this->connect();
    }
    
    /*
     * Escape every argument value except the first one (the query)
     */
    foreach($args as $key => $value) {
      if($key > 0) {
        $args[$key] = mysql_real_escape_string($value, $this->connection);
      }
    }
    
    /*
     * Create a formatted SQL query string
     */
    $queryString = call_user_func_array("sprintf",$args);
    
    /*
     * Execute the query
     */
    $query = mysql_query($queryString, $this->connection);
    
    return $query;
  }

}
