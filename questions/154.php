<?php session_start(); require("../dbconnect.php"); ?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
        <link href="http://noobs.php.xdomain.jp/test.css" rel="stylesheet" type="text/css">
        <title>pythonってなんですか？</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(()=>{
                $('#yyBtn').on('click', ()=>{
                    executePHP(
                        'http://noobs.php.xdomain.jp/yyInc.php',
                        {
                            'action': 'count_up',
                            'message_id': 154                        }
                    );
                });

                $('#ansBtn').on('click', ()=>{
                    executePHP(
                        'http://noobs.php.xdomain.jp/insertAnswer.php',
                        {
                            'message_id': 154,
                            'text': $('#honbun').val()
                        }
                    );
                    location.href ="http://noobs.php.xdomain.jp/questions/154";
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
                <h1>pythonってなんですか？</h1>
            </div>
            <div class="question-body">
                <p>
                    <プログラム
の目的>
２０人の学
生の「学生
番号、名
前、３科目
の点数」が
まとめられ
たファイル
を読み込
み、３科目
の合計点数
が高い上位
３人を出力
する。な
お、上位３
位までに同
点の生徒が
いた場合は
全員出力す
る。

１位、２
位、３位が
複数いた場
合は全員出
力。１位が
一人、２位
が一人、３
位が二人の
場合は、四
人出力。

１位が２
人、２位が
０、３位が
２人の場合
は、四人出
力。

１位が４人
の時は、四
人出力。

ファイルは
以下の形
式。
1001 name 
49 50 23
1002 name 
22 79 43
......

<質問内容>
３科目の合
計点数が高
い順に出力
まではでき
ました。た
だ、同点の
生徒がいた
場合の処理
がわからな
いです。ど
うすれば同
じ点数の学
生を全員出
力できるの
でしょう
か。


#include 
<stdio.h>
#include 
<stdlib.h>
#include 
<string.h>

#define 
SIZE 256

//まずは構
造体。
typedef 
struct {
  int 
num;//学生
番号
  char 
name[SIZE];
  int 
sub1;//科目
1
  int 
sub2;//科目
2
  int 
sub3;//科目
3
  int 
sum;//３科
目の合計
} students;

students 
s[20];

//３科目の
合計点数を
降順に。
void 
bubble_sort
(int n, 
students 
s[]) {
  students 
tmp;
  int i, j;

  for (i=0; 
i<n; i++) {
    for 
(j=n-1; 
j>i; j--) {
      if 
(s[j].sum > 
s[j-1].sum) 
{
        tmp 
= s[j];
        
s[j] = s[j-
1];
        
s[j-1] = 
tmp;
      }
    }
  }
}

//最後の出
力
void 
print_stude
nts(student
s s) {
  
printf("%d,
%s,%d\n", 
s.num, 
s.name, 
s.sum);
}

int 
main(int 
argc, char 
*argv[]) {
  FILE *fp;
  char 
line[SIZE], 
name[SIZE];
  int i, 
sub1, sub2, 
sub3, num, 
sum[20];


  //エラー
処理
  if ((fp = 
fopen(argv[
1], "r"))== 
NULL) {
    
printf("Can
't open the 
file.\n");
    return 
1;
  }
  //配列が
空じゃない
時に回り続
ける。
  i = 0;
  for (; 
fgets(line, 
SIZE, fp) 
!= NULL ;) 
{
    
sscanf(line
, "%d %s %d 
%d %d", 
&num, name, 
&sub1, 
&sub2, 
&sub3);

    //値を
バンバン代
入してい
く。まずは
sum.
    
s[i].sum = 
sub1 + sub2 
+ sub3;
    // 
printf("%d\
n", 
s[i].sum);

    //次
に、name.
    
strcpy(s[i]
.name, 
name);

    //次
に、num.
    
s[i].num = 
num;
    i++;

    }

  
bubble_sort
(20, s);

//これだと
　int z = 
3;
  for (i=0; 
i<z; i++) {
    
print_stude
nts(s[i]);
    if 
(s[i].sum 
== 
s[i+1].sum) 
{
      z++;
    }
  }

  
fclose(fp);
```ここに言
語を入力  
コード  
  return 0;   
}                </p>
                <button style="border-radius: 10%" id="yyBtn">
                    <i class="material-icons">thumb_up_off_alt</i>
                    読みやすいね
                </button>
                <a href="http://noobs.php.xdomain.jp/main">TOPへ</a>
            </div>
            <div class="answer">
                            </div>
            <div>
                <textarea id="honbun" rows="40" cols="40" placeholder="本文を入力してください"></textarea>
                <button id="ansBtn">回答する</button>
            </div>
        </div>
    </body>
</html>