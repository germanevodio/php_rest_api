<?php

require_once "../config/dbCredentials.php";

class connectionClass {
    protected $connection;
    
    public function __construct()
    {
        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
        
        if(!$this->connection) {
            die('error connecting to database: '.mysqli_connect_error()); 
        }
    } // end construct

    /**
     * Este método retorna la version de servidor MySQL o MariaDB
     * 
     * @return string
     */
    protected function serverVersion()
    {
        return mysqli_get_server_info($this->connection);
    } // end serverVersion
} // end class
