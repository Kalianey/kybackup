<?php

class Database
{
    const FETCH_NUM = PDO::FETCH_NUM;
    const FETCH_ASSOC = PDO::FETCH_ASSOC;
    const FETCH_CLASS = PDO::FETCH_CLASS;
    /** @var Database */
    static private $sharedInstance;
    
    /** @var PDO */
    private $db;
    
    static function sharedInstance()
    {
        if ( is_null(self::$sharedInstance))
        {
            self::$sharedInstance = new self();
        }
        return self::$sharedInstance;
    }
    
    function connect($host,$user,$pass,$dbname)
    {
        $this->db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=UTF8',$user,$pass);   
    }
    
    function query($sql,$params=null)
    {
        $res = $this->db->prepare($sql);
        if (is_array($params))
        {
            foreach($params as $key=>$value)
            {
                $res->bindValue(':'.$key, $value);
            }
        }
        $res->execute();
        if ($res->errorCode() != PDO::ERR_NONE)
        {
            print_r($res->errorInfo());
            return FALSE;
        }
        
        return $res;
    }
    
    function fetch(PDOStatement $result,$result_type = Database::FETCH_ASSOC, $className = "stdClass", $classArgs=null)
    {
        if ($result_type == self::FETCH_CLASS)
        {
            $row = $result->fetchObject($className, $classArgs);
        }
        else
        {
            $row = $result->fetch($result_type);
        }
        return $row;
    }
    
    function fetchAll(PDOStatement $result,$result_type = Database::FETCH_ASSOC, $className = "stdClass", $classArgs=null)
    {
        if ($result_type == self::FETCH_CLASS)
        {
            $rows = $result->fetchAll($result_type ,$className, $classArgs);
        }
        else
        {
            $rows = $result->fetchAll($result_type);
        }
        return $rows;
    }
    
    function count(PDOStatement $result)
    {
        return $result->rowCount();
    }
    
    function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
    
    function escape($string)
    {
        return $this->db->quote($string);
    }
}