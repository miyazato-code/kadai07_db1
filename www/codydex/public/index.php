<?php
/**
 * [public/index.php]
 * 役割：アプリケーションのメインエントリ。
 * ここですべてのパーツを呼び出し、ひとつのHTML画面を組み立てます。
 */
declare(strict_types=1);
ini_set('display_errors', '1');
error_reporting(E_ALL);

// --- 1. 土台の読み込み ---
// require_once: 指定したファイルを一度だけ読み込む（なければエラーで止まる）
// __DIR__: 今いるフォルダ。 /../ は「一つ上の階層へ」という意味
require_once(__DIR__ . '/../../../config/db-setup1.php');
require_once(__DIR__ . '/../../../config/helpers.php');


// -- 開発モック:ログイン状態を再現 ---
// 確認が終わったら削除すること
// if($_SERVER['HTTP_HOST'] === 'localhost') {
    $_SESSION['uid'] = 'test-user-123'; 
    $_SESSION['name'] = 'Test Engineer';
// }


// --- 2. データの取得 ---
// DBからコードの一覧を取ってくるなどの「中身」を読み込み
// ※ get_snippets.php 内で $pdo = db_conn(); を呼び出すように作ります
require_once(__DIR__ . '/../src/features/snippets/api/get-snippets.php');

// --- 3. ログイン状態の確認 ---
// $_SESSION['uid']: ログイン時に保存した「ユーザーID」があるか確認
// isset(): その中身が存在するかどうかをチェック（trueかfalseを返す）
$isLoggedIn = isset($_SESSION['uid']);
$active_lang = $_GET['l'] ?? 'all';

if (!isset($dataItems)) {
    $dataItems = [];
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php 
    // css の読み込み enqueue_style('');
    App::style('normalize');
    App::style('global');
    App::style('style');
    App::style('google-btn');
    App::style('pulse-view');
    // include の代わりに render_component を使用
    // include(__DIR__ . '/../src/common/components/Head.php');
    App::render('Head'); 
    ?>
</head>
<body class="l-main <?= !$isLoggedIn ? 'is-pulse-mode' : '' ?>">

    <div class="l-container">
        <header class="c-tabs col-12">
        <?php
        // include(__DIR__ . '/../src/common/components/Header.php'); 
         App::render('Header');
        ?>
        </header>

        <main id="js-list" class="c-list" >
            <?php if ($active_lang === 'all'): ?>
                <?php App::render('PulseView'); ?>
            <?php else: ?>
                <?php App::render('CodeList'); ?>

                <div class="c-search col-12">
                    <?php App::render('FooterForm'); ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <?php App::render('DeleteModal'); ?>

    <?php
    // scriptの読み込み enquene_script(''); App::js('');
    App::js('main');
    ?>
        
</body>
</html>