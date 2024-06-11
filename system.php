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
    $spot = $_POST["spot"];
    $comment = $_POST["comment"];
    $remarks = $_POST["remarks"];
    $remarks = $_POST["remarks"];
    $userid = $_SESSION["userid"];
    }

 
  
  
    //入力内容をセッションに保存する　DB接続のあとにかくのか
     
    //   $_SESSION["triptitle"] = $triptitle;
    //   $_SESSION["day"] = $day;
    //   $_SESSION["place"] = $place;
    //   $_SESSION["spot"] = $spot;
    //   $_SESSION["comment"] = $comment;
    //   $_SESSION["remarks"] = $remarks;
  
      
      
      //DBに接続します
      try{
      $dbh=new PDO($dsn,$user,$pass);
      //sql文の用意。ヒアドキュメント
      $sql=<<<sql
      
      INSERT INTO material (triptitle, day, place, spot, comment, remarks,userid)
      VALUES (?,?,?,?,?,?,?);
sql;
      //前に空白あけない
      
      //    $stmt = $dbh->query($sql); このままだとSQLインジェクションの脅威がある
      $stmt = $dbh->prepare($sql);  //sqlの値を保留
      $stmt -> bindParam(1,$triptitle);   //プレイスホルダー（値が未確定だったところに値を紐づける）
      $stmt -> bindParam(2,$day);
      $stmt -> bindParam(3,$place);
      $stmt -> bindParam(4,$spot);
      $stmt -> bindParam(5,$comment);
      $stmt -> bindParam(6,$remarks);
      $stmt -> bindParam(7,$userid);
      $stmt -> execute(); //保留していたSQLを実行
      
    }catch(PDOException $e){
      echo "接続失敗・・・";
      echo "エラー内容：".$e->getMessage();
    }
    

    echo "登録完了";
    echo "さらに追加";
    echo "過去のデータを見る";
    echo "TOPに戻る";

    // //リダイレクト
    // header('Location: check.php');
    // exit;

