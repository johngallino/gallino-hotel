<?php


$dsn = 'mysql:host=localhost;dbname=johngallinodatabase';
$username = 'johngallino';
$pw = 'password';

try {
    $db = new PDO($dsn, $username, $pw);
    //echo '<p>You are connected to the database!</p';
} catch (PDOException $ex) {
    $error_message = $ex->getMessage();
    echo "<p>An error occured while connecting to the database: $error_message</p>";
}