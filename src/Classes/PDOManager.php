<?php

class PDOManager
{
    private $bdd;

    public function getBdd() {
     try{
         return new PDO('mysql:host=db;dbname=game', 'root', 'example');
     }  catch(Exception $e){
         echo $e;
     }
    }
}