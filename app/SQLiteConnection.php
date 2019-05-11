<?php
namespace App;

class SQLiteConnection
{
    private $pdo;

    public function get_instance(string $path, $schema = '')
    {
        if ($this->pdo == null) {
            try {
                $this->pdo = new \PDO("sqlite:" . $path);
                $this->pdo-> setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

                if ($this->pdo != null) {
                    $commands = $this->get_db_commands($schema);

                    if ($commands != null) {
                        foreach ($commands as $command)
                        {
                            if(!empty($command))
                            {
                                $this->pdo->exec($command);
                            }
                        }
                    }
                }
            } catch (\PDOException $ex) {
                $this->pdo = null;
            }
        }

        return $this->pdo;
    }

    private function get_db_commands($filepath, $delimiter = ';')
    {

        if(!file_exists($filepath)){
            return [];
        }

        $file = fopen($filepath, "r");

        $content = trim(fread($file, filesize($filepath)));

        fclose($file);

        if (empty($content)) {
            return null;
        }

        $array = explode($delimiter, $content);

        return $array;
    }
}
