<?php

require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\Config;


if(!isset($_REQUEST['user'])) {
    echo 'Salida prematura';
    die();
}
$username = $_REQUEST['user'];

$userdb = Config::build_sqlitedb_name([$username]);

//echo Config::build_sqlitedb_name([$username]);


$pdo = (new SQLiteConnection()) -> get_instance($userdb, Config::PATH_SCHEMA_DATABASE);

if($pdo != null)
{
  /*  echo '<h4>Estamos conectados con sqlite</h4>';
    $tags = ['dionicio', 'nuevo', 'noticias'];

    $statement = $pdo -> prepare("INSERT INTO Notes(_note_title, _note_message) VALUES (:title, :msg)");
    $statement -> bindValue(':title', "Titulo 1(".$username.")");
    $statement -> bindValue(':msg', "Hey Hey!");
    $statement -> execute();
    echo $pdo -> lastInsertId();
    echo $statement -> rowCount();
    

    foreach ($tags as $key => $value) {        
        $statement = $pdo -> prepare("INSERT INTO Tags(_tag_name) VALUES (?)");
        //$statement -> bindParam($value);
        $statement -> execute(
            [$value]
        );
        
       // echo $value."*".$statement -> rowCount()."*";

        if($statement -> rowCount() < 1){
            break;
        }
    }
    foreach ($tags as $key => $value) {        
        $statement = $pdo -> prepare("INSERT INTO NoteTags(_note_id, _tag) VALUES (1,?)");
        $statement -> execute(
            [$value]
        );
        
        //echo $value."*".$statement -> rowCount()."*";

        if($statement -> rowCount() < 1){
            break;
        }
    }
   // */
    $statement = $pdo -> prepare("SELECT * FROM Notes WHERE _id = 1");
    $statement -> execute();


    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    echo "<h1>".$result['_note_title']."</h1><br>";
    

    $statement = $pdo -> prepare("SELECT * FROM NoteTags WHERE _note_id = 1");
    $statement -> execute();

    echo "Sus tags son: ";
    $results = $statement -> fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($results as $key => $value) {
        echo "<strong>".$value['_tag']."</strong>,";
    }


}else{
    echo '<h4>Ni siquiera eso puedes hacer bien</h4>';
}

