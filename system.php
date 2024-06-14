<?php
session_start();
//DB接続に必要な情報をまとめておきます
  $dsn="mysql:host=localhost;dbname=tripmemory;charset=utf8";
  $user="testuser";
  $pass="testpass";

// フォームから送信されたデータを受け取る処理
  if(isset($_POST["triptitle"])) {
    $triptitle = $_POST["triptitle"];   
    $day = $_POST["day"];
    $place = $_POST["place"];
    $spot1 = $_POST["spot"];
    $comment1 = $_POST["comment"];
    $remarks = $_POST["remarks"];
    $remarks = $_POST["remarks"];
    $userid = $_SESSION["userid"];
    }

 
  
  
    //入力内容をセッションに保存する　DB接続のあとにかくのか
     
    //   $_SESSION["triptitle"] = $triptitle;
    //   $_SESSION["day"] = $day;
    //   $_SESSION["place"] = $place;
    //   $_SESSION["spot1"] = $spot1;
    //   $_SESSION["comment1"] = $comment1;
    //   $_SESSION["remarks"] = $remarks;
  
      
      
      //DBに接続します
      try{
      $dbh=new PDO($dsn,$user,$pass);
      //sql文の用意。ヒアドキュメント
      $sql=<<<sql
      
      INSERT INTO material (triptitle, day, place, spot1, comment1, remarks,userid)
      VALUES (?,?,?,?,?,?,?);
sql;
      //前に空白あけない
      
      //    $stmt = $dbh->query($sql); このままだとSQLインジェクションの脅威がある
      $stmt = $dbh->prepare($sql);  //sqlの値を保留
      $stmt -> bindParam(1,$triptitle);   //プレイスホルダー（値が未確定だったところに値を紐づける）
      $stmt -> bindParam(2,$day);
      $stmt -> bindParam(3,$place);
      $stmt -> bindParam(4,$spot1);
      $stmt -> bindParam(5,$comment1);
      $stmt -> bindParam(6,$remarks);
      $stmt -> bindParam(7,$userid);
      $stmt -> execute(); //保留していたSQLを実行
      
    }catch(PDOException $e){
      echo "接続失敗・・・";
      echo "エラー内容：".$e->getMessage();
    }
    

    $html = <<<EOD
    <h2>登録が完了しました</h2>
    <button onclick="location.href='input.html'">さらに追加</button>
    <button onclick="location.href='show.php'">過去のデータを見る</button>
    <button onclick="location.href='selectMenu.html'">TOPに戻る</button>
    </body>
    </html>
EOD;
     echo $html;
    // //リダイレクト
    // header('Location: check.php');
    // exit;

