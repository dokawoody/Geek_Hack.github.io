<?php
    session_start();
    require('dbconnect.php');

    $id = $_SESSION['id'];
    $posts = $db->prepare('INSERT INTO answers SET question_id=?, text=?, created_by=?, created=NOW()');
    $posts->execute(array(
        $_POST['message_id'],
        $_POST['text'],
        $id
    ));
    
    $url = 'http://noobs.php.xdomain.jp/template.php';
    createHTML($url, $_POST['message_id']);
?>