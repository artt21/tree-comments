<?php

$driver = 'mysql';
$host = 'localhost';
$db_name = 'comments';
$db_user = 'root';
$db_pass = '';
$charset = 'utf8';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try
{
    $pdo = new PDO("$driver:host=$host;dbname=$db_name;charset=$charset", $db_user, $db_pass, $options);
} catch (PDOException $e) {
    print "Cannot connect to database: " . $e->getMessage() . "<br/>";
    die();
}
