<?php session_start(); require("../dbconnect.php"); ?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
        <link href="http://noobs.php.xdomain.jp/test.css" rel="stylesheet" type="text/css">
        <title>fafafaf</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(()=>{
                $('#yyBtn').on('click', ()=>{
                    executePHP(
                        'http://noobs.php.xdomain.jp/yyInc.php',
                        {
                            'action': 'count_up',
                            'message_id': 155                        }
                    );
                });

                $('#ansBtn').on('click', ()=>{
                    executePHP(
                        'http://noobs.php.xdomain.jp/insertAnswer.php',
                        {
                            'message_id': 155,
                            'text': $('#honbun').val()
                        }
                    );
                    location.href ="http://noobs.php.xdomain.jp/questions/155";
                });

                function executePHP(url, json){
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: json,
                        success: ()=>{
                            console.log('php success!');
                        }
                    });
                }
            });
        </script>
    </head>
    <body>
<script type="text/javascript" src="https://ad.xdomain.ne.jp/js/server-php.js"></script>
        <div class="container">
            <a><i class="material-icons">edit</i></a>
            <div class="question-title">
                <h1>fafafaf</h1>
            </div>
            <div class="question-body">
                <p>
                    ??????
??????
??????
??????
??????                </p>
                <button style="border-radius: 10%" id="yyBtn">
                    <i class="material-icons">thumb_up_off_alt</i>
                    ??????????????????
                </button>
                <a href="http://noobs.php.xdomain.jp/main">TOP???</a>
            </div>
            <div class="answer">
                            </div>
            <div>
                <textarea id="honbun" rows="40" cols="40" placeholder="?????????????????????????????????"></textarea>
                <button id="ansBtn">????????????</button>
            </div>
        </div>
    </body>
</html>