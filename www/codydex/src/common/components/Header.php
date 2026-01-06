<?php
declare(strict_types=1);

/**
 * [src/common/components/header.php]
 * 役割：全画面共通のヘッダー。
 * ログイン状態に関わらずナビゲーション（tabs）を表示し、
 * 認証ボタンの出し分けを行います。
 */
?>


<header class="c-header">
    <div class="c-header__inner">
        <!-- <h1 class="c-header__logo">
            <a href="index.php">codyDex</a>
        </h1>
         -->
        <!-- <div class="c-header__actions">
            <?php if (isset($_SESSION['uid'])): ?>
                <span class="c-header__user-name"><?= h($_SESSION['name'] ?? 'Guest') ?></span>
                <a href="logout.php" class="c-btn c-btn--secondary">Logout</a>
            <?php endif; ?>
        </div>
    </div> -->

    <!-- 
    相対パス
     階層構造の計算:
     1. /src/common/components/ (現在地: __DIR__)
     2. /src/common/ ( ../ )
     3. /src/ ( ../../ )  <- ここでプロジェクトのソースルートに到達
     4. /src/features/sinppets/comppnents/HeaderTabs.php (残りのパスを繋ぐ)
    
    -->
    <?php 
    // include(__DIR__ . '/../../features/snippets/components/HeaderTabs.php');
    App::render('HeaderTabs');
    ?>
</header>

<!-- <header>
            <div class="c-tabs__inner">
                <button class="c-tabs__item <?= $active_lang == 'all' ? 'is-active' : '' ?>" lang-filter="all" shorten="cody">codyDex</button>
                <button class="c-tabs__item <?= $active_lang == 'html' ? 'is-active' : '' ?>" lang-filter="html" shorten="HTML">HTML</button>
                <button class="c-tabs__item <?= $active_lang == 'css' ? 'is-active' : '' ?>" lang-filter="css" shorten="CSS">CSS</button>
                <button class="c-tabs__item <?= $active_lang == 'js' ? 'is-active' : '' ?>" lang-filter="js" shorten="JS">JavaScript</button>
                <button class="c-tabs__item <?= $active_lang == 'php' ? 'is-active' : '' ?>" lang-filter="php" shorten="PHP">PHP</button>
                <button class="c-tabs__item <?= $active_lang == 'py' ? 'is-active' : '' ?>" lang-filter="py" shorten="Py">Python</button>
                <button class="c-tabs__item <?= $active_lang == 'ts' ? 'is-active' : '' ?>" lang-filter="ts" shorten="TS">TypeScript</button>
            </div>
        </nav>
</header> -->