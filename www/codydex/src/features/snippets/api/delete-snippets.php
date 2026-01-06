<?php
/**
 * [delete-snippets.php]
 * 役割：指定されたIDのデータをSQLデータベースから削除する。
 */
declare(strict_types=1);
session_start();

// DB接続とヘルパーの読み込み
require_once(__DIR__ . '/../../../../config/db-setup1.php');
require_once(__DIR__ . '/../../../../config/helpers.php');

// レスポンスをJSONに設定
header('Content-Type: application/json');

// --- セキュリティチェック ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => '不正なアクセスです']);
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['status' => 'error', 'message' => 'トークンが無効です']);
    exit;
}

// 削除対象IDの取得
$id = $_POST['id'] ?? '';

if (empty($id)) {
    echo json_encode(['status' => 'error', 'message' => 'IDが指定されていません']);
    exit;
}

try {
    $pdo = db_conn();
    
    // --- SQL実行 ---
    // DELETE文: cdx_code_table から id が一致する行を削除
    $sql = "DELETE FROM cdx_code_table WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT); // IDが数値ならPARAM_INT
    $stmt->execute();

    // 通信がJavaScript(fetch)からのものか確認して返事をする
    echo json_encode(['status' => 'success', 'message' => '削除に成功しました']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'DBエラー: ' . $e->getMessage()]);
}