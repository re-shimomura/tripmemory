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

    //ユーザを無効にするための処理
    if (isset($_GET["mode"]) && $_GET["mode"] == "delete"){
        //sql文を用意
        $sql=<<<sql
        UPDATE users
        SET flag = 1
        WHERE userid = ?;
sql;

        $stmt=$dbh->prepare($sql);
        $stmt->bindParam(1,$_GET["userid"]);
        //sql実行
        $stmt->execute();
    }


    // データを取得するクエリ
    $sql = "SELECT userid, password, permission, flag FROM users";
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
    <link rel="stylesheet" href="admin.css">
    <title>データ一覧</title>
</head>
<body>
    <section class="contr">
        <h2>ユーザ一覧</h2>
        <table class="table">
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
                <td><?php echo $row['flag']; ?></td>
                <td>        
                    <form action="admin.php" method="get">
                        <input type="submit" value="無効"></input>
                        <input type="hidden" name="mode" value="delete">
                        <input type="hidden" name="userid" value=<?php echo $row['userid']; ?>>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>

        <form method="post" action="logout.php">
            <button type="submit">ログアウト</button>
        </form>
    </section>
</body>
</html>