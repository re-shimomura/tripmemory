<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選択画面</title>

    <style>
        

    *,
    *:before,
    *:after {
    -webkit-box-sizing: inherit;
    box-sizing: inherit;
    }

    html {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    font-size: 62.5%;
    }

    /* 背景用*/
    body {
    padding: 30px;
    background: #eae83a;
    }

    .btn,
    a.btn,
    button.btn {
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1.5;
    position: relative;
    display: inline-block;
    padding: 1rem 4rem;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    text-align: center;
    vertical-align: middle;
    text-decoration: none;
    letter-spacing: 0.1em;
    color: #212529;
    border-radius: 0.5rem;
    }

    a.btn-border-shadow {
    padding: calc(1.5rem - 12px) 3rem 1.5rem;

    background: #fff;
    }

    a.btn-border-shadow:before {
    position: absolute;
    top: -6px;
    left: -6px;

    width: 100%;
    height: 100%;

    content: "";
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;

    border: 3px solid #000;
    border-radius: 0.5rem;
    }

    a.btn-border-shadow:hover {
    padding: calc(1.5rem - 6px) 3rem;
    }

    a.btn-border-shadow:hover:before {
    top: 0;
    left: 0;
    }


    </style>
</head>
<body>
    <h1>なにをする？</h1>
    
    <div class="btn-wrap">
    <a href="" class="btn btn-border-shadow">旅の記録を追加</a>
    </div>

    <div class="btn-wrap">
    <a href="" class="btn btn-border-shadow">旅の記録を見る</a>
    </div>


</body>
</html>
