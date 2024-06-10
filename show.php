<?php

// データベース接続情報
$dsn = "mysql:host=localhost;dbname=tripmemory;charset=utf8";
$user = "testuser";
$pass = "testpass";

try {
    // データベースに接続
    $dbh = new PDO($dsn, $user, $pass);
    // エラーモードを例外に設定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データを取得するクエリ
    $sql = "SELECT triptitle, day, place, spot, comment, remarks FROM material";
    // クエリ実行
    $stmt = $dbh->query($sql);
    // 結果を連想配列として取得
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // エラー処理
    echo "接続失敗: " . $e->getMessage();
}

// データベース接続解除
$dbh = null;
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
        <?php foreach ($result as $row): ?>
        <tr>
            <td><?php echo $row['triptitle']; ?></td>
            <td><?php echo $row['day']; ?></td>
            <td><?php echo $row['place']; ?></td>
            <td><?php echo $row['spot']; ?></td>
            <td><?php echo $row['comment']; ?></td>
            <td><?php echo $row['remarks']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
