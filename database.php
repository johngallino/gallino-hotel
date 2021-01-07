<?php


$dsn = 'mysql:host=us-cdbr-east-02.cleardb.com; dbname=heroku_2e5b70d76dac53f';
$username = 'b43a4cf801c624';
$pw = 'ccb11452';

//mysql://b43a4cf801c624:ccb11452@us-cdbr-east-02.cleardb.com/heroku_2e5b70d76dac53f?reconnect=true

try {
    $db = new PDO($dsn, $username, $pw);
    echo '<p>You are connected to the database!</p';
} catch (PDOException $ex) {
    $error_message = $ex->getMessage();
    echo "<p>An error occured while connecting to the database: $error_message</p>";
}