<!-- kadai09_PHP03 DB操作(更新・削除)_delete.php (PHPのみ) -->
<?php
//0.まずこれをしてからコードを書き始める！
//index.phpでクリックしたレコードのidが受け取れているかを確認する.
//確認ができたら以下4行はコメントアウトすること！
//echo('<pre>');
//var_dump($_GET);
//echo('</pre>');
//exit;

//1. POSTデータ取得 削除したいデータのidを受け取る
$id = $_GET["id"];

//2. DB接続 関数化した関数db_conn()を使う.
include("funcs.php"); //まず、include関数でfuncs.phpを読み込む.
$pdo = db_conn();

//3. データ削除SQL作成
//テーブルrest_table から指定されたidのレコードを削除する
$stmt = $pdo->prepare("DELETE FROM rest_table WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
//ここまでが準備.次の行で実行！$statusにはTrueかFalseが返る.
$status = $stmt->execute(); //実行

//4．データ登録処理後
if($status==false){
  sql_error($stmt); //関数化したSQLエラー関数：sql_error($stmt)
}else{
//5. 関数化したredirect()でリダイレクト.index.php に戻す.
  redirect("index.php");  //リダイレクト関数: redirect($file_name)
}
?>
