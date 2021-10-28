<?php

require('./Classes/PDOManager.php');
// Create connection
$bdd = PDOManager::getBdd();
// Check connection
if ($bdd->connect_error) {
    die("Connection failed: " . $bdd->connect_error);
    echo 'err';
};
$id = $_GET['id'];

$getPerso = "SELECT * FROM `persos` WHERE id=?";

$request = $bdd->prepare($getPerso);
$request->execute(array($id));

echo var_dump($request->fetch(PDO::FETCH_ASSOC));