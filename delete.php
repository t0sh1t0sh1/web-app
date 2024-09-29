<?php
$dsn = 'mysql:dbname=oyn0w2iv1zbmexyh;host=u3r5w4ayhxzdrw87.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;charset=utf8mb4';
$user = 'cozkprssmyyaesyo';
$password = 'wd1c1cquxik19bmm';

try {
    $pdo = new PDO($dsn, $user, $password);

    $sql_delete = 'DELETE FROM products WHERE id = :id';
    $stmt_delete = $pdo->prepare($sql_delete);

    // 割り当て
    $stmt_delete->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    // 実行
    $stmt_delete->execute();

    // 削除した件数を取得する
    $count = $stmt_delete->rowCount();

    $message = "商品を{$count}件削除しました。";

    // 商品一覧ページにリダイレクトさせる（同時にmessageパラメータも渡す）
    header("Location: read.php?message={$message}");

} catch (PDOException $e) {
    exit($e->getMessage());
}