<?php session_start(); require("../dbconnect.php"); ?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
        <link href="http://noobs.php.xdomain.jp/test.css" rel="stylesheet" type="text/css">
        <title>ふぁふぁ</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(()=>{
                $('#yyBtn').on('click', ()=>{
                    executePHP(
                        'http://noobs.php.xdomain.jp/yyInc.php',
                        {
                            'action': 'count_up',
                            'message_id': 158                        }
                    );
                });

                $('#ansBtn').on('click', ()=>{
                    executePHP(
                        'http://noobs.php.xdomain.jp/insertAnswer.php',
                        {
                            'message_id': 158,
                            'text': $('#honbun').val()
                        }
                    );
                    location.href ="http://noobs.php.xdomain.jp/questions/158";
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
                <h1>ふぁふぁ</h1>
            </div>
            <div class="question-body">
                <p>
                    あふぁふぁあふ
ぁふぁふぁふぁ


あふぁふぁ


あふぁｆ


ふぁふぁ                </p>
                <button style="border-radius: 10%" id="yyBtn">
                    <i class="material-icons">thumb_up_off_alt</i>
                    読みやすいね
                </button>
                <a href="http://noobs.php.xdomain.jp/main">TOPへ</a>
            </div>
            <div class="answer">
                                    <ul>
                                                    <li class="post">
                                <p class="username">
                                    <img src="http://noobs.php.xdomain.jp/profile/20210905_122208.4831.png" width="30" height="30"></img>
                                    <h2>octsnow</h2>
                                </p>
                                <p>fafafafafa</p>
                            </li>
                                                    <li class="post">
                                <p class="username">
                                    <img src="http://noobs.php.xdomain.jp/profile/20210905_122208.4831.png" width="30" height="30"></img>
                                    <h2>octsnow</h2>
                                </p>
                                <p>afafaf</p>
                            </li>
                                                    <li class="post">
                                <p class="username">
                                    <img src="http://noobs.php.xdomain.jp/profile/20210905_122208.4831.png" width="30" height="30"></img>
                                    <h2>octsnow</h2>
                                </p>
                                <p>fafaf</p>
                            </li>
                                                    <li class="post">
                                <p class="username">
                                    <img src="http://noobs.php.xdomain.jp/profile/20210905_122208.4831.png" width="30" height="30"></img>
                                    <h2>octsnow</h2>
                                </p>
                                <p>afaaafafafa</p>
                            </li>
                                                    <li class="post">
                                <p class="username">
                                    <img src="http://noobs.php.xdomain.jp/profile/20210905_122208.4831.png" width="30" height="30"></img>
                                    <h2>octsnow</h2>
                                </p>
                                <p>afafafa</p>
                            </li>
                                                    <li class="post">
                                <p class="username">
                                    <img src="http://noobs.php.xdomain.jp/profile/20210905_122208.4831.png" width="30" height="30"></img>
                                    <h2>octsnow</h2>
                                </p>
                                <p>ふぁふぁふぁ</p>
                            </li>
                                                    <li class="post">
                                <p class="username">
                                    <img src="http://noobs.php.xdomain.jp/profile/20210905_122208.4831.png" width="30" height="30"></img>
                                    <h2>octsnow</h2>
                                </p>
                                <p>っふぁ</p>
                            </li>
                                                    <li class="post">
                                <p class="username">
                                    <img src="http://noobs.php.xdomain.jp/profile/20210905_122208.4831.png" width="30" height="30"></img>
                                    <h2>octsnow</h2>
                                </p>
                                <p>ふぁふぁ</p>
                            </li>
                                                    <li class="post">
                                <p class="username">
                                    <img src="http://noobs.php.xdomain.jp/profile/20210905_122208.4831.png" width="30" height="30"></img>
                                    <h2>octsnow</h2>
                                </p>
                                <p>ふぁふぁ</p>
                            </li>
                                            </ul>
                            </div>
            <div>
                <textarea id="honbun" rows="40" cols="40" placeholder="本文を入力してください"></textarea>
                <button id="ansBtn">回答する</button>
            </div>
        </div>
    </body>
</html>