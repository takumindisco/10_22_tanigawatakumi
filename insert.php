<?php
session_start();
include('functions.php'); 
chk_ssid();

// 入力チェック
if(
    !isset($_POST['name']) || $_POST['name']=='' ||
    !isset($_POST['comment']) || $_POST['comment']==''
){
    exit('ParamError');
}

//POSTデータ取得
$name=$_POST['name'];
$comment=$_POST['comment'];

// Fileアップロードチェック
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] ==0) {
    // ファイルをアップロードしたときの処理
    // ①送信ファイルの情報取得
    $file_name=$_FILES['upfile']['name'];
    $tmp_path=$_FILES['upfile']['tmp_name'];
    $file_dir_path='upload/';

    // ②File名の準備
    $extension=pathinfo($file_name,PATHINFO_EXTENSION);
    $uniq_name=date('YmdHis').md5(session_id()).".".$extension;
    $file_name=$file_dir_path.$uniq_name;    

    // ③サーバの保存領域に移動&④表示
    if(is_uploaded_file($tmp_path)){
        if(move_uploaded_file($tmp_path,$file_name)){
            chmod($file_name,0644);
        } else{
            ('Error:アップロードできませんでした');
        }
    }

} else {
    // ファイルをアップしていないときの処理
    exit('画像が送信されていません');
}

//DB接続
$pdo=db_conn();

//データ登録SQL作成
$sql ='INSERT INTO chat_table(id,name,comment,image,indate)VALUES(null,:a1,:a2,:image,sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindvalue(':image', $file_name, PDO::PARAM_STR);
$status = $stmt->execute();  //実行！

//４．データ登録処理後
if ($status==false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    //５．index.phpへリダイレクト
    header('Location: select.php');  //Location:の後は半角スペース必須
}
