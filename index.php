<?php

require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\Config;

$username = 'saitamaHero';
$userdb = Config::build_sqlitedb_name([$username]);

//echo Config::build_sqlitedb_name([$username]);


$pdo = (new SQLiteConnection()) -> get_instance($userdb);

if($pdo != null)
{
    echo '<h4>Estamos conectados con sqlite</h4>';
}else{
    echo '<h4>Ni siquiera eso puedes hacer bien</h4>';
}