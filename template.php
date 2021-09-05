<?php
    session_start();
    require('dbconnect.php');

    $posts = $db->prepare('SELECT * FROM posts WHERE message_id=?');
    $posts->execute(array($_GET['message_id']));
    $post = $posts->fetch();

    $answers = $db->prepare('SELECT m.name, m.picture, a.* FROM members m, answers a WHERE m.id=a.created_by AND a.question_id=? ORDER BY a.created DESC');
    $answers->execute(array($_GET['message_id']));

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
                    let url = '<?=$protocol.$host."/yyInc.php"?>';
                    let json = {
                            'action': 'count_up',
                            'message_id': <?=$_GET['message_id']?>
                        };
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: json,
                        success: ()=>{
                            console.log('php success!');
                        }
                    });
                });

                $('#ansBtn').on('click', ()=>{
                    let url = '<?=$protocol.$host."/insertAnswer.php"?>';
                    let json = {
                            'message_id': <?=$_GET['message_id']?>,
                            'text': $('#honbun').val()
                        };
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: json,
                        success: ()=>{
                            console.log('php success!');
                            location.href ="<?=$protocol.$host.'/questions/'.$_GET['message_id']?>";
                        }
                    });
                });
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
                    <?=nl2br($post['message']??"");?>
                </p>
                <button style="border-radius: 10%" id="yyBtn">
                    <i class="material-icons">thumb_up_off_alt</i>
                    読みやすいね
                </button>
                <a href="<?=$protocol.$host.'/main'?>">TOPへ</a>
            </div>
            <div class="answer">
                <?php if($answers->RowCount() > 0): ?>
                    <ul>
                        <?php foreach($answers as $answer): ?>
                            <li class="post answer-box">
                                <p class="username">
                                    <img src="http://noobs.php.xdomain.jp/<?=$answer['picture']?>" width="30" height="30"></img>
                                    <h2><?=$answer['name']?></h2>
                                </p>
                                <p><?=$answer['text']?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div>
                <textarea id="honbun" rows="40" cols="40" placeholder="本文を入力してください"></textarea>
                <button id="ansBtn">回答する</button>
            </div>
        </div>
    </body>
</html>