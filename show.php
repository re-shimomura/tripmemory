<?php
session_start();
// データベース接続情報
$dsn = "mysql:host=localhost;dbname=tripmemory;charset=utf8";
$user = "testuser";
$pass = "testpass";
// フォームから送信されたデータを受け取る処理


    $userid = $_SESSION["userid"];

    try {
        // データベースに接続
        $dbh = new PDO($dsn, $user, $pass);
        // エラーモードを例外に設定
        //エラーが発生すると、PDOExceptionがスローされる。→エラーの詳細を取得してスクリプトの実行は中断される
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // データを取得するクエリ
        $sql=<<<sql
        SELECT triptitle, day, place, spot, comment, remarks FROM material WHERE userid = ?;

sql;
        // プレイスホルダー
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $userid);
        $stmt->execute();

        // クエリ実行→queryメソッドはSELECT文などで主に使われるらしいためここではqueryメソッドを使う
        // $stmt = $dbh->query($sql);

        //fetchAllメソッドはクエリの結果のすべての行を一度の取得する
        //PDO::FETCH_ASSOCパラメータは、結果を連想配列として取得するように指定している
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // キーワード検索処理
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
        $keyword = "%".$keyword."%";
        if (!empty($keyword)) {
        $sql=<<<sql
        SELECT *
        FROM material
        WHERE userid = ? 
        AND (triptitle LIKE ? OR place LIKE ? OR spot LIKE ? OR comment LIKE ? OR remarks LIKE ?);


sql;

        // プレイスホルダー
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $userid);
        $stmt->bindParam(2, $keyword);
        $stmt->bindParam(3, $keyword);
        $stmt->bindParam(4, $keyword);
        $stmt->bindParam(5, $keyword);
        $stmt->bindParam(6, $keyword);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);



    }
    } catch (PDOException $e) {
        // エラー処理
        echo "接続失敗: " . $e->getMessage();
    }

// データベース接続解除
//$dbh = null;
//データベースから取得したデータをHTMLテーブル形式で表示
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データ一覧</title>
</head>
<body>
    <h2>登録データ一覧</h2>
    <table border="1">
        <tr>
            <th>旅のタイトル</th>
            <th>日付</th>
            <th>目的地</th>
            <th>スポット</th>
            <th>コメント</th>
            <th>備考</th>
        </tr>
        <?php foreach ($result as $row){ ?>
        <tr>
            <td><?php echo $row['triptitle']; ?></td>
            <td><?php echo $row['day']; ?></td>
            <td><?php echo $row['place']; ?></td>
            <td><?php echo $row['spot']; ?></td>
            <td><?php echo $row['comment']; ?></td>
            <td><?php echo $row['remarks']; ?></td>
        </tr>
        <?php }?>

        
    </table>
    <p><a href="selectMenu.html">TOPに戻る</a></p>

    <form method="GET" action="show.php">
        <label for="keyword">キーワード検索:</label>
        <input type="text" name="keyword" id="keyword">
        <button type="submit">検索</button>
    </form>

</body>
</html>
