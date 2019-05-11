<?php
require '../vendor/autoload.php';

use App\SQLiteConnection;
use App\Config;

if (!isset($_REQUEST['user'])) {
    echo 'User is not set';
    die();
}

$username       = $_REQUEST['user'];
$userdb         = '../' . Config::build_sqlitedb_path(['notes_', $username]);


if(!file_exists($userdb)){
    echo 'The user not exists';
    die();
}

//echo $userdb;

$pdo = (new SQLiteConnection())->get_instance($userdb, '../' . Config::PATH_SCHEMA_DATABASE);


if ($pdo != null) {
    $statement = $pdo->prepare("SELECT * FROM UserPreferences");
    $statement->execute();

    // $result = $statement->fetchAll();

    // if ($result != null) {
    $color = "#000000";
    $text  = "";
    $times = 0;

    while ($result =   $statement->fetch(PDO::FETCH_OBJ)) {
        switch ($result->_preference_id) {
            case "bgcolor":
                $color = $result ->_preference_value;
                break;
            case "textToTesting":
                $text = $result->_preference_value;
                break;
            case "showCount":
                $times = intval($result->_preference_value);
                break;
        }
    }

    for ($i = 0; $i < $times; $i++) {
        echo "<h4 style=\"color:${color}\">${text}</h4>";
    }

}
