<?php
  session_start();
  // フォームから送信されたデータを受け取る処理
  if(isset($_POST["triptitle"])) {
      $triptitle = $_POST["triptitle"];   
      $day = $_POST["day"];
      $place = $_POST["place"];
      $remarks = $_POST["remarks"];

    // スポットとコメントの配列を初期化
    $spot = [];
    $comment = [];

    // 入力フォームから受け取ったスポットとコメントのデータを配列に追加
    for ($i = 0; $i < 5; $i++) {
        if (isset($_POST["spot"][$i])) {
            $spot[] = $_POST["spot"][$i];
            $comment[] = $_POST["comment"][$i];
        }
    }

    // セッションに保存
    $_SESSION["triptitle"] = $triptitle;
    $_SESSION["day"] = $day;
    $_SESSION["place"] = $place;
    $_SESSION["spot"] = $spot;
    $_SESSION["comment"] = $comment;
    $_SESSION["remarks"] = $remarks;
  }

  // 入力内容を確認して表示するHTMLコンテンツを生成
  $content = <<< HTML
  <!DOCTYPE html>
  <html lang="ja">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>確認画面</title>
  </head>
  <body>
  
      <h2>入力内容の確認</h2>
        <p>
          ■旅のタイトル<br>
          {$_SESSION["triptitle"]}
        </p>

        <hr color="#ff8c00" width="300px" align="left">
        
        <p>
          ■日付<br>
          {$_SESSION["day"]}
        </p>

        <hr color="#ff8c00" width="300px" align="left">
        
        <p>
          ■目的地<br>
          {$_SESSION["place"]}
        </p>

        <p>
          ■スポット1<br>
          {$_SESSION["spot"][0]}
        </p>

        <p>
          ■コメント<br>
          {$_SESSION["comment"][0]}
        </p>
HTML;

  // スポットとコメントの数だけループして表示
  for ($i = 0; $i < count($_SESSION["spot"]); $i++) {
      $spotNum = $i + 1;
      $content .= <<< HTML
        <hr color="#ff8c00" width="300px" align="left">
        <p>
          ■スポット{$spotNum}<br>
          {$_SESSION["spot"][$i]}
        </p>

        <hr color="#ff8c00" width="300px" align="left">
        
        <p>
          ■コメント{$spotNum}<br>
          {$_SESSION["comment"][$i]}
        </p>
HTML;
  }

  $content .= <<< HTML
        <hr color="#ff8c00" width="300px" align="left">
        
        <p>
          ■備考<br>
          {$_SESSION["remarks"]}
        </p>

        <p>入力内容に間違いがなければ、送信ボタンを押してください。</p>
        <form action="system.php" method="post">
          <input type="submit" name="submit" value="送信">
          <!-- hiddenのデータを送信する -->
          <input type="hidden" name="triptitle" value="{$_SESSION["triptitle"]}">
          <input type="hidden" name="day" value="{$_SESSION["day"]}">
          <input type="hidden" name="place" value="{$_SESSION["place"]}">
          <input type="hidden" name="remarks" value="{$_SESSION["remarks"]}">
HTML;

  // スポットとコメントの数だけhiddenを追加
  for ($i = 0; $i < count($_SESSION["spot"]); $i++) {
      $content .= <<< HTML
          <input type="hidden" name="spot[]" value="{$_SESSION["spot"][$i]}">
          <input type="hidden" name="comment[]" value="{$_SESSION["comment"][$i]}">
HTML;
  }

  $content .= <<< HTML
        </form>
        <p><a href="input.html">入力を修正する</a></p>
      
  </body>
  </html>
HTML;

  echo $content;
  ?>
