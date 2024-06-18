<?php
session_start();
// データベース接続情報
$dsn = "mysql:host=localhost;dbname=tripmemory;charset=utf8";
$user = "testuser";
$pass = "testpass";
// フォームから送信されたデータを受け取る処理

    // // セッションにuseridが設定されているか確認 デバッグ用
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
        SELECT triptitle, day, place, spot1, comment1, spot2, comment2, spot3, comment3, spot4, comment4, spot5, comment5, remarks FROM material WHERE userid = ?;

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
        AND (triptitle LIKE ? OR place LIKE ? OR spot1 LIKE ? OR comment1 LIKE ?OR spot2 LIKE ? OR comment2 LIKE ?OR spot3 LIKE ? OR comment3 LIKE ?OR spot4 LIKE ? OR comment4 LIKE ?OR spot5 LIKE ? OR comment5 LIKE ? OR remarks LIKE ?);

sql;

        // プレイスホルダー
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $userid);
        $stmt->bindParam(2, $keyword);
        $stmt->bindParam(3, $keyword);
        $stmt->bindParam(4, $keyword);
        $stmt->bindParam(5, $keyword);
        $stmt->bindParam(6, $keyword);
        $stmt->bindParam(7, $keyword);
        $stmt->bindParam(8, $keyword);
        $stmt->bindParam(9, $keyword);
        $stmt->bindParam(10, $keyword);
        $stmt->bindParam(11, $keyword);
        $stmt->bindParam(12, $keyword);
        $stmt->bindParam(13, $keyword);
        $stmt->bindParam(14, $keyword);
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
        <section class="contr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <link rel="stylesheet" href="showlist.css">
        <title>検索結果表示</title>

        <style>
            .eventbutton{
                cursor: pointer;
            }
            .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
            }


            dl {
                display: none;
            }
        </style>
    </head>
    <body>
        <h2 class="head">検索画面</h2>
        <form class="search_container" method="GET" action="showlist.php">
            <input type="text" name="keyword" id="keyword" placeholder="キーワード検索">
            <button type="submit">検索</button>
        </form>
        <?php foreach ($result as $row): ?>
            <?php if ($row["flag"] == 0){ ?>
                <div class="resultshow">
                    <p class="eventbutton" title="<?php echo $row['triptitle']; ?> <?php echo $row['place']; ?>"><?php echo $row['triptitle']; ?> ・ <?php echo $row['place']; ?><span class="material-symbols-outlined">expand_circle_down</span></p> 

                    <dl>
                        <?php if (!empty($row['spot1'])): ?>
                            <dt class="subtitle">スポット1</dt>
                            <dd class="contents"><?php echo $row['spot1']; ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($row['comment1'])): ?>
                            <dt class="subtitle">コメント1</dt>
                            <dd class="contents"><?php echo $row['comment1']; ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($row['spot2'])): ?>
                            <dt class="subtitle">スポット2</dt>
                            <dd class="contents"><?php echo $row['spot2']; ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($row['comment2'])): ?>
                            <dt class="subtitle">コメント2</dt>
                            <dd class="contents"><?php echo $row['comment2']; ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($row['spot3'])): ?>
                            <dt class="subtitle">スポット3</dt>
                            <dd class="contents"><?php echo $row['spot3']; ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($row['comment3'])): ?>
                            <dt class="subtitle">コメント3</dt>
                            <dd class="contents"><?php echo $row['comment3']; ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($row['spot4'])): ?>
                            <dt class="subtitle">スポット4</dt>
                            <dd class="contents"><?php echo $row['spot4']; ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($row['comment4'])): ?>
                            <dt class="subtitle">コメント4</dt>
                            <dd class="contents"><?php echo $row['comment4']; ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($row['spot5'])): ?>
                            <dt class="subtitle">スポット5</dt>
                            <dd class="contents"><?php echo $row['spot5']; ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($row['comment5'])): ?>
                            <dt class="subtitle">コメント5</dt>
                            <dd class="contents"><?php echo $row['comment5']; ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($row['remarks'])): ?>
                            <dt class="subtitle">備考</dt>
                            <dd class="contents"><?php echo $row['remarks']; ?></dd>
                        <?php endif; ?>
                    </dl>
                </div>
                <?php } ?>
            <?php endforeach; ?>
    </section>

        <div class="toTopbutton">
            <a href="selectmenu.html">TOPに戻る</a>
        </div>

    <script>
        // JavaScriptでクリックイベントを追加
        document.querySelectorAll('.eventbutton').forEach(function(button) {
            button.addEventListener('click', function() {
                var dl = this.nextElementSibling;
                if (dl.style.display === 'none' || dl.style.display === '') {
                    dl.style.display = 'block';
                    var valueTitle = this.title;
                    //ボタンのデザインの変更をここにかく
                    this.innerHTML = valueTitle+' '+'<span class="material-symbols-outlined">expand_circle_up</span>';

                } else {
                    dl.style.display = 'none';
                    var valueTitle = this.title;
                    //ボタンのデザインの変更をここにかく
                    this.innerHTML = valueTitle+' '+'<span class="material-symbols-outlined">expand_circle_down</span>';
                }
            });
        });
    </script>
</body>
</html>

