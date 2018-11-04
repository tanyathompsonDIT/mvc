<?php

$pdoMessage = '';

// Connect to the database
try
{
    $pdo = new PDO('mysql:host=localhost;dbname=dbName', 'mvcuser', 'mvcpass');
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
}
catch(PDOException $e)
{
    $pdoMessage = 'Unable to connect to the database server. ' . $e->getMessage();
}