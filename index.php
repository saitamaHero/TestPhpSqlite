<?php

require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\Config;


if (!isset($_REQUEST['user'])) {
    echo 'User is not set';
    die();
}

$username       = $_REQUEST['user'];
$userdb         = Config::build_sqlitedb_path(['notes_', $username]);
$doFirstInsert  = !file_exists($userdb);

$pdo = (new SQLiteConnection())->get_instance($userdb, Config::PATH_SCHEMA_DATABASE);

if ($pdo != null && $doFirstInsert) {
   // echo 'Base de datos creada: <br>';

    $tags = ['dionicio', 'nuevo', 'noticias'];

    $statement = $pdo->prepare("INSERT INTO Notes(_note_title, _note_message) VALUES (:title, :msg)");
    $statement->bindValue(':title', "Titulo 1(" . $username . ")");
    $statement->bindValue(':msg', "Hey Hey!");
    $statement->execute();
    //echo $pdo->lastInsertId();
    //echo $statement->rowCount();


    foreach ($tags as $key => $value) {
        $statement = $pdo->prepare("INSERT INTO Tags(_tag_name) VALUES (?)");
        //$statement -> bindParam($value);
        $statement->execute(
            [$value]
        );

        if ($statement->rowCount() < 1) {
            break;
        }
    }

    foreach ($tags as $key => $value) {
        $statement = $pdo->prepare("INSERT INTO NoteTags(_note_id, _tag) VALUES (1,?)");
        $statement->execute(
            [$value]
        );

        if ($statement->rowCount() < 1) {
            break;
        }
    }
        
    $preferences = [];

    //Preferencias base del usuario
    $preferences['textToTesting'] = $username.' likes programming in PHP';
    $preferences['showCount']     = 5;
    $preferences['bgcolor']       = '#4286f4';

    foreach ($preferences as $key => $value) {
        $statement  =  $statement = $pdo->prepare("INSERT INTO UserPreferences (_preference_id, _preference_value) VALUES (:prefid, :prefval)");
        $statement->bindValue(':prefid',  $key);
        $statement->bindValue(':prefval', $value);
        $statement->execute();

        if ($statement->rowCount() < 1) {
            break;
        }
    }
}

if ($pdo != null) 
{
    $statement = $pdo->prepare("SELECT * FROM Notes WHERE _id = 1");
    $statement->execute();


    $result = $statement->fetch();

    $statement = $pdo->prepare("SELECT _tag FROM NoteTags WHERE _note_id = 1");
    $statement->execute();


    $tags = [];

    while($row = $statement -> fetch())
    {
        $tags[] = $row['_tag'];
        //print_r ($row['_tag']);
    }

    $result['_tags'] = $tags;

    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    echo '<h4>Ni siquiera eso puedes hacer bien</h4>';
}
