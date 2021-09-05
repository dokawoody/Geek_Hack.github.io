<?php
    function console_log($data){
        echo '<script>console.log('.json_encode($data).');</script>';
    }

    function createHTML($template_url, $message_id){
        $url = $template_url.'?message_id='.$message_id;
        $data = curl_get_contents($url);
        $path = './questions/'.$message_id;
        $fhandle = fopen($path, "w");
        fwrite($fhandle, $data);
        fclose($fhandle);
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
    
    try{
        $db = new PDO('mysql:dbname=noobs_01; host=mysql1.php.xdomain.ne.jp; charset=utf8', 'noobs_01', 'hackathon21005');
    }catch(PDOException $e){
        echo 'DB接続エラー'.$e->getMessage;
    }
?>