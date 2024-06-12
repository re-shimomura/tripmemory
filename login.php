<?php
    session_start();
    // DB接続に必要な情報をまとめておきます

    use function PHPSTORM_META\sql_injection_subst;

    $dsn = "mysql:host=localhost;dbname=tripmemory;charset=utf8";
    $user = "testuser";
    $pass = "testpass";

    try {
        // DBに接続します
        $dbh = new PDO($dsn, $user, $pass);

        // フォームから送信されたデータを受け取る処理
        if (isset($_POST["userid"])) 
        {
            $userid = $_POST["userid"];
            $password = $_POST["password"];

            // SQL文の用意
            $sql = <<<sql
            SELECT * FROM users WHERE userid = ? AND password = ? 
            
sql;

            // プレイスホルダー
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(1, $userid);
            $stmt->bindParam(2, $password);
            $stmt->execute();


            // 結果を取得
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //flagが1だったらログインできないようにする
            if (isset($result[0]["flag"]) && $result[0]["flag"] == 1){
                echo "無効なアカウントです";
                //header('Location: login.html');
                exit;
            }

            if ($result[0]["permission"] == "admin" ){
                header('Location: admin.php');
                exit;
            }else if ($stmt->rowCount() > 0) {
                // echo "ログイン成功";
                // ログイン成功時の処理をここに記術
                $_SESSION["userid"] = $userid;
                header('Location: selectMenu.html');
            }else{
                echo "ユーザー名またはパスワードが間違っています";
            }
        }
    } catch (PDOException $e) {
        echo "接続失敗・・・";
        echo "エラー内容：" . $e->getMessage();
    }
?>
