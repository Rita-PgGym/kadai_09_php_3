<!-- kadai09_PHP03 DB操作(更新・削除)_detail.php (PHP・HTML) --> 
<?php
//1.  DB接続 関数db_conn()を使う
include("funcs.php"); //include関数でfuncs.phpを読み込む
$pdo = db_conn();

//２．データ登録SQL作成
$sql    =  "SELECT * FROM rest_table";
$stmt   = $pdo->prepare($sql);
// ここまでが準備、次の行で実行！$statusにはTrueかFalseが返る
$status = $stmt->execute();

//３．データ表示
if($status==false) { //$statusがfalseの場合、つまりSQL実行時にエラーがある場合）
  sql_error($stmt); //SQLエラー関数：sql_error($stmt)
}

// SQL実行時にエラーが起きなければ次に進む
// ４．fetchAllを使ってデータを一度、全部、$valuesに入れる.
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// JSONに値を渡す場合に使う.とってきたデータをまるっとJSONに渡す.scriptタグで扱う? 使わないときはコメントアウトしておく
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);
?>

<!-- ここからHTML -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CA Moms</title>
  <link rel="stylesheet" href="css/index_style.css">
  <link rel="icon" type="img/png" href="img/favicon.png">
</head>

<!-- Header部分 Logoとナビゲーションメニュー-->
<body>
<header>
  <div class="container">
    <div><img src="img/cheers.png" alt=""></div>
    <div><h1>CA Moms</h1></div>
    <div><img src="img/cheers.png" alt=""></div>
  </div>
</header>

<!-- My Recommended Restaurant を登録するセクション -->
<section class="input_section">
  <h2>My Recommended Restaurant</h2>
  <form action="insert.php" method="POST">
    <div class="info_row">
      <div class="info_label">
        <label for="rest_name">店名：</label>
      </div>
      <div class="info_input">
        <input type="text" name="rest_name" class="text_space"><br>
      </div>
    </div>
    <div class="info_row">
      <div class="info_label">
        <label for="genre">ジャンル：</label>
      </div>
      <div class="info_input">
        <select name="genre"  class="select_area">
          <option value="イタリアン">イタリアン</option>
          <option value="フレンチ">フレンチ</option>
          <option value="和食">和食</option>
          <option value="中華">中華</option>
          <option value="焼き鳥">焼き鳥</option>
          <option value="居酒屋">居酒屋</option>
          <option value="ラーメン">ラーメン</option>
          <option value="その他" selected>その他</option>
        </select><br>
      </div>
    </div>
    <div class="info_row">
      <div class="info_label">
        <label for="url">URL：</label>
      </div>
      <div class="info_input">
        <input type="text" name = "url" class="text_space"><br>
      </div>
    </div>
    <div class="info_row">
      <div class="info_label">
        <label for="memo">おすすめポイント：</label>
      </div>
      <div class="info_input">
        <textArea name="memo" rows="4" cols="53"></textArea><br>
      </div>
    </div>
    <div class="info_row">
      <div class="info_label">
        <label for="name">推薦者：</label>
      </div>
      <div class="info_input">
        <select name="name" class="select_area">
          <option value="Mie">Mie</option>
          <option value="Mika">Mika</option>
          <option value="Rita">Rita</option>
        </select><br>
      </div>
    </div>
    <button type="submit" class="regist">新規登録</button>
  </form>
</section>

<!-- Our Favorite Restaurants を表形式で表示するセクション -->
<section class="list">
  <h2 class="h2_title">Our Favorite Restaurants</h2>
  <div>
    <div>
      <table>
        <th>No.</th>
        <th>店名</th>
        <th>ジャンル</th>
        <th>URL</th>
        <th>おすすめポイント</th>
        <th>推薦者</th>
        <th>投稿日</th>
        <th>更新</th>
        <th>削除</th>
        <!-- foreach()で $valuesからひとつずつ値を取り出して$valueに入れていく-->
        <?php foreach($values as $value){ ?>
          <tr>
            <!-- 取り出した値にJacaScriptやHTMLタグが入っていると実行されてしまう -->
            <!-- セキュリティ的に脆弱性がある状態になっているのでサイニタイジングして危ない文字列を無効化する必要がある -->
            <!-- 関数h()を使ってサニタイジングする -->
            <!-- 表示する場所では（生のPHPでechoするところでは）この処理を必ずやること -->
            <td><?=h($value["id"])?></td>
            <td><?=h($value["rest_name"])?></td>
            <td><?=h($value["genre"])?></td>
            <td><a href= "<?=h($value["url"])?>"><?=$value["url"]?></a></td>
            <td><?=h($value["memo"])?></td>
            <td><?=h($value["name"])?></td>
            <td><?=h($value["indate"])?></td>
            <!-- 更新リンクと削除リンクをつける -->
            <td><a href="detail.php?id=<?=h($value["id"])?>">更新</a></td>
            <td><a href="delete.php?id=<?=h($value["id"])?>">削除</a></td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</section>
</body>
</html>