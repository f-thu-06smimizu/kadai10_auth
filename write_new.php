<?php
// 1. POSTデータ取得
$pain_point = $_POST['pain_point'] ?? '未入力';
$category   = $_POST['category'] ?? '未分類';

// 2. DB接続（VSコードのファイルで上書きされないよう、ここで直接指定）
$db_name = 'atora2026_atora_db';
$db_host = 'mysql3112.db.sakura.ne.jp'; 
$db_id   = 'atora2026';
$db_pw   = 'atora_260116'; 

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_id, $db_pw);
} catch (PDOException $e) {
    // もしエラーが出たら、何が原因か日本語で表示する
    exit('DB接続エラー発生！理由: ' . $e->getMessage());
}

// 3. データ登録
$stmt = $pdo->prepare("INSERT INTO pre_trip_logs (id, pain_point, category, indate) VALUES (NULL, :pain_point, :category, sysdate())");
$stmt->bindValue(':pain_point', $pain_point, PDO::PARAM_STR);
$stmt->bindValue(':category',   $category,   PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorMessage:" . $error[2]);
} else {
    // 成功したら一覧画面へ
    header("Location: read.php");
    exit;
}
?>