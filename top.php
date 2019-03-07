<?php
session_start();
include('functions_select.php');
chk_ssid();
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>トップページ</title>
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
            <a class="navbar-brand" href="#">トップページ</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="select.php">データ一覧</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">データ登録</a>
                    </li>
                </ul>
                <?php if ($_SESSION['kanri_flg'] == 1) { ?>
                <ul class="navbar-nav" id="admin_menu" style="display: inline">
                    <li class="nav-item">
                        <a class="nav-link" href="user_index_admin.php">ユーザー登録</a>
                    </li>
                </ul>
                <ul class="navbar-nav" id="admin_menu" style="display: inline">
                    <li class="nav-item">
                        <a class="nav-link" href="user_select.php">ユーザー管理</a>
                    </li>
                </ul>
                <?php } ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">ログアウト</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="">
        <ul class="">
            <li class="list-group-item">
                <a class="" href="select.php">データ一覧</a>
            </li>
            <li class="list-group-item">
                <a class="" href="index.php">データ登録</a>
            </li>
            <?php if ($_SESSION['kanri_flg'] == 1) { ?>
            <li class="list-group-item" id="admin_menu">
                <a class="" href="user_index_admin.php">ユーザー登録</a>
            </li>
            <li class="list-group-item" id="admin_menu">
                <a class="" href="user_select.php">ユーザー管理</a>
            </li>
            <?php } ?>
            <li class="list-group-item">
                <a class="" href="logout.php">ログアウト</a>
            </li>
        </ul>
    </div>

</body>

</html>