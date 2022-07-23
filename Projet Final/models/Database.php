<?php

namespace Models;

abstract class Database
{
    private static $_dbConnect;
    
    private static function setDb()
    {
        self::$_dbConnect = new \PDO( 'mysql:host=db.3wa.io;dbname=gabrielhuyghe_projet;charset=utf8', 'gabrielhuyghe', 'cc305cc016dfbc31e399a5988d4a0a5f' );
        self::$_dbConnect->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
    }
 
    protected function getDb()
    {
        if( self::$_dbConnect == null )
        {
            self::setDb();
        }
        
        return self::$_dbConnect;
    }
    
    protected function getAll( $table )
    {
        $query = $this->getDb()->prepare( "SELECT * FROM $table" );
        $query->execute();
        return $query->fetchAll();
    }
    
}