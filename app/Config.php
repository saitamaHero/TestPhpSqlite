<?php
namespace App;

class Config{
    const PATH_DIRECTORY_SQLITE = 'db/';
    const PATH_SCHEMA_DATABASE  = "db/sqlite_structure.sql";
    const EXTENSION_SQLITE_DB = ".db";

    public static function build_sqlitedb_name(array $params)
    {
        $dbname = self::PATH_DIRECTORY_SQLITE;

        foreach ($params as $key => $value) {
            $dbname .= $value; 
        }

        if($dbname == self::PATH_DIRECTORY_SQLITE)
        {
            $dbname .= 'temporary_'.time();
        }else if(self::get_extension($dbname) != self::EXTENSION_SQLITE_DB)
        {
            $dbname .= self::EXTENSION_SQLITE_DB;
        }

        return $dbname;
    }

    public static function get_extension(string $var)
    {
        $values = explode('.', $var);
        return end($values);
    }
}