<?php
    session_start();
    require('dbconnect.php');
    
     if(!empty($_POST)){
        if($_POST['name'] == ""){
            $error['name'] = 'blank';
        }
        if($_POST['email'] == ""){
            $error['email'] = 'blank';
        }elseif(!preg_match('/.+@.+/', $_POST['email'])){
            $error['email'] = 'invalid';
        }
        if($_POST['password'] == ""){
            $error['password'] = 'blank';
        }elseif(strlen($_POST['password']) < 6){
            $error['password'] = 'length';
        }
        if($_POST['password2'] == ""){
            $error['password2'] = 'blank';
        }elseif($_POST['password'] != $_POST['password2']){
            $error['password2'] = 'defference';
        }

        if(empty($error)){
            $up_file  = "";//初期化
                $up_ok = false;
                $tmp_file = isset($_FILES["pro"]["tmp_name"]) ? $_FILES["pro"]["tmp_name"] : "";//保存先相対パス
                $org_file = isset($_FILES["pro"]["name"])     ? $_FILES["pro"]["name"]     : "";//元ファイル名
                if( $tmp_file != "" &&
                is_uploaded_file($tmp_file) ){
                    $split = explode('.', $org_file); $ext = end($split);
                    $up_file = "profile/". date("Ymd_His.") . mt_rand(1000,9999) . ".$ext";//ファイル名日付＋乱数
                    $up_ok = move_uploaded_file( $tmp_file, $up_file);//imagesフォルダに保存
                    $_SESSION['up']=$up_file;
                }
                $_SESSION['join'] = $_POST;
                exit(header('Location: confirm'));
            
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="test.css" rel="stylesheet" type="text/css">
        <script src="title.js" type="text/javascript"></script>
        <title>会員登録</title>
    </head>
    <body>
        <header id = "hea">
            <a href="main"><h1 class="logo"><span>初心者エンジニアに優しい質問サイト</span></h1></a>
        </header>

        <form action="" method="post" enctype="multipart/form-data">
        <div id = bor>
            <div class="flex-box">
                <div>
                    <p>ニックネーム</p>
                    <p>メール</p>
                    <p>パスワード</p>
                    <p>パスワード(確認用)</p>
                </div>
                <div>
                    <p>
                        <input type="text" name="name" value="<?=htmlspecialchars($_POST['name']??"")?>">
                        <?php if(isset($error['name']) && ($error['name'] == 'blank')): ?>
                            <p class="error">
                                ニックネームを入力してください
                            </p>
                        <?php endif; ?>
                    </p>
                    <p>
                        <input type="text" name="email" value="<?=htmlspecialchars($_POST['email']??"")?>">
                        <?php if(isset($error['email'])): ?>
                            <?php if(($error['email'] == 'blank')): ?>
                                <p class="error">
                                    メールアドレスを入力してください
                                </p>
                            <?php elseif($error['email'] == 'invalid'): ?>
                                <P class="error">
                                    メールアドレスが無効です
                                </p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </p>
                    <p>
                        <input type="password" name="password">
                        <?php if(isset($error['password'])): ?>
                            <?php if($error['password'] == 'blank'): ?>
                                <p class="error">
                                    パスワードを入力してください
                                </p>
                            <?php elseif($error['password'] == 'length'): ?>
                                <p class="error">
                                    パスワードが短すぎます(6文字以上)
                                </p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </p>
                    <p>
                        <input type="password" name="password2">
                        <?php if(isset($error['password2'])): ?>
                            <?php if($error['password2'] == 'blank'): ?>
                                <p class="error">
                                        パスワードを入力してください
                                </p>
                            <?php elseif($error['password2'] == 'difference'): ?>
                                <p class="error">
                                    上のパスワードと違います
                                </P>
                            <?php endif ?>
                        <?php endif ?>
                    </p>
                </div>
            </div>
            <p>
                        <input type="file" accept="image/*" name="pro">
            </p>
            <input type="submit" value="確認画面へ">
        </div>
        </form>
    </body>
</html>