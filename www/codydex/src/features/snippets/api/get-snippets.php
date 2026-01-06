<?php
/**
 * [src/features/snippets/api/get-snippets.php]
 * 役割：現在の言語設定に合わせてSQLからデータを取得する。
 */
declare(strict_types=1);

// DB接続
$pdo = db_conn();

// フィルタリングする言語を取得
$active_lang = $_GET['l'] ?? 'all';

try {
    if ($active_lang === 'all') {
        // 全件取得
        $sql = "SELECT * FROM cdx_code_table ORDER BY created_at DESC";
        $stmt = $pdo->query($sql); // パラメータがない場合は query() でOK
    } else {
        // 言語絞り込み
        $sql = "SELECT * FROM cdx_code_table WHERE lang = :lang ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':lang' => $active_lang]);
    }

    // フェッチモードを指定して配列を取得
    $dataItems = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

} catch (PDOException $e) {
    // 失敗しても $dataItems を空配列にすることで index.php の崩壊を防ぐ
    $dataItems = [];
    error_log("Snippets Fetch Error: " . $e->getMessage());
}

echo "";