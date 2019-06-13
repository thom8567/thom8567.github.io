<?php

try{
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=learningrepo;', 'homestead', 'secret');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo "Error:  " . $e -> getMessage() . "<br/>";
    die();
}

