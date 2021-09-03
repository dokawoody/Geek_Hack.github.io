<?php
    session_start();
    require('dbconnect.php');

    if(isset($_SESSION['id']) && ($_SESSION['time'] + 3600) > time()){
        $_SESSION['time'] = time();
        $members = $db->prepare('SELECT * FROM members WHERE id=?');
        $members->execute(array($_SESSION['id']));
        $member = $members->fetch();
        if(!empty($_POST)){
            $posts = $db->prepare('INSERT INTO posts SET created_by=?, title=?, message=?, created=NOW()');
            $posts->execute(array(
                $_SESSION['id'],
                $_POST['title'],
                $_POST['comment']
            ));

            $url = 'http://127.0.0.1/Geek_Hack.github.io/template.php';
            $message_id = $db->lastInsertId();
            createHTML($url, $message_id);

            exit(header('Location: main'));
        }
    }else{
        unset($_SESSION);
        exit(header('Location: login'));
    }

function createHTML($template_url, $message_id): bool{
    $url = $template_url.'?message_id='.$message_id;
    $data = curl_get_contents($url);
    $path = './questions/'.$message_id.'.html';
    $fhandle = fopen($path, "w");
    fwrite($fhandle, $data);
    fclose($fhandle);

    return true;
}

function curl_get_contents($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link href="test.css" rel="stylesheet" type="text/css" media="all">
        <title>初心者エンジニアに優しい質問サイト</title>
    </head>
    <body>
        <header>
            <h1 id="logo">初心者エンジニアに優しい質問サイト</h1>
        </header>
        <center>
            <div id="content">
                <a href="main">戻る</a>

                <div id="right">
                    <h2>評価の高い質問</h2>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                </div>

                <nav>
                    <section>
                        <h2>新規投稿</h2>
                        <form action="" method="post">
                            <input name="title" type="text" placeholder="質問したいことを簡潔に書いてください">
                            <!--<div class="name"><span class="label">お名前:</span><input type="text" name="name" value=""></div>-->
                            <div class="honbun"><span class="label">本文:</span><textarea name="comment" cols="40" rows="40" wrap="hard" placeholder="質問内容を入力してください。"></textarea></div>
                            <input type="submit" style="position: absolute; left: 80%" value="質問する" class="situmon">
                        </form>
                    </section>
                </nav>
            </div>
        </center>
    </body>
</html>