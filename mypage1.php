<?php
session_start();
require_once './UserLogic.php';
require_once './functions.php';
//ログインしているか判定し、していなかったら新規登録画面へかえす
$result = UserLogic::checkLogin();

if(!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location: signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
</head>
<body>
       <h2>マイページ</h2>
    <p>ログインユーザ：<?php echo h($login_user['name'])?></p>
    <p>メールアドレス：<?php echo h($login_user['email'])?></p>
    
    <h1>しりとり掲示板</h1>
<p>みんなでしりとり。</p>
<p>名前・コメント・パスワードの入力は必須です。編集・削除の際にパスワードを使用します。<br></p>
<p>編集モードでは、パスワード入力は必要ありません。<br></p>
<h2><p>投稿フォーム</p></h2>
<form action="mission6-2.php" method="post">
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
    require_once './dbconnect.php';
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
    
<hr>   
    <form action="logout.php" method="POST">
    <input type="submit" name="logout" value="ログアウト">
    </form>
</body>
</html>
