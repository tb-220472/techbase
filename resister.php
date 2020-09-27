<?php
    session_start();
    require_once './UserLogic.php';

    //バリデーション作成
    //エラーメッセージ
    $err = [];//バリデーションに引っかったものを表示
    $token = filter_input(INPUT_POST,'csrf_token');
    //トークンがない、もしくは一致しない場合は、処理を中止
    if(!isset($_SESSION['csrf_token']) || $token !==$_SESSION['csrf_token']){
        exit('不正なリクエスト');
    }
    unset($_SESSION['csrf_token']);

    //バリデーション
    //ポストで受け取ったデータを表示する
    if(!$user_name=filter_input(INPUT_POST,'username')){
        $err[] = "ユーザー名を記入してください。";
    }
    if(!$email=filter_input(INPUT_POST,'email')){
        $err[] = "メールアドレスを記入してください。";
    }
    $password=filter_input(INPUT_POST,'password');
    if(!preg_match('/\A[a-z\d]{8,100}+\z/i', $password)){
        $err[]= "半角英数字8文字以上100文字以下にしてください";
    }
    $password_conf=filter_input(INPUT_POST,'password_conf');
    if($password!==$password_conf){
        $err[] = '確認用パスワードと異なっています。';
    }
    if(count($err)===0){
        //ユーザーを登録する処理(phpとhtmlの処理は若手書くことが多いので、↓のコードを使う)
        $hasCreated = UserLogic::createUser($_POST);//userlogicというクラスを作り、静的なcreateuserというmethodを使う
        //newとつなげないことで静的で呼び出すことができる。
        if(!$hasCreated){
            $err[] = '登録に失敗しました';
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録完了画面</title>
</head>
<body>
        <?php if(count($err) > 0) : ?> <!--エラーが０の値より大きかったら-->
        <?php foreach($err as $e) : ?>
          <p><?php echo $e ?></p>
        <?php endforeach ?>
        <?php else : ?><!--それ以外だった場合登録完了画面へ-->
      <p>ユーザー登録が完了しました。</p>
       <?php endif ?>
    <a href="./signup_form.php">戻る</a><!--どちらでも表示される-->
</body>
</html>