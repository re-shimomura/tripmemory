
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
        SELECT id, triptitle, day, place, spot, comment, remarks
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
        $spot = $_POST['spot'];
        $comment = $_POST['comment'];
        $remarks = $_POST['remarks'];

        $sql = <<<sql
        UPDATE material
        SET triptitle = ?, day = ?, place = ?, spot = ?, comment = ?, remarks = ?
        WHERE id = ?;
sql;

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $triptitle);
        $stmt->bindParam(2, $day);
        $stmt->bindParam(3, $place);
        $stmt->bindParam(4, $spot);
        $stmt->bindParam(5, $comment);
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
    <title>編集</title>
</head>
<body>
    <h2>データ編集</h2>
    <?php if (isset($data)) { ?>
    <form method="POST" action="edit.php">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <label for="triptitle">旅のタイトル:</label>
        <input type="text" name="triptitle" id="triptitle" value="<?php echo $data['triptitle']; ?>"><br>

        <label for="day">日付:</label>
        <input type="date" name="day" id="day" value="<?php echo $data['day']; ?>"><br>

        <label for="place">目的地:</label>
        <input type="text" name="place" id="place" value="<?php echo $data['place']; ?>"><br>

        <label for="spot">スポット:</label>
        <input type="text" name="spot" id="spot" value="<?php echo $data['spot']; ?>"><br>

        <label for="comment">コメント:</label>
        <input type="text" name="comment" id="comment" value="<?php echo $data['comment']; ?>"><br>

        <label for="remarks">備考:</label>
        <input type="text" name="remarks" id="remarks" value="<?php echo $data['remarks']; ?>"><br>

        <button type="submit" name="update">更新</button>
    </form>
    <?php } else { ?>
    <p>データが見つかりません。</p>
    <?php } ?>
</body>
</html>
