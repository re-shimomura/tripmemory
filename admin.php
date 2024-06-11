<?php

echo "admin画面";


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
    $sql = "SELECT userid, password, permission FROM users";
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
    <h2>ユーザ一覧</h2>
    <table border="1">
        <tr>
            <th>userid</th>
            <th>password</th>
            <th>permisson</th>

        </tr>
        <?php foreach ($result as $row){?>
        <tr>
            <td><?php echo $row['userid']; ?></td>
            <td><?php echo $row['password']; ?></td>
            <td><?php echo $row['permission']; ?></td>

        </tr>
        <?php } ?>
    </table>

    <form method="post" action="logout.php">
        <button type="submit">ログアウト</button>
    </form>
</body>
</html>