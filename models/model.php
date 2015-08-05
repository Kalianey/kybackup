<?php

// Represent a single row
class Entity
{
    public $id = 0;
    
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @param int $id
     */
    public function setId( $id )
    {
        $this->id = (int) $id;
    }
}

// Represent a single table
abstract class Model
{
    /** @var Database */
    public $db;
    
    function __construct() {
        $this->db = KY::getDB();
    }
    
    abstract function tableName(); //required
    abstract function entityName(); //required
    
    function setDB($db)
    {
        $this->db = $db;
    }
    
    function findAll()
    {
        $sql = "SELECT * FROM ".$this->tableName();
        $res = $this->db->query($sql);
        $data= $this->db->fetchAll($res, Database::FETCH_CLASS, $this->entityName());
        return $data;
    }
    
    function findById($id)
    {
        $sql = "SELECT * FROM ".$this->tableName().' WHERE id= :id';
        $res = $this->db->query($sql, array('id'=>$id));
        $data= $this->db->fetchAll($res, Database::FETCH_CLASS, $this->entityName());
        return $data;
    }
    
    function delete(Entity $entity)
    {
        $this->deleteById($entity->id);
    }
    
    function deleteById($id)
    {
        $sql = "DELETE FROM ".$this->tableName().' WHERE id= :id';
        $this->db->query($sql, array('id'=>$id));
    }
    
    function save(Entity $entity)
    {
        $vars = get_object_vars($entity);
        //print_r($vars);
        if ($vars['id'] == 0)
        {
            $vars['id'] == 'NULL';
        }
        
        
        $cols = array();
        $values = array();
        $updates = array();
        
        foreach($vars as $key=>$value)
        {
            $cols[] = "`$key`";
            $values[] = ' :'.$key.' ';
            $updates[] = " `$key` = VALUES(`$key`) ";
        }
        
        $col = implode(",", $cols);
        $value = implode(",", $values);
        $update = implode(",", $updates);
        
        $sql = "INSERT INTO {$this->tableName()} ($col) VALUES ($value) ON DUPLICATE KEY UPDATE $update";
        $res = $this->db->query($sql, $vars);
        
        if ($res === FALSE)
        {
            return FALSE;
        }
        
        if ($entity->id == 0 )
        {
            $entity->id = $this->db->lastInsertId();
        }
        
        return $entity;
    }
}