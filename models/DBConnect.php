<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 2/26/15
 * Time: 12:35
 */
/**
 * Class for working with sql initializes
 */
class DBConnect {
    
    // resource with connector
    private static $connection;
    
    private static $DB_HOSTNAME;
    private static $DBUSER;
    private static $DBPASS;
    private static $DBNAME;
    
    public function __construct() {

        self::$DB_HOSTNAME = Config::getParam('db::DB_HOSTNAME');
        self::$DBUSER = Config::getParam('db::DBUSER');
        self::$DBPASS = Config::getParam('db::DBPASS');
        self::$DBNAME = Config::getParam('db::DBNAME');

        self::openConnect();
    }
    
    /**
     * Set connect session
     * @param resource $connection Resourse with connection
     */
    private static function setConnection($connection) {
        
        // init connector
        self::$connection = $connection;
    }
    
    /**
     * Get connect session
     * @return resource
     */
    public static function getConnection() {
        
        // if connect not exist
        if(empty(self::$connection)) {
            
            // open connect
            self::openConnect();
        }
        
        // return resource
        return self::$connection;
    }
    
    /**
     * Get connect session
     * @return resource
     */
    private static function openConnect() {     
        
        // init connect
        $dbcnx = mysqli_connect(self::$DB_HOSTNAME, self::$DBUSER, self::$DBPASS);
        
        // check if connect correct
        if (!$dbcnx)   
        {   
            
            // print error if server not available
            echo "<p>Unfortunately, not available mySQL server</p>";   
            exit();   
        }
        
        // check if db exist
        if (!mysqli_select_db($dbcnx, self::$DBNAME))
        {   
            // print error if db not available
            echo "<p>Unfortunately, no database available</p>";   
            exit();
        }
        
        // set connection
        self::setConnection($dbcnx);
        
        mysqli_query($dbcnx, 'SET names=utf8');
        mysqli_query($dbcnx, 'SET character_set_client=utf8');
        mysqli_query($dbcnx, 'SET character_set_connection=utf8');
        mysqli_query($dbcnx, 'SET character_set_results=utf8');
        mysqli_query($dbcnx, 'SET collation_connection=utf8_general_ci');
        mysqli_set_charset($dbcnx, 'utf8');
        
        return true;
    }
    
    public static function close_connect() {
        if(is_resource(self::getConnection())) {
            mysqli_close(self::getConnection());
            self::$connection = null;
        }
    }
}

// init DB conect
new DBConnect();