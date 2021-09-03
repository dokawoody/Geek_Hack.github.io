<?php
    session_start();
    require('dbconnect.php');

    if(!isset($_SESSION['join'])){
        header('Location: registration');
        exit();
    }

    if(!empty($_POST)){
        $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);
        $members = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, created=NOW()');
        $members->execute(array(
            $_SESSION['join']['name'],
            $_SESSION['join']['email'],
            $hash
        ));
        unset($_SESSION);
        exit(header('Location: login'));
    }
?>

<!DOCTYPE html>
<heml>
    <head>
        <title>登録情報確認</title>
    </head>
    <body>
        <form action="" method="post">
            <p>ニックネーム<?=htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES);?></p>
            <p>メール<?=htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES);?></p>
            <p>パスワード[みせられないよ]</p>
            <input type="submit" name="registration" value="確認">
        </form>
    </body>
</heml>