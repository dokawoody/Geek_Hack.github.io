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
        <link href="test.css" rel="stylesheet" type="text/css">
        <title>登録情報確認</title>
    </head>
    <body>
        <header id = "hea">
            <a href="main"><h1 class="logo"><span>初心者エンジニアに優しい質問サイト</span></h1></a>
        </header>
        <div id="bor">
            <form action="" method="post">
                <div class="flex-box">
                    <div>
                        <p>ニックネーム</p>
                        <p>メール</p>
                        <p>パスワード</p>
                    </div>
                    <div>
                        <p><p><?=htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES);?></p>
                        <p><?=htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES);?></p>
                        <p>[みせられないよ]</p>
                    </div>
                </div>
                <input type="submit" name="registration" value="確認">
            </form>
        </div>
    </body>
</heml>