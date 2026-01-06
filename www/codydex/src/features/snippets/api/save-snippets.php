<?php
/**
 * [src/features/snippets/api/save-snippets.php]
 */
declare(strict_types=1);
session_start();

ini_set('display_errors', '1');
error_reporting(E_ALL);

// --- 1. 出力バッファリング開始（予期せぬ警告がJSONを壊すのを防ぐ） ---
ob_start();

try {
    // --- 2. 正確なパスで土台を読み込む ---
    // API(api/) -> snippets/ -> features/ -> src/ -> プロジェクトルート / config / ...
    // dirname(__DIR__, 4) を使うことで「4つ上の階層」を確実に取得します
    $config_path = dirname(__DIR__, 6) . '/config';
    
    if (!file_exists($config_path . '/db-setup1.php')) {
        throw new Exception("Config file not found at: " . $config_path);
    }

    require_once($config_path . '/db-setup1.php');
    require_once($config_path . '/helpers.php');

// レスポンスヘッダー
header('Content-Type: application/json');

// 1. セキュリティチェック
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['status' => 'error', 'message' => 'セッションが切れました。']);
    exit;
}

// 2. データの取得
$lang    = strtolower($_POST['lang'] ?? 'etc');
$comment = $_POST['comment'] ?? '';
$code    = $_POST['code'] ?? '';
$uid     = $_SESSION['uid'] ?? 'guestUser';

if (empty(trim($code))) {
    echo json_encode(['status' => 'error', 'message' => 'コードを入力してください']);
    exit;
}


    $pdo = db_conn();
    
    // 3. SQL実行 (created_atにNOW()を使用)
    $sql = "INSERT INTO cdx_code_table (uid, lang, code, comment, created_at) 
            VALUES (:uid, :lang, :code, :comment, NOW())";
            
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':uid',     $uid,     PDO::PARAM_STR);
    $stmt->bindValue(':lang',    $lang,    PDO::PARAM_STR);
    $stmt->bindValue(':code',    $code,    PDO::PARAM_STR);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    
    $stmt->execute();

    // 4. 成功レスポンス
    ob_clean(); // ここまでの警告などをクリア
    echo json_encode([
        'status' => 'success',
        'message' => '保存が完了しました！'
    ]);

} catch (PDOException $e) {
    // 5. DBエラーのハンドリング
    http_response_code(500);
    $msg = 'DB保存失敗: ' . $e->getMessage();
    
    // 重複エラー(23000)へのアドバイスを含める
    if ($e->getCode() == '23000') {
        $msg = 'エラー: このユーザーIDは既に登録されているか、制約違反です。DBのuid設定を確認してください。';
    }

    echo json_encode([
        'status' => 'error',
        'message' => $msg
    ]);
}
exit;
// 警告の出ていた $statsFile 関連の未定義処理は削除しました