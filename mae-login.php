<?php
    session_start();
    require('dbconnect.php');

    if(!empty($_POST)){
        if(($_POST['email'] != "") && ($_POST['password'] != "")){
            $members = $db->prepare('SELECT * FROM members WHERE email=?');
            $members->execute(array($_POST['email']));
            $member = $members->fetch();

            if($member && password_verify($_POST['password'], $member['password'])){
                $_SESSION['id'] = $member['id'];
                $_SESSION['time'] = time();
                exit(header('Location: main'));
            }else{
                $error['login'] = 'faild';
            }
        }else{
            $error['login'] = 'blank';
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="mae-test.css" rel="stylesheet" type="text/css">
        <script src="title.js" type="text/javascript"></script>
        <title>ログイン</title>
    </head>
    <body>
        <header id = "hea">
            <a href="main"><h1 class="logo"><span>初心者エンジニアに優しい質問サイト</span></h1></a>
        </header>
        <form action="" method="post">
        <div id = bor>
            <p class="error">
                <?php if(isset($error['login'])): ?>
                    <?php if($error['login'] == 'blank'): ?>
                        必要な情報が入力されていません
                    <?php elseif($error['login'] == 'faild'): ?>
                        パスワードかメールアドレスが間違っています
                    <?php endif; ?>
                <?php endif; ?>
            </p>
            <p class = tyuou>　メール　<input type="text" name="email"></p>
            <p class = tyuou>パスワード<input type="password" name="password"></p>
            <p class = tyuou><input type="submit" value="ログイン"> <a href="registration.php">登録はこちら</a></p>
        </div>
        </form>
    </body>
</html>