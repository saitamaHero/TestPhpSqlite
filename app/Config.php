<?php
namespace App;

class Config{
    const PATH_DIRECTORY_SQLITE = 'db/';
    const PATH_SCHEMA_DATABASE  = "db/sqlite_structure.sql";
    const EXTENSION_SQLITE_DB   = ".db";
    const PREFIX_TEMP_NAME      = "temp_";

    /**
     * Construye una ruta para el archivo de la base de datos con los valores deseados 
     * Si ningún parametro es especificado se crea un archivo temporal con timestamp de unix y un prefijo indicando temporal
     * @param array $params parametros para construir el nombre de la db
     * @return string
     */
    public static function build_sqlitedb_path(array $params = array())
    {
        $dbname = self::PATH_DIRECTORY_SQLITE;

        foreach ($params as $value) {
            $dbname .= strtolower($value); 
        }

        if($dbname == self::PATH_DIRECTORY_SQLITE)
        {
            $dbname .= self::PREFIX_TEMP_NAME.time().self::EXTENSION_SQLITE_DB;
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