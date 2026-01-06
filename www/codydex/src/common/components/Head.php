<?php
declare(strict_types=1);

/**
 * [src/common/components/head.php]
 * 役割：HTMLの <head> 内を管理。
 * 共通スタイル(Normalize/Global)から機能別スタイル(Pulse/Auth)へ段階的に読み込みます。
 */

// サイトの基本情報
$siteTitle = 'codyDex';
$description = '自分だけのコード断片を高速に記録するパーソナル・インデックス';
?>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= h($description) ?>">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';">
    <!-- 許可されたソース以外のスクリプト実行を制限し、XSS攻撃を防止するセキュリティ設定 -->
    <title><?= h($siteTitle) ?></title>
    <link rel="icon" href="../src/assets/img/icon/codydex-fav.svg" type="image/svg+xml">
    <!-- <link rel="stylesheet" href="../src/assets/css/normalize.css"> -->
    <!-- <link rel="stylesheet" href="../src/assets/css/style.css"> -->
    <!-- <link rel="stylesheet" href="../src/assets/css/global.css"> -->
    <!-- <link rel="stylesheet" href="../src/assets/css/gsi.css"> -->
    <!-- <link rel="stylesheet" href="../src/features/stats/css/pulse-view.css"> -->
