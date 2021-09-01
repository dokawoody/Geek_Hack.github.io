<!DOCTYPE html>
<?php
$fp = fopen('data.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') /**書き込みがあれば */
{
    fputcsv($fp, [$_POST['name'], $_POST['comment']]);/**csvファイルに書き込む */
    rewind($fp);
}
while ($row = fgetcsv($fp)) {
    $rows[] = $row;
}/**csv読み込み */
fclose($fp);
?><html lang="ja">

<head>
<meta charset="UTF-8">
<link href="test.css" rel="stylesheet" type="text/css" media="all">
<title>初心者エンジニアに優しい質問サイト</title>
</head>
<body>
<h1 style="background-color:#008080;color:#ffffff;">初心者エンジニアに優しい質問サイト</h1>


<center>
<div id="content">

<div id="right">
    <h2>評価の高い質問</h2>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>

<nav>
<section>
    <h2>新規投稿</h2>
    <form action="" method="post">
        <div class="name"><span class="label">お名前:</span><input type="text" name="name" value=""></div>
        <div class="honbun"><span class="label">本文:</span><textarea name="comment" cols="40" rows="40 wrap="hard" placeholder="質問内容を入力してください。"></textarea></div>
        <input type="submit" onclick="location.href='main.php'" style="position: absolute; left: 80%" value="質問する" class="situmon">
    </form>
</section>
</nav>
</div>
</center>

</section>
</body>
</html>