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
        <title>ログイン</title>
    </head>
    <body>
        <form action="" method="post">
            <p class="error">
                <?php if(isset($error['login'])): ?>
                    <?php if($error['login'] == 'blank'): ?>
                        パスワードかメールアドレスを入力してください
                    <?php elseif($error['login'] == 'faild'): ?>
                        パスワードかメールアドレスが間違っています
                    <?php endif; ?>
                <?php endif; ?>
            </p>
            <p>メール<input type="text" name="email"></p>
            <p>パスワード<input type="password" name="password"></p>
            <input type="submit" value="ログイン">
        </form>
    </body>
</html>