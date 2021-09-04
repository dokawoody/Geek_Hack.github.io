<?php
    session_start();
    require('dbconnect.php');

    if(isset($_SESSION['id']) && ($_SESSION['time'] + 3600) > time()){//ログイン状態かどうか
        $_SESSION['time'] = time();

        $members = $db->prepare('SELECT * FROM members WHERE id=?');//あとで値を渡すとき
        $members->execute(array($_SESSION['id']));//値を指定して実行
        $member = $members->fetch();//値を配列にいれる
    }else{
        unset($_SESSION);
        exit(header('Location: login.php'));
    }

    $posts = $db->query('SELECT m.name, p.* FROM members m, posts p WHERE m.id=p.created_by ORDER BY p.created DESC');//値がすでに決まってる
    
    function convert_to_fuzzy_time($time_db){
        $unix   = strtotime($time_db);
        $now    = time();
        $diff_sec   = $now - $unix;
    
        if($diff_sec < 60){
            $time   = $diff_sec;
            $unit   = "秒前";
        }
        elseif($diff_sec < 3600){
            $time   = $diff_sec/60;
            $unit   = "分前";
        }
        elseif($diff_sec < 86400){
            $time   = $diff_sec/3600;
            $unit   = "時間前";
        }
        elseif($diff_sec < 2764800){
            $time   = $diff_sec/86400;
            $unit   = "日前";
        }
        else{
            if(date("Y") != date("Y", $unix)){
                $time   = date("Y年n月j日", $unix);
            }
            else{
                $time   = date("n月j日", $unix);
            }
    
            return $time;
        }
    
        return (int)$time .$unit;
    }

    #$fuzzy_time=convert_to_fuzzy_time($post['created']);
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link href="test.css" rel="stylesheet" type="text/css">
        <script src="title.js" type="text/javascript"></script>
        <title>初心者エンジニアに優しい質問サイト</title> 
    </head>
    <body>
        <header id = "hea">
            <h href="main"><h1 class="logo"><span>初心者エンジニアに優しい質問サイト</span></h1></h>
            <p class = "loginid"><span>ユーザー名：<spam><?=htmlspecialchars($member['name'], ENT_QUOTES);?></p><!--ログイン名-->
        </header>

        <input type="submit" class="situmon" onclick="location.href='Post.php'" value="質問投稿">

        <section class="toukou">
            <h2>投稿一覧</h2>
            <?php if (!empty($posts)): ?>
                <ul>
                    <?php foreach($posts as $post): ?>
                        <li class="post">
                            <a href="./questions/<?=$post['message_id']?>">
                                <p class=taitoru> 
                                <?=nl2br(htmlspecialchars($post['title'], ENT_QUOTES));?></p>
                                <p class="Contributor"><?=htmlspecialchars($member['name'], ENT_QUOTES);?>  <?=htmlspecialchars($post['created']);?></p>
                                
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>投稿はまだありません</p>
            <?php endif; ?>

        </section>
    </body>
</html>