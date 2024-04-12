<!-- kadai09_PHP03 DB操作(更新・削除)_insert.php (PHPのみ) --> 
<?php
//0.まずこれをしてからコードを書き始める！
//index.phpでPOSTしたデータが受け取れているかを確認する.
//確認ができたら以下4行はコメントアウトすること！
//echo('<pre>');
//var_dump($_POST);
//echo('</pre>');
//exit;

//1. POSTデータ取得 index.php で入力した(POSTされた）データを受け取る.
$rest_name = $_POST["rest_name"];
$genre     = $_POST["genre"];
$url       = $_POST["url"];
$memo      = $_POST["memo"];
$name      = $_POST["name"];

//2. DB接続 関数化した関数db_conn()を使う.
include("funcs.php"); //まず、include関数でfuncs.phpを読み込む.
$pdo = db_conn();

//3.データ登録SQL作成
$sql ="INSERT INTO rest_table(rest_name,genre,url,memo,name,indate)VALUES(:rest_name,:genre,:url,:memo,:name,sysdate());";
$stmt = $pdo->prepare($sql);
// bindValueを使ってDBに被害を及ぼすコマンドを無効化する.危ない文字をクリーンにする.
$stmt->bindValue(':rest_name', $rest_name, PDO::PARAM_STR); //varcharの場合 PDO::PARAM_STR
$stmt->bindValue(':genre',     $genre,     PDO::PARAM_STR); //varcharの場合 PDO::PARAM_STR
$stmt->bindValue(':url',       $url,       PDO::PARAM_STR); //varcharの場合 PDO::PARAM_STR
$stmt->bindValue(':memo',      $memo,      PDO::PARAM_STR); //Textの場合 PDO::PARAM_STR
$stmt->bindValue(':name',      $name,      PDO::PARAM_STR); //Textの場合 PDO::PARAM_STR
// ここまでが準備.次の行で実行！$statusにはTrueかFalseが返る.
$status = $stmt->execute();

//4. データ登録処理後
if($status==false){
  sql_error($stmt); //関数化したSQLエラー関数：sql_error($stmt)
}else{
//5. 関数化したredirect()でリダイレクト.index.php に戻す.
  redirect("index.php"); //リダイレクト関数: redirect($file_name)
}
?>