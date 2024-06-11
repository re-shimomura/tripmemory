<?php
session_start();
// フォームから送信されたデータを受け取る処理
if(isset($_POST["triptitle"])) {
    $triptitle = $_POST["triptitle"];   
    $day = $_POST["day"];
    $place = $_POST["place"];
    $spot = $_POST["spot"];
    $comment = $_POST["comment"];
    $remarks = $_POST["remarks"];

    $_SESSION["triptitle"] = $triptitle;
    $_SESSION["day"] = $day;
    $_SESSION["place"] = $place;
    $_SESSION["spot"] = $spot;
    $_SESSION["comment"] = $comment;
    $_SESSION["remarks"] = $remarks;
}

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

      <hr color="#ff8c00" width="300px" align="left">
      
      <p>
        ■スポット<br>
        {$_SESSION["spot"]}
      </p>

      <hr color="#ff8c00" width="300px" align="left">
      
      <p>
        ■コメント<br>
        {$_SESSION["comment"]}
      </p>

      <hr color="#ff8c00" width="300px" align="left">
      
      <p>
        ■備考<br>
        {$_SESSION["remarks"]}
      </p>

      <p>入力内容に間違いがなければ、送信ボタンを押してください。</p>
      <form action="system.php" method="post">
        <input type="submit" name="submit" value="送信">
        <input type="hidden" name = "triptitle" value = {$_SESSION["triptitle"]}>
        <input type="hidden" name = "day" value = {$_SESSION["day"]}>
        <input type="hidden" name = "place" value = {$_SESSION["place"]}>
        <input type="hidden" name = "spot" value = {$_SESSION["spot"]}>
        <input type="hidden" name = "comment" value = {$_SESSION["comment"]}>
        <input type="hidden" name = "remarks" value = {$_SESSION["remarks"]}>

      </form>
      <p><a href="">入力を修正する</a></p>
    
</body>
</html>
HTML;
echo $content;
?>