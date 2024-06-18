
<?php
session_start();
// データベース接続情報
$dsn = "mysql:host=localhost;dbname=tripmemory;charset=utf8";
$user = "testuser";
$pass = "testpass";

try {
    // データベースに接続
    $dbh = new PDO($dsn, $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 編集対象のデータを取得
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = <<<sql
        SELECT id, triptitle, day, place, spot1, comment1, remarks
        FROM material
        WHERE id = ?;
sql;

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        // データを取得
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 更新処理
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $triptitle = $_POST['triptitle'];
        $day = $_POST['day'];
        $place = $_POST['place'];
        $spot1 = $_POST['spot1'];
        $comment1 = $_POST['comment1'];
        $remarks = $_POST['remarks'];

        $sql = <<<sql
        UPDATE material
        SET triptitle = ?, day = ?, place = ?, spot1 = ?, comment1 = ?, remarks = ?
        WHERE id = ?;
sql;

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $triptitle);
        $stmt->bindParam(2, $day);
        $stmt->bindParam(3, $place);
        $stmt->bindParam(4, $spot1);
        $stmt->bindParam(5, $comment1);
        $stmt->bindParam(6, $remarks);
        $stmt->bindParam(7, $id);
        $stmt->execute();

        // 更新後にリダイレクト
        header('Location: show.php');
        exit;
    }
} catch (PDOException $e) {
    // エラー処理
    echo "接続失敗: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css">
    <title>編集</title>
</head>
<body>
    <section class="contr">
    <h2 class="head">データ編集</h2>
        <?php if (isset($data)) { ?>
        <form method="POST" action="edit.php">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <label for="triptitle">旅のタイトル</label><br>
            <input type="text" name="triptitle" id="triptitle" value="<?php echo $data['triptitle']; ?>"><br>

            <label for="day">日付</label><br>
            <input type="date" name="day" id="day" value="<?php echo $data['day']; ?>"><br>

            <label for="place">目的地</label><br>
            <input type="text" name="place" id="place" value="<?php echo $data['place']; ?>"><br>

            <label for="spot1">スポット</label><br>
            <input type="text" name="spot1" id="spot1" value="<?php echo $data['spot1']; ?>"><br>

            <label for="comment1">コメント</label><br>
            <input type="text" name="comment1" id="comment1" value="<?php echo $data['comment1']; ?>"><br>

            <label for="remarks">備考</label><br>
            <input type="text" name="remarks" id="remarks" value="<?php echo $data['remarks']; ?>"><br>

            <button type="submit" name="update">更新</button>
        </section>
    </form>
    <?php } else { ?>
    <p>データが見つかりません。</p>
    <?php } ?>
</body>
</html>
