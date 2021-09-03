<?php
    session_start();
    require('dbconnect.php');

    if(isset($_SESSION['id']) && ($_SESSION['time'] + 3600) > time()){
        $_SESSION['time'] = time();

        $members = $db->prepare('SELECT * FROM members WHERE id=?');
        $members->execute(array($_SESSION['id']));
        $member = $members->fetch();
    }else{
        unset($_SESSION);
        exit(header('Location: login'));
    }

    $posts = $db->query('SELECT m.name, p.* FROM members m, posts p WHERE m.id=p.created_by ORDER BY p.created DESC');

    /*
    $fp = fopen('data.csv', 'a+b');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') /**書き込みがあれば */
/*    {
        fputcsv($fp, [$_POST['name'], $_POST['comment']]);/**csvファイルに書き込む */
//        rewind($fp);
/*    }
    while ($row = fgetcsv($fp)) {
        $rows[] = $row;
    }/**csv読み込み */
//    fclose($fp);
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link href="test.css" rel="stylesheet" type="text/css">
        <title>初心者エンジニアに優しい質問サイト</title>
    </head>
    <body>
        <header>
            <a href="main"><h1 id="logo">初心者エンジニアに優しい質問サイト</h1></a>
            <p><?=htmlspecialchars($member['name'], ENT_QUOTES);?></p>
        </header>

        <input type="submit" class="situmon" onclick="location.href='Question'" value="質問投稿">

        <section class="toukou">
            <h2>投稿一覧</h2>
            
            <?php if (!empty($posts)): ?>
                <ul>
                    <?php foreach($posts as $post): ?>
                        <li>
                            <a href="./questions/<?=$post['message_id']?>">
                                <?=htmlspecialchars($post['name'], ENT_QUOTES);?> : 
                                <?=nl2br(htmlspecialchars($post['title'], ENT_QUOTES));?>
                            </a>
                        </li>
                        <?php console_log($post); ?>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>投稿はまだありません</p>
            <?php endif; ?>

        </section>
    </body>
</html>