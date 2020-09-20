<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission5-1 </title>
</head>
<body>

<?php
//■■データを接続する■■
$dsn="データベース名";
   $user="ユーザー名";
   $password="パスワード";
   $dbh=new PDO($dsn,$user,$password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES => false,]);

   $sql = "CREATE TABLE IF NOT EXISTS blog3"//テーブルを作るときは　create table テーブル名("フィールド名　データ型,フィールド名　データ型");
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"//"フィールド名　データ型"
    //　AUTO_INCREMENT(フィールドの型を数字型にし、さらにAUTO_INCREMENT属性を指定することで、数字の連番を挿入することができます。
    //整理番号を毎回挿入するためには、挿入の度に何個レコードがあるかを確認しなければいけませんが、AUTO_INCREMENT属性を用いると自動的に連番が振れます。) 
    //PRIMARY KEY（PRIMARY KEY属性にあるフィールドを指定すると、そのフィールドには同じデータが挿入できなくなります。つまりユニークな値を持たせることができます。
    //一般的にはAUTO_INCREMENT属性と併用して整理番号をつけるようにします。）
    . "name char(32),"
    . "comment TEXT,"
    . "password TEXT,"
    . "date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP "
    .");";//""で括ったところがSQL文として認識される。その最後に；を付けることでPHPとして実行。
    $stmt = $dbh->query($sql);//sql文を上記の$pdoのデータベースに問い合わせる。それを変数stmlにいれる。stml→PDOstatementで変数が帰ってくることからこの名前を付けることが多い。

//■■UPDATE文：入力されているデータレコードの内容を編集（mission4-7）■■
//編集番号が入力されたとき、投稿フォームに表示
if(isset($_POST["editsubmit"])){
    $editnumber=$_POST["editnumber"];
    $editpassword=$_POST["editpassword"];
    if(isset($editnumber,$editpassword)){
        if($editnumber!==""&&$editpassword!==""){
            $sql = 'SELECT * FROM blog3';
            $stmt = $dbh->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
            if($editnumber==$row["id"]&&$editpassword==$row["password"]){
                $newcomment=$row["comment"];
                $newname=$row["name"];
                $newnumber=$row["id"];
                }
            }
        }
    }
}
?>

<h1>しりとり掲示板</h1>
<p>みんなでしりとり。</p>
<p>名前・コメント・パスワードの入力は必須です。編集・削除の際にパスワードを使用します。<br></p>
<p>編集モードでは、パスワード入力は必要ありません。<br></p>
<h2><p>投稿フォーム</p></h2>
<form action="mission5-1-3.php" method="post">
<input type="text" name="name" placeholder="名前入力" value=<?php if(isset($newname)){echo $newname;}?>> 
<input type="text" name="comment" placeholder="コメント入力" value=<?php if(isset($newcomment)){echo $newcomment;}?>>
<input type="text" name="password" placeholder="新規パスワード設定"> 
<input type="text" name="edit" value=<?php if(isset($newnumber)){echo $newnumber;}?>><!--隠し目印-->
<input type="submit" name="submit"value="送信">
<h2><p>削除フォーム</p></h2>
<input type="number" name="delatenumber" placeholder="削除番号入力">
<input type="text" name="delatepassword" placeholder="既定のパスワード入力"> 
<input type="submit" name="delatesubmit"value="削除">
<h2><p>編集フォーム</p></h2>
<input type="number" name="editnumber" placeholder="編集番号入力">
<input type="text" name="editpassword" placeholder="既定のパスワード入力"> 
<input type="submit" name="editsubmit"value="編集">
</form>
<hr>
  <?php
//■■データベースのテーブル一覧を表示■■
  /*$sql ='SHOW TABLES';//データベース内のテーブル一覧の取得//①SQL文の準備
	$result = $dbh -> query($sql);//②SQL文の実行
	foreach ($result as $row){//③結果の取得
		echo $row[0];
		echo '<br>';
	}
    echo "<hr>"; //水平線をいれるタグ*/

//■■作成したテーブルの構成詳細を確認する■■
  /* $sql ='SHOW CREATE TABLE blog3';//SHOW CREATE TABLEはSQL_QUOTE_SHOW_CREATE オプションにしたがってテーブルとカラム名を引用する。
   //与えられたテーブルを作るCREATE TABLE statementを表示する。
       $result = $dbh -> query($sql);
       foreach ($result as $row){
           echo $row[1];
       }
       echo "<hr>"; */
//■■INSERT文：データを入力（データレコードの挿入）（mission4-5）■■
       //prepareメソッドでSQL文を作成し
       //executeメソッドでSQL文をデータベースを発行する
       //異なるパラメータを用いて複数回実行されるような文に対し PDO::prepare() と PDOStatement::execute() をコールすることで、 ドライバがクライアントまたはサーバー側にクエリプランやメタ情報を キャッシュさせるよう調整するため、 アプリケーションのパフォーマンスを最適化します。
       //public PDOStatement::bindParam ( mixed $parameter , mixed &$variable [, int $data_type = PDO::PARAM_STR [, int $length [, mixed $driver_options ]]] ) : bool
       //parameterパラメータ ID を指定します。名前付けされたプレースホルダを使った文に 対しては、:name 形式のパラメータ名となります。 疑問符プレースホルダを使った文に対しては、1 から始まるパラメータの 位置となります
       //variable SQL ステートメントパラメータにバインドする PHP 変数名を指定します。
       //data_type パラメータに対して PDO::PARAM_* 定数 を使った明示的なデータ型を指定します。 ストアドプロシージャからの INOUT パラメータの場合、 data_type パラメータに PDO::PARAM_INPUT_OUTPUT ビットを設定するためにビット OR を使用してください。     
      
       if(isset($_POST["submit"])){
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        $password=$_POST["password"];
        $id = $_POST["edit"];
        $date=date("Y/m/d/ H:i:s");
           if(isset($name)&&isset($comment)&&isset($password)){
            if($name!==""&&$comment!==""&&$password!==""&&$id==""){
              $sql = $dbh -> prepare("INSERT INTO blog3 (name, comment,password,date) VALUES (:name, :comment,:password,:date)");
              $sql -> bindParam(':name', $name, PDO::PARAM_STR);//PDOStatement::bindParam — 指定された変数名にパラメータをバインドする
              $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
              $sql -> bindParam(':password', $password, PDO::PARAM_STR);
              $sql -> bindParam(':date', $date, PDO::PARAM_STR);
              $sql -> execute();
             }
           }
        }
      
//■■DELETE文：入力したデータレコードを削除（mission4-8）■■
if(isset($_POST["delatesubmit"])){
  $delatepassword=$_POST["delatepassword"];
  $id = $_POST["delatenumber"];
  if(isset($delatepassword,$id)){//issetだけだと変数が空の場合でもtrueになってしまう
    if($delatepassword!==""&&$id!==""){//空でも実行されることを防ぐ
      $sql = 'SELECT * FROM blog3';
      $stmt = $dbh->query($sql);
      $results = $stmt->fetchAll();
      foreach ($results as $row){
        if($id==$row['id']&&$delatepassword==$row['password']){ 
          $sql = 'delete from blog3 where id=:id';
          $stmt = $dbh->prepare($sql);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->execute();
        } 
      }    
    }
  } 
}
//投稿フォームに表示されたデータを編集して表示する。
if(isset($_POST["submit"])){
        $name2 = $_POST["name"];
        $comment2 = $_POST["comment"];
        $id = $_POST["edit"];
        $date=date("Y/m/d/ H:i:s");
     if(isset($_POST["edit"])){
        if(isset($name2)&&isset($comment2)){
            if($name2!==""&&$comment2!==""){
            $sql = 'UPDATE blog3 SET name=:name,comment=:comment,date=:date WHERE id=:id';
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':name', $name2, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment2, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->execute();
            }    
        }        
    }
}
    $sql = 'SELECT * FROM blog3';
	$stmt = $dbh->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
	echo "<hr>";
	}
  ?>

</body>
</html>