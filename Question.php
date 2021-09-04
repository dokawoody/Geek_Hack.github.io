<?php
    session_start();
    require('dbconnect.php');

    if(isset($_SESSION['id']) && ($_SESSION['time'] + 3600) > time()){
        $_SESSION['time'] = time();
        $members = $db->prepare('SELECT * FROM members WHERE id=?');
        $members->execute(array($_SESSION['id']));
        $member = $members->fetch();
        if(!empty($_POST)){
            if($_POST['title'] == ''){
                $error['title'] = 'blank';
            }
            if($_POST['comment'] == ''){
                $error['comment'] = 'blank';
            }
            if(!isset($error)){
                $posts = $db->prepare('INSERT INTO posts SET created_by=?, title=?, message=?, created=NOW()');
                $posts->execute(array(
                    $_SESSION['id'],
                    $_POST['title'],
                    $_POST['comment']
                    //$_POST['pic']
                ));

                $url = 'http://noobs.php.xdomain.jp/template.php';
                $message_id = $db->lastInsertId();
                createHTML($url, $message_id);

                exit(header('Location: main'));
            }
        }
    }else{
        unset($_SESSION);
        exit(header('Location: login'));
    }

    // 読みやすい投稿を取得
    $posts = $db->prepare('SELECT * FROM posts ORDER BY yomiyasuine DESC');
    $posts->execute();

function createHTML($template_url, $message_id): bool{
    $url = $template_url.'?message_id='.$message_id;
    $data = curl_get_contents($url);
    $path = './questions/'.$message_id;
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $(()=>{
                let line = $('#line');
                let question = $('#question');
                let isDown = false;
                let winWidth = window.innerWidth;
                let winHeight = window.innerHeight;

                line.mousedown((e)=>{
                    isDown = true;
                });

                line.mouseup((e)=>{
                    isDown = false;
                });

                $(window).mousemove((e)=>{
                    if(isDown){
                        line.css({'left': e.clientX});
                        question.css({'width': (e.clientX / winWidth) + 'vw'});
                    }
                });
            });
        </script>
        <title>初心者エンジニアに優しい質問サイト</title>
    </head>            
    <body>
        <div class="container flex-box">
            <div class="flex-item" id="question">
                <nav>
                    <section>
                        <a class="" href="main">戻る</a>
                        <h2>新規投稿</h2>
                        <form action="" method="post">
                            <dt>ニックネーム：<?=htmlspecialchars($member['name'], ENT_QUOTES);?></dt>
                            <dt>タイトル：<input name="title" type="text" placeholder="質問したいことを簡潔に書いてください"></dt>
                            <?php if(isset($error['title']) && ($error['title'] == 'blank')): ?>
                                <div class="error">タイトルを入力してください</div>
                            <?php endif; ?>
                            <div class="honbun"><span class="label">本文:</span><textarea name="comment" cols="40" rows="40" wrap="hard" placeholder="質問内容を入力してください。"></textarea></div>
                            <?php if(isset($error['comment']) && ($error['comment'] == 'blank')): ?>
                                <div class="error">本文を入力してください</div>
                            <?php endif; ?>
                            <label for="image">画像ファイル:</label><br>
                            <input type="file" accept="image/*" name="pic">
                            <input type="submit" style="position: absolute; right: 10%" value="質問する" class="situmon">
                        </form>
                    </section>
                </nav>
            </div>
            <div class="flex-item">
                <h2>評価の高い質問</h2>
                <?php if($posts->rowCount() > 0): ?>
                    <ul>
                    <?php foreach($posts as $post): ?>
                        <li class="post">
                            <a href="http://<?=$_SERVER['HTTP_HOST']?>/questions/<?=$post['message_id']?>">
                                <?=$post['title']?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                </div>
        </div>
    </body>
</html>