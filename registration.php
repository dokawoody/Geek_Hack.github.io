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
            $_SESSION['join'] = $_POST;
            exit(header('Location: confirm'));
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>会員登録</title>
    </head>
    <body>
        <form action="" method="post">
            <p>
                ニックネーム
                <input type="text" name="name" value="<?=htmlspecialchars($_POST['name']??"")?>">
                <?php if(isset($error['name']) && ($error['name'] == 'blank')): ?>
                    <p class="error">
                        ニックネームを入力してください
                    </p>
                <?php endif; ?>
            </p>
            <p>
                メール
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
                パスワード
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
                パスワード(確認用)
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
            <input type="submit" value="確認画面へ">
        </form>
    </body>
</html>