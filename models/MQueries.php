<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 2/26/15
 * Time: 12:36
 */
/**
 * Model for db sql handling
 */
class MQueries extends DBConnect
{
    /**
     * Method for execute query and get result
     * @param string $sql Sql string for selecting
     */
    public static function selectQuery($sql, $first = false) 
    {
        $query = false;

        // check if query is select
        if(!empty($sql) && stripos($sql, 'select') !== false)
        {
            // exec query
            $query = mysqli_query(DBConnect::getConnection(), $sql);
        }
        
        // check the result of query
        if(!$query)
        { 
            
          // print error if select has error
          echo "<p>Error in select query</p>";
          exit();   
        }   
        
        // init variable by default
        $result = array();
        
        // get result
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
        {
            // check if data exist
            if(!empty($row))
            {
                // push to array row data
                $result[] = $row;

                // break if need just first element
                if($first) {
                    $result =  $result[0];
                    break;
                }
            }
        }

        // set free result for mysql
        mysqli_free_result($query);
        
        // close connection of DB
        DBConnect::close_connect();
        
        // close connection of DB
        return $result;
    }
    
    /**
     * Insert into table
     * @param string $table Name of table
     * @param array $data  Data for inserting
     */
    public static function insertQuery($table, $data=array()) 
    {
        
        if(!empty($table) && !empty($data) && is_array($data)) {

            $insert = CustomFunctions::ImplodeInsert($table, $data);
            
            $result = mysqli_query(DBConnect::getConnection(),$insert);
            
            // close connection of DB
            DBConnect::close_connect();

            // close connection of DB
            return $result;
        }
        
        return false;
    }
    
    public static function updateQuery($table, $data=array(), $byAttr=array()) {
        if(!empty($table) && !empty($data) && is_array($data)) {
            
            $update = CustomFunctions::generateUpdate($table, $data, $byAttr);
            $result = mysqli_query(DBConnect::getConnection(), $update);
            
            // close connection of DB
            DBConnect::close_connect();

            // close connection of DB
            return $result;            
        }
        
        return false;
    }
    
    public static function deleteQuery($table, $condition) {
        if(!empty($table) && !empty($condition) && is_string($condition)) {
            
            $result = mysqli_query(DBConnect::getConnection(), 'delete from '.$table.' where '.$condition);
            
            // close connection of DB
            DBConnect::close_connect();

            // close connection of DB
            return $result;            
        }
        
        return false;
    }
}