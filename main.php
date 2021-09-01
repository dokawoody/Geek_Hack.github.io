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

<input type="submit" class="situmon" onclick="location.href='Question.php'" value="質問投稿" style="position: absolute; right: 0px; top: 0px">

<section class="toukou">
    <h2>投稿一覧</h2>
<?php if (!empty($rows)): ?>
    <ul>
<?php foreach ($rows as $row): ?>
        <li><?=$row[1]?> (<?=$row[0]?>)</li>
<?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>投稿はまだありません</p>
<?php endif; ?>

</section>
</body>
</html>