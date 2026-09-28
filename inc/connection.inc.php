<?php
session_start();
function db_conn(){
        try
        {
            $server   = 'localhost';
            $password = '';
            $username = 'root';
            $database = 'zabka';

            
            $conn = new PDO("mysql:host=$server;dbname=$database",$username,$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
            return $conn;
        }
        catch(PDOException $e)
        {
            return 'Sorry. An Error Occured. Please Try Again';
        }
}




