<?php
$DEBUG = False;

if ($DEBUG) {
    $dsn = 'mysql:host=localhost;dbname=gallino-hotel';
    $username = 'root';
    $pw = '';
    echo '<p>Debug Mode</p';
} 
else{
    $dsn = 'mysql:host=us-cdbr-east-02.cleardb.com; dbname=heroku_2e5b70d76dac53f';
    $username = 'b43a4cf801c624';
    $pw = 'ccb11452';
};



try {
    $db = new PDO($dsn, $username, $pw);
    //echo '<p>You are connected to the database!</p';
} catch (PDOException $ex) {
    $error_message = $ex->getMessage();
    echo "<p>An error occured while connecting to the database: $error_message</p>";
}