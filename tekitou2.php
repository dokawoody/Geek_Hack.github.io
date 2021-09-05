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
                $up_file  = "";//初期化
                $up_ok = false;
                $tmp_file = isset($_FILES["pic"]["tmp_name"]) ? $_FILES["pic"]["tmp_name"] : "";//保存先相対パス
                $org_file = isset($_FILES["pic"]["name"])     ? $_FILES["pic"]["name"]     : "";//元ファイル名
                $file_err = $_FILES["pic"]["error"];
                if( $tmp_file != "" &&
                is_uploaded_file($tmp_file) ){
                    $split = explode('.', $org_file); $ext = end($split);
                    if( $ext != "" && $ext != $org_file  ){
                    $up_file = "images/". date("Ymd_His.") . mt_rand(1000,9999) . ".$ext";//ファイル名日付＋乱数
                    $up_ok = move_uploaded_file( $tmp_file, $up_file);//imagesフォルダに保存
                    }
                }

                $posts = $db->prepare('INSERT INTO posts SET created_by=?, title=?, message=?, created=NOW()');
                $posts->execute(array(
                    $_SESSION['id'],
                    $_POST['title'],
                    $_POST['comment']
                ));

                $url = 'http://noobs.php.xdomain.jp/template.php';
                $message_id = $db->lastInsertId();
                createHTML($url, $message_id);

                echo '<script>top.location.href = "main";</script>';
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

$i=0;

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link href="test.css" rel="stylesheet" type="text/css" media="all">

        <style type="text/css">
        /* === ベースのBOX =============================================== */
        .nextReadBox {
        position      : relative;                 /* relative指定は必須   */
        overflow      : hidden;                   /* hidden指定は必須     */
        transition    : .5s;                      /* 開閉の速度           */
        height        : 80px;                    /* 閉じているときの高さ */
        
        background    : #fff;               /* 色や文字情報は変更ください */
        line-height   : 1.3;
        padding       : 5px 10px;
        text-align    : left;
        font-size     : 13pt;
        font-weight   : bold;
        border        : 3px solid #999;
        border-radius : 8px;
        max-width     : 400px;
        margin        : auto;
        }
        
        /* === チェックボックス ========================================== */
        .nextReadBox > input {
        display       : none;                                   /* 非表示 */
        }
        
        /* === チェックボックスのlabel（＝ボタンに見せる） =============== */
        .nextReadBox > label {
        position      : absolute;
        display       : inline-block;
        box-sizing    : border-box;
        cursor        : pointer;
        
        bottom        : 0;   /* 左右いっぱいのBOXにグラデーションを付ける */
        left          : 0;
        right         : 0;
        height        : 60px;
        background    : linear-gradient( rgba(255, 255, 255, 0.10),
                                        #ffffff 65% );
        
        padding-top   : 40px;                   /* 下寄せに文字を配置する */
        text-align    : center;
        font-size     : 15px;
        color         : #0059b3;
        }
        
        /* === 開いているときのボタンサイズを変更 ======================== */
        .nextReadBox > input[type="checkbox"]:checked + label {
        background    : rgba(255, 255, 255, 0.60);
        height        : 25px;
        padding-top   : 5px;
        font-size     : 12px;
        }
        
        /* === ボタンに表示する文字（閉じているとき） ==================== */
        .nextReadBox > input[type="checkbox"]:not(:checked) + label::after {
        content       : "開く";
        }
        
        /* === ボタンに表示する文字（開いているとき） ==================== */
        .nextReadBox > input[type="checkbox"]:checked + label::after {
        content       : "閉じる";
        }
        </style>

        <script type="text/javascript">
        function docOpen(argNo){
        // --------------------------------------------------------------
        //  文書の開閉
        // --------------------------------------------------------------
        var wArea = document.getElementById("area"+argNo);   // 全体の枠
        var wCheck= document.getElementById("ck"+argNo);     // チェックボックス
        var wDoc  = document.getElementById("doc"+argNo);    // 文書のエリア
        
        if(wCheck.checked){
            // 全体枠高さを文書エリアの高さ＋ボタン高さにする
            wArea.style.height = parseInt(wDoc.clientHeight + 40)+"px";
        }else{
            wArea.style.height = "";
        }
        }

        </script>

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
        <header id = "hea">
            <a href="main"><h1 class="logo"><span>初心者エンジニアに優しい質問サイト</span></h1></a>
        </header>
        </header>
        <div class="container flex-box">
            <div class="flex-item" id="question">
                <nav>
                    <section>
                        <a class="backBtn" href="main" target="_top">戻る</a>
                        <h2>新規投稿</h2>
                        <form action="" method="post" enctype="multipart/form-data">
                            <dt>ニックネーム：<?=htmlspecialchars($member['name'], ENT_QUOTES);?></dt>
                            <dt>タイトル：<input name="title" type="search" placeholder="質問したいことを簡潔に書いてください"></dt>
                            <?php if(isset($error['title']) && ($error['title'] == 'blank')): ?>
                                <div class="error">タイトルを入力してください</div>
                            <?php endif; ?>
                            <div class="honbun"><span class="label">本文:</span><textarea name="comment" cols="40" rows="40" wrap="hard" placeholder="質問内容を入力してください。"></textarea></div>
                            <?php if(isset($error['comment']) && ($error['comment'] == 'blank')): ?>
                                <div class="error">本文を入力してください</div>
                            <?php endif; ?>
                            <label for="image">画像ファイル:</label><br>
                            <div class="file-up">
                                <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                                <input type="file" accept="image/*" name="pic" onchange="previewImage(this);">
                            </div>
                            <input type="submit" style="position: absolute; right: 10%" value="質問する" class="situmon">
                            <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:200px;"> 
                            <p>
                                <?php if( isset($file_err) && ($file_err != 2) ): ?>
                                <?php else: ?>
                                    ファイルサイズは2MB未満にしてください。
                                <?php endif; ?>
                            </p>
                        
                        
                        </form>
                    </section>
                </nav>
            </div>

            <div class="flex-item">
                <h2>評価の高い質問</h2>
            
            <?php foreach($posts as $post): ?>
                <?php $counter++;?>
            <div class="nextReadBox" id="area<?=$counter?>">
                <input type="checkbox" id="ck<?=$counter?>" onclick="docOpen('<?=$counter?>')">
                <label for="ck<?=$counter?>"></label>
                    <div id="doc<?=$counter?>">
                        <?php if($posts->rowCount() > 0): ?>
                            <ul>
                                <li>
                                    <a class=ttt>
                                        <h2><?=$post['title']?></h2></a>
                                        本文：
                                        <a><?=$post['message']?>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </div>
            </div>
            <?php endforeach; ?>
            </div>
        </div>

        <script>
            function previewImage(obj)
            {
                var fileReader = new FileReader();
                fileReader.onload = (function() {
                    document.getElementById('preview').src = fileReader.result;
                });
                fileReader.readAsDataURL(obj.files[0]);
            }
        </script>

    </body>
</html>
