<?php

require_once "../config/dbCredentials.php";

class connectionClass {
    private $connection;
    
    function __construct()
    {
        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
        
        if(!$this->connection) {
            die('error connecting to database: '.mysqli_connect_error()); 
        } else {
            echo('connected successfull');
        
            // show the MySQL o MariaDB version
            printf("server MySQL: %s\n", mysqli_get_server_info($this->connection));
            
            mysqli_close($this->connection);
        }
    } // end construct
} // end class
