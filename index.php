<?php
session_start();
include('functions.php');
chk_ssid();

//1. DB接続
$pdo=db_conn();

//2. データ表示SQL作成
$sql = 'SELECT * FROM chat_table ORDER BY id DESC LIMIT 100';  //更新順にしたい
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//3. データ表示
$view='';
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    //Selectデータの数だけ自動でループしてくれる
    //http://php.net/manual/ja/pdostatement.fetch.php
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {    //fetchで一行ずつもってくる whileでレコード分繰り返し
        $view .= '<li class="list-group-item">';
        $view .= '<span><strong>投稿者：'.$_SESSION['name'].'   </strong></span>'; //投稿者
        $view .= '<span align=right><font size="2">  -   投稿日時：'.$result['indate'].'</font></span>';
        $view .= '<p><strong>『 '.$result['name'].' 』</strong></p>'; //タイトル
        $view .= '<p>'.$result['comment'].'</p>'; //メッセージ
        $view .= '<img src="'.$result['image'].'" alt="" height="150px">';   //画像
        $view .= '</li>';
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DBチャット</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- BootstrapCDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>


<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">データ一覧</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="top.php">トップページ</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="index.php">掲示板</a>
                    </li>
                    <?php if ($_SESSION['kanri_flg'] == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="user_index_admin.php">ユーザー登録</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_select.php">ユーザー管理</a>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">ログアウト</a>
                    </li>
                </ul>
            </div>
            <div>
            </div>
        </nav>
    </header>

    <form action="insert.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">タイトル</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter task">
        </div>
        <div class="form-group">
            <label for="comment">コメント</label>
            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="upfile">画像</label>
            <!-- inputを追加 -->
            <input type="file" class="form-control-file" id="upfile" name="upfile" accept="image/*" capture="camera">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">登録する</button>
        </div>
    </form>

    <div>
        <ul class="list-group">
            <!-- ここにDBから取得したデータを表示しよう -->
            <?=$view?>
        </ul>
    </div>

</body>

</html>