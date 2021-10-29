<?php

class PDOManager
{
    public function getBdd()
    {
        try {
            return new PDO('mysql:host=db;dbname=game', 'root', 'example');
        } catch (Exception $e) {
            echo $e;
        }
    }
}
