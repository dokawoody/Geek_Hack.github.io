<?php
    function console_log($data){
        echo '<script>console.log('.json_encode($data).');</script>';
    }
    
    try{
        $db = new PDO('mysql:dbname=noobs_01; host=mysql1.php.xdomain.ne.jp; charset=utf8', 'noobs_01', 'hackathon21005');
    }catch(PDOException $e){
        echo 'DB接続エラー'.$e->getMessage;
    }
?>