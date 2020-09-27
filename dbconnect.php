<?php
 require_once './env.php';
 ini_set('display_errors',true); //エラーが出ていた場合、これをセットすると内容が表示される
 function connect()
 {
     $host = DB_HOST;
     $db   = DB_NAME;
     $user = DB_USER;
     $pass = DB_PASS;

     $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

     try{$dbh = new PDO($dsn, $user, $pass,[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
        ]);
        return $dbh;
       } catch(PDOExeption $e){
         echo "接続失敗です".$e->getMessage();
         exit();
     }
 }
?>