<?php
  session_start();
  //DB接続に必要な情報をまとめておきます
  $dsn="mysql:host=localhost;dbname=tripmemory;charset=utf8";
  $user="testuser";
  $pass="testpass";

    //フォームから送信されたデータを受け取る処理
    if(isset($_POST["triptitle"])) {
      $triptitle = $_POST["triptitle"];
      $day = $_POST["day"];
      $place = $_POST["place"];
      $spots = isset($_POST["spot"]) ? $_POST["spot"] : [];
      $comments = isset($_POST["comment"]) ? $_POST["comment"] : [];
      $remarks = $_POST["remarks"];
      $userid = $_SESSION["userid"];
    }
  
    
    // スポットとコメントの数を取得
    $spot1 = isset($spots[0]) ? $spots[0] : "";
    $comment1 = isset($comments[0]) ? $comments[0] : "";
    $spot2 = isset($spots[1]) ? $spots[1] : "";
    $comment2 = isset($comments[1]) ? $comments[1] : "";
    $spot3 = isset($spots[2]) ? $spots[2] : "";
    $comment3 = isset($comments[2]) ? $comments[2] : "";
    $spot4 = isset($spots[3]) ? $spots[3] : "";
    $comment4 = isset($comments[3]) ? $comments[3] : "";
    $spot5 = isset($spots[4]) ? $spots[4] : "";
    $comment5 = isset($comments[4]) ? $comments[4] : "";
  
      

    
    //DBに接続します
    try{
    $dbh=new PDO($dsn,$user,$pass);
    //sql文の用意。ヒアドキュメント
    $sql=<<<sql
    
    INSERT INTO material (triptitle, day, place, spot1, comment1, spot2, comment2, spot3, comment3, spot4, comment4, spot5, comment5, remarks, userid)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
sql;
//前に空白あけない
      
    // SQLの準備と実行
    $stmt = $dbh->prepare($sql);  // SQLの値を保留
    $stmt->bindParam(1, $triptitle);   // プレイスホルダーに値を紐づける
    $stmt->bindParam(2, $day);
    $stmt->bindParam(3, $place);
    $stmt->bindParam(4, $spot1);
    $stmt->bindParam(5, $comment1);
    $stmt->bindParam(6, $spot2);
    $stmt->bindParam(7, $comment2);
    $stmt->bindParam(8, $spot3);
    $stmt->bindParam(9, $comment3);
    $stmt->bindParam(10, $spot4);
    $stmt->bindParam(11, $comment4);
    $stmt->bindParam(12, $spot5);
    $stmt->bindParam(13, $comment5);
    $stmt->bindParam(14, $remarks);
    $stmt->bindParam(15, $userid);
    $stmt->execute(); // 保留していたSQLを実行
      
    }catch(PDOException $e){
      echo "接続失敗・・・";
      echo "エラー内容：".$e->getMessage();
    }
    

    $html = <<<EOD
    <!DOCTYPE html>
  <html lang="ja">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>確認画面</title>
      <link rel="stylesheet" href="check.css"> 
  </head>
    <section class="contr">
      <h2>登録が完了しました</h2>
      <button class="button" onclick="location.href='input.html'">さらに追加</button>
      <button class="button" onclick="location.href='show.php'">編集・削除</button>
      <button class="button" onclick="location.href='selectMenu.html'">TOPに戻る</button>
      </body>
      </html>
    </section>
EOD;
    echo $html;
    // //リダイレクト
    // header('Location: check.php');
    // exit;

