<?php
session_start();

$err = $_SESSION;

//セッションを終了
$_SESSION = array();
session_destroy();

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF=8">
<title>ログイン画面</title>
</head>
<body>
<h2>ログインフォーム</h2>
    <?php if(isset($err['msg'])) : ?>
        <p><?php echo $err['msg']; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
  <p>
   <label for="email">メールアドレス：</label>
   <input type="email" name="email">
   <?php if(isset($err['email'])) : ?>
    <p><?php echo $err['email']; ?></p>
   <?php endif; ?>
  </p>
  <p>
   <label for="password">パスワード：</label>
   <input type="password" name="password">
   <?php if(isset($err['password'])) : ?>
    <p><?php echo $err['password']; ?></p>
   <?php endif; ?>
  </p>
  <P>
   <input type="submit" value="ログイン">
  </p>
 </form>
 <a href="signup_form.php">新規登録はこちら</a>
</body>

</html>