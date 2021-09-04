<?php
    session_start();
    require('dbconnect.php');

    $posts = $db->prepare('SELECT * FROM posts WHERE message_id=?');
    $posts->execute(array($_GET['message_id']));
    $post = $posts->fetch();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?=$post['title']?></title>
    </head>
    <body>
        <h1>タイトル</h1>
        <h1><?=$post['title']?></h1>
        <p>本文</p>
        <p>
            <?=$post['message']?>
        </p>
    </body>
</html>