<?php
    session_start();
    require('dbconnect.php');

    $posts = $db->prepare('SELECT * FROM posts WHERE message_id=?');
    $posts->execute(array($_GET['message_id']));
    $post = $posts->fetch();

    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $host = $_SERVER['HTTP_HOST'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
        <link href="<?=$protocol.$host?>/test.css" rel="stylesheet" type="text/css">
        <title><?=$post['title']?></title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(()=>{
                $('#yyBtn').on('click', ()=>{
                    executePHP(<?=$protocol.$host.'/yyInc.php'?>);
                });

                function executePHP(url){
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            'action': 'count_up',
                            'message_id': <?=$_GET['message_id']?>
                        },
                        success: (content) => {
                            console.log('php success');
                        }
                    });
                }
            });
        </script>
    </head>
    <body>
        <div class="container">
            <a><i class="material-icons">edit</i></a>
            <div class="question-title">
                <h1><?=$post['title']?></h1>
            </div>
            <div class="question-body">
                <p>
                    <?=$post['message']?>
                </p>
                <button style="border-radius: 10%" id="yyBtn">
                    <i class="material-icons">thumb_up_off_alt</i>
                    読みやすいね
                </button>
                <a href="<?=$protocol.$host.'/main'?>">TOPへ</a>
            </div>
            <div>
                <textarea rows="40" cols="40" placeholder="本文を入力してください"></textarea>
            </div>
        </div>
    </body>
</html>