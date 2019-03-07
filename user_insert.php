<?php
include('functions.php');


// 入力チェック
if(
    !isset($_POST['name']) || $_POST['name']=='' ||
    !isset($_POST['lid']) || $_POST['lid']=='' ||
    !isset($_POST['lpw']) || $_POST['lpw']==''
){
    exit('ParamError');
}

//POSTデータ取得
$name=$_POST['name'];
$lid=$_POST['lid'];
$lpw=$_POST['lpw'];

//DB接続
$pdo=db_conn();
// $dbn = 'mysql:dbname=gs_f02_db22;charset=utf8;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// try {
//     $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//     exit('dbError:'.$e->getMessage());
// }

//データ登録SQL作成
$sql ='INSERT INTO user_table(id,name,lid,lpw,kanri_flg,life_flg)VALUES(null,:a1,:a2,:a3,0,0)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $lid, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $lpw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();  //実行！

//４．データ登録処理後
if ($status==false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    //５．index.phpへリダイレクト
    header('Location: login.php');  //Location:の後は半角スペース必須
}
