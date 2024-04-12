<!-- kadai09_PHP03 DB操作(更新・削除)_update.php (PHPのみ) -->
<?php
//0.まずこれをしてからコードを書き始める！
//detail.php でPOSTしたデータが受け取れているかを確認する.
//確認ができたら以下4行はコメントアウトすること！
//echo('<pre>');
//var_dump($_POST);
//echo('</pre>');
//exit;

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. データ登録後処理
//5．リダイレクト

//1. POSTデータ取得.detail.phpで入力した(POSTされた）データを受け取る
$rest_name = $_POST["rest_name"];
$genre     = $_POST["genre"];
$url       = $_POST["url"];
$memo      = $_POST["memo"];
$name      = $_POST["name"];
$id        = $_POST["id"];

//2. DB接続 関数化した関数db_conn()を使う.
include("funcs.php"); //include関数でfuncs.phpを読み込む
$pdo = db_conn();

//3. データ更新SQL作成
$sql ="UPDATE rest_table SET rest_name=:rest_name, genre=:genre, url=:url, memo=:memo, name=:name WHERE id=:id";
$stmt = $pdo->prepare($sql);
// bindValueを使ってDBに被害を及ぼすコマンドを無効化する.危ない文字をクリーンにする.
$stmt->bindValue(':rest_name', $rest_name, PDO::PARAM_STR); //varcharの場合 PDO::PARAM_STR
$stmt->bindValue(':genre',     $genre,     PDO::PARAM_STR); //varcharの場合 PDO::PARAM_STR
$stmt->bindValue(':url',       $url,       PDO::PARAM_STR); //varcharの場合 PDO::PARAM_STR
$stmt->bindValue(':memo',      $memo,      PDO::PARAM_STR); //Textの場合 PDO::PARAM_STR
$stmt->bindValue(':name',      $name,      PDO::PARAM_STR); //Textの場合 PDO::PARAM_STR
$stmt->bindValue(':id',        $id,        PDO::PARAM_INT); //Integerの場合 PDO::PARAM_INT
// ここまでが準備.次の行で実行！$statusにはTrueかFalseが返る
$status = $stmt->execute();

//4．データ更新処理後
if($status==false){
  sql_error($stmt); //SQLエラー関数：sql_error($stmt)
}else{
//5．関数化したredirect()でリダイレクト.index.php に戻す.
  redirect("index.php"); //リダイレクト関数: redirect($file_name)
}
?>
