<?php
session_start();
// データベース接続情報
$dsn = "mysql:host=localhost;dbname=tripmemory;charset=utf8";
$user = "testuser";
$pass = "testpass";
// フォームから送信されたデータを受け取る処理

    // // セッションにuseridが設定されているか確認 
    // if (!isset($_SESSION["userid"])) {
    //     // useridが設定されていない場合、ログインページにリダイレクトするか、エラーメッセージを表示する
    //     echo "ユーザーがログインしていません。ログインしてください。";
    //     exit;
    // }
    $userid = $_SESSION["userid"];

    try {
        // データベースに接続
        $dbh = new PDO($dsn, $user, $pass);
        // エラーモードを例外に設定
        //エラーが発生すると、PDOExceptionがスローされる。→エラーの詳細を取得してスクリプトの実行は中断される
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // データを取得するクエリ
        $sql=<<<sql
        SELECT triptitle, day, place, spot1, comment1, remarks FROM material WHERE userid = ?;

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

            //ユーザを無効にするための処理
        if (isset($_GET["mode"]) && $_GET["mode"] == "delete")
        {
            //sql文を用意
            $sql=<<<sql
            UPDATE material
            SET flag = 1
            WHERE id = ?;
sql;

            $stmt=$dbh->prepare($sql);
            $stmt->bindParam(1,$_GET["id"]);
            //sql実行
            $stmt->execute();
        }

        // キーワード検索処理
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
        $keyword = "%".$keyword."%";
        if (!empty($keyword)) {
        $sql=<<<sql
        SELECT *
        FROM material
        WHERE userid = ? 
        AND (triptitle LIKE ? OR place LIKE ? OR spot1 LIKE ? OR comment1 LIKE ? OR remarks LIKE ?);

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
    <link rel="stylesheet" href="show.css">
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>データ一覧</title>
</head>
<body>
    <h2>登録データ一覧</h2>
    <div class="table_scroll">
        <table  class="table">
        <!-- <table>             -->
            <thead>
                <tr>
                    <th>旅のタイトル</th>
                    <th>日付</th>
                    <th>目的地</th>
                    <th>スポット1</th>
                    <th>コメント1</th>
                    <th>スポット2</th>
                    <th>コメント2</th>
                    <th>スポット3</th>
                    <th>コメント3</th>
                    <th>スポット4</th>
                    <th>コメント4</th>
                    <th>スポット5</th>
                    <th>コメント5</th>
                    <th>備考</th>
                </tr>
            </thead>
                
            <?php foreach ($result as $row){ ?>
                <?php if ($row["flag"] == 0){ ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row['triptitle']; ?></td>
                            <td><?php echo $row['day']; ?></td>
                            <td><?php echo $row['place']; ?></td>
                            <td><?php echo $row['spot1']; ?></td>
                            <td><?php echo $row['comment1']; ?></td>
                            <td><?php echo $row['spot2']; ?></td>
                            <td><?php echo $row['comment2']; ?></td>
                            <td><?php echo $row['spot3']; ?></td>
                            <td><?php echo $row['comment3']; ?></td>
                            <td><?php echo $row['spot4']; ?></td>
                            <td><?php echo $row['comment4']; ?></td>
                            <td><?php echo $row['spot5']; ?></td>
                            <td><?php echo $row['comment5']; ?></td>
                            <td><?php echo $row['remarks']; ?></td>
                            <td>
                                <form action="edit.php" method="get">
                                        <input class="edit" type="submit" value="編集"></input>
                                        <input type="hidden" name="mode" value="edit">
                                        <input type="hidden" name="id" value=<?php echo $row['id']; ?>>
                                </form>
                            </td>
                            <td>
                                <form action="show.php" method="get">
                                    <input class="delete"  type="submit" value="削除"></input>
                                    <input type="hidden" name="mode" value="delete">
                                    <input type="hidden" name="id" value=<?php echo $row['id']; ?>>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                <?php } ?>
            <?php }?>

            
        </table>
    </div>
    <div class="toTopbutton">
        <a href="selectmenu.html">TOPに戻る</a>
    </div>
  
</body>
</html>

