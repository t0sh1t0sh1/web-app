<?php
$dsn = 'mysql:dbname=oyn0w2iv1zbmexyh;host=u3r5w4ayhxzdrw87.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;charset=utf8mb4';
$user = 'cozkprssmyyaesyo';
$password = 'wd1c1cquxik19bmm';

if (isset($_POST['submit'])) {
  try {
    $pdo = new PDO($dsn, $user, $password);
  
    $sql = '
      INSERT INTO products (product_code, product_name, price, stock_quantity, vendor_code)
      VALUES (:product_code, :product_name, :price, :stock_quantity, :vendor_code)
    ';
    $stmt_insert = $pdo->prepare($sql);

    // 入力値の割り当て
    $stmt_insert->bindValue(':product_code', $_POST['product_code'], PDO::PARAM_INT);
    $stmt_insert->bindValue(':product_name', $_POST['product_name'], PDO::PARAM_STR);
    $stmt_insert->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
    $stmt_insert->bindValue(':stock_quantity', $_POST['stock_quantity'], PDO::PARAM_INT);
    $stmt_insert->bindValue(':vendor_code', $_POST['vendor_code'], PDO::PARAM_INT);
  
    $stmt_insert->execute();

    // 追加した件数を取得
    $count = $stmt_insert->rowCount();

    // 一覧ページへリダイレクト時の処理
    $message = "商品を{$count}件登録しました。";
    header("Location: read.php?message={$message}");
  
  } catch (PDOException $e) {
    exit($e->getMessage());
  }
  
}

// セレクトボックス用の配列コード取得処理
try {
  $pdo = new PDO($dsn, $user, $password);

  $sql = 'SELECT vendor_code FROM vendors';
  $stmt_select = $pdo->query($sql);

  $vendor_codes = $stmt_select->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
  exit($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品登録</title>
  <link rel="stylesheet" href="css/style.css">

  <!-- Google Fontsの読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <nav>
      <a href="index.php">商品管理アプリ</a>
    </nav>
  </header>

  <main>
    <article class="registration">
      <h1>商品登録</h1>
      <div class="back">
        <a href="read.php" class="btn">&lt; 戻る</a>
      </div>
      <form action="create.php" method="post" class="registration-form">
        <div>
          <label for="product_code">商品コード</label>
          <input type="number" id="product_code" name="product_code" min="0" max="100000000" required>

          <label for="product_name">商品名</label>
          <input type="text" id="product_name" name="product_name" maxlength="50" required>

          <label for="price">単価</label>
          <input type="number" id="price" name="price" min="0" max="100000000" required>

          <label for="stock_quantity">在庫数</label>
          <input type="number" id="stock_quantity" name="stock_quantity" min="0" max="100000000" required>

          <label for="vendor_code">仕入先コード</label>
          <select id="vendor_code" name="vendor_code" required>
            <option disabled selected value>選択してください</option>
            <?php
            foreach ($vendor_codes as $vendor_code) {
              echo "<option value='{$vendor_code}'>{$vendor_code}</option>";
            }
            ?>
          </select>
        </div>
        <button type="submit" class="submit-btn" name="submit" value="create">登録</button>
      </form>
    </article>
  </main>
  <footer>
    <p class="copyright">&copy; 商品管理アプリ All rights reserved.</p>
  </footer>
</body>
</html>