<?php
session_start();
include('functions.php');
chk_ssid();
chk_kanri_flg();


//1. DB接続
$pdo=db_conn();
// $dbn='mysql:dbname=gs_f02_db22;charset=utf8;port=3306;host=localhost';
// $user='root';
// $pwd='';

// try{
//     $pdo=new PDO($dbn,$user,$pwd);
// } catch(PDOException $e){
//     exit('dbError:'.$e->getMessage());
// }


//2. データ表示SQL作成
$sql = 'SELECT * FROM user_table WHERE life_flg=0 ORDER BY name ASC LIMIT 100';
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
        $view .= '<p>'.'ユーザー名'.'<strong>： '.$result['name'].'</strong></p>';
        $view .= '<p>'.'ユーザーID： '.$result['lid'].'</p>';
        $view .= '<a href="user_detail.php?id='.$result['id'].'" class="badge badge-primary">更新</a>';
        $view .= '<a href="user_delete.php?id='.$result['id'].'" class="badge badge-danger">削除</a>';
        $view .= '</li>';
        // 本当に削除していいですか？のワンクッション入れたい
    }
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ユーザー表示</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
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
            <a class="navbar-brand" href="#">ユーザー管理</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="top.php">トップページ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="select.php">データ一覧</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">データ登録</a>
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
        </nav>
    </header>

    <div>
        <ul class="list-group">
            <!-- ここにDBから取得したデータを表示しよう -->
            <?=$view?>
        </ul>
    </div>

</body>

</html>