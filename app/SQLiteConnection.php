<?php
namespace App;

class SQLiteConnection{
    private $pdo;

    public function get_instance(string $path)
    {
        if($this -> pdo == null)
        {
            try{
                $this -> pdo = new \PDO("sqlite:".$path);
            }catch(\PDOException $ex){
                $this -> pdo = null;
            }
        }

        return $this -> pdo;
    }
}