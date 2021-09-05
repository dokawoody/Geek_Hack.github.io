<?php
    session_start();
    require('dbconnect.php');

    if(!empty($_POST)){
        $posts = $db->prepare('SELECT * FROM posts WHERE message_id=?');
        $posts->execute(array($_POST['message_id']));
        $post = $posts->fetch();

        $posts = $db->prepare('UPDATE posts SET yomiyasuine=? WHERE message_id=?');
        $posts->execute(array(($post['yomiyasuine'] + 1), $_POST['message_id']));
    }
?>