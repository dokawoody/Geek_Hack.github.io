<?php
    function console_log($data){
        echo '<script>console.log('.json_encode($data).');</script>';
    }//文字列入力したらコンソールにログとして表示
    
    try{
        $db = new PDO('mysql:dbname=test; host=127.0.0.1; charset=utf8', 'root', '');
        //$db = new PDO('mysql:dbname=noobs_01; host=mysql1.php.xdomain.ne.jp; charset=utf8', 'noobs_01', 'hackathon21005');
    }catch(PDOException $e){
        echo 'DB接続エラー'.$e->getMessage;
    }
?>