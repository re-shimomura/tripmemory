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
      <link rel="stylesheet" href="check.css">
      <link rel="stylesheet" href="reset.css">
  </head>
  <body>
  <section class="contr">
      <h2 class="head">入力内容の確認</h2>

      <p class="inputindex">旅のタイトル</p>
      <p class="input">{$_SESSION["triptitle"]}</p>

      <p class="inputindex">日付</p>
      <p class="input">{$_SESSION["day"]}</p>

      <p class="inputindex">目的地</p>
      <p class="input">{$_SESSION["place"]}</p>

      <p class="inputindex">スポット1</p>
      <p class="input">{$_SESSION["spot"][0]}</p>

      <p class="inputindex">コメント</p>
      <p class="input">{$_SESSION["comment"][0]}</p>
  </section>
HTML;

  // スポットとコメントの数だけループして表示
  for ($i = 1; $i < count($_SESSION["spot"]); $i++) {
      $spotNum = $i + 1;
      $content .= <<< HTML
   <section class="contr">
        <p class="inputindex">スポット{$spotNum}</p><br>
        <p class="input">{$_SESSION["spot"][$i]}</p>

        <p class="inputindex">コメント{$spotNum}</p><br>
        <p class="input">{$_SESSION["comment"][$i]}</p>
  </section>
HTML;
  }

  $content .= <<< HTML
    <section class="contr">
        <p class="inputindex">備考</p><br>
        <p class="input">{$_SESSION["remarks"]}</p>

        <p>入力内容に間違いがなければ、送信ボタンを押してください。</p>
        <form action="system.php" method="post">
          <input class="button" type="submit" name="submit" value="送信">
          <!-- hiddenのデータを送信する -->
          <input type="hidden" name="triptitle" value="{$_SESSION["triptitle"]}">
          <input type="hidden" name="day" value="{$_SESSION["day"]}">
          <input type="hidden" name="place" value="{$_SESSION["place"]}">
          <input type="hidden" name="remarks" value="{$_SESSION["remarks"]}">

HTML;

  // スポットとコメントの数だけhiddenを追加
  for ($i = 1; $i < count($_SESSION["spot"]); $i++) {
      $content .= <<< HTML
          <input type="hidden" name="spot[]" value="{$_SESSION["spot"][$i]}">
          <input type="hidden" name="comment[]" value="{$_SESSION["comment"][$i]}">
HTML;
  }

  $content .= <<< HTML
        </form>
          <div class="editbutton">
            <a href="input.html">入力を修正する</a>
          </div>
      </section>

  </body>
  </html>
HTML;

  echo $content;
  ?>
