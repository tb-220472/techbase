<?php

 $dsn="mysql:dbname=tb220472db;host=localhost";
 $user="tb-220472";
 $password="Wm3gsRNEbC";
 $dbh=new PDO($dsn,$user,$password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES => false,]);

 $sql = "CREATE TABLE IF NOT EXISTS users"
 ."("
 . "id INT AUTO_INCREMENT PRIMARY KEY,"
 . "name varchar(64),"
 . "email varchar(191) unique,"
 . "password varchar(191)"
 .")";
 
 $stmt = $dbh->query($sql);

 $sql ='SHOW TABLES';//データベース内のテーブル一覧の取得//①SQL文の準備
	$result = $dbh -> query($sql);//②SQL文の実行
	foreach ($result as $row){//③結果の取得
		echo $row[0];
		echo '<br>';
	}
    echo "<hr>";

    
    $sql ='SHOW CREATE TABLE users';//SHOW CREATE TABLEはSQL_QUOTE_SHOW_CREATE オプションにしたがってテーブルとカラム名を引用する。
    //与えられたテーブルを作るCREATE TABLE statementを表示する。
        $result = $dbh -> query($sql);
        foreach ($result as $row){
            echo $row[1];
        }
        echo "<hr>";

        $sql = 'SELECT * FROM users';
        $stmt = $dbh->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['password'].',';
            echo $row['email'].'<br>';
        echo "<hr>";
        }
?>