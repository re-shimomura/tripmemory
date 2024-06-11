<?php
session_start();

// セッションを破棄してログアウト
session_destroy();

// ログインページにリダイレクト
header('Location: index.html');
exit;
?>
