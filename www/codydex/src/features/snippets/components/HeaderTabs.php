<?php
declare(strict_types=1);

/**
 * [src/features/snippets/components/HeaderTabs.php]
 * 役割：保存済みコードの表示を「言語別」にフィルタリングするタブ。
 */

// 現在選択されている言語を取得（main.jsでこの値を元にフィルタリングする）
// $activeLang = $_GET['l'] ?? 'all';


$languages = [
    'all'  => ['label' => 'codyDex',     'short' => 'cody'],
    'html' => ['label' => 'HTML',        'short' => 'HTML'],
    'css'  => ['label' => 'CSS',         'short' => 'CSS'],
    'js'   => ['label' => 'JavaScript',  'short' => 'JS'],
    'php'  => ['label' => 'PHP',         'short' => 'PHP'],
    'py'   => ['label' => 'Python',      'short' => 'PY'],
    'ts'   => ['label' => 'TypeScript',  'short' => 'TS']
];
// Warning: foreach() argument must be of type array|object, null given in
// /Applications/XAMPP/xamppfiles/htdocs/kadai07_DB1/src/features/snippets/components/HeaderTabs.php
// on line 24
$active_lang = $active_lang ?? $_GET['l'] ?? 'all';
?>

            <div class="c-tabs__inner">
                <!-- <button class="c-tabs__item <?= $active_lang == 'all' ? 'is-active' : '' ?>" lang-filter="all" shorten="cody">codyDex</button>
                <button class="c-tabs__item <?= $active_lang == 'html' ? 'is-active' : '' ?>" lang-filter="html" shorten="HTML">HTML</button>
                <button class="c-tabs__item <?= $active_lang == 'css' ? 'is-active' : '' ?>" lang-filter="css" shorten="CSS">CSS</button>
                <button class="c-tabs__item <?= $active_lang == 'js' ? 'is-active' : '' ?>" lang-filter="js" shorten="JS">JavaScript</button>
                <button class="c-tabs__item <?= $active_lang == 'php' ? 'is-active' : '' ?>" lang-filter="php" shorten="PHP">PHP</button>
                <button class="c-tabs__item <?= $active_lang == 'py' ? 'is-active' : '' ?>" lang-filter="py" shorten="Py">Python</button>
                <button class="c-tabs__item <?= $active_lang == 'ts' ? 'is-active' : '' ?>" lang-filter="ts" shorten="TS">TypeScript</button> -->
                
                <?php foreach ($languages as $tab => $info): ?>
                <?php 
                // 現在のタブが選択されているか判定
                $isActive = ($active_lang === $tab); 
                // URLパラメータを生成
                $urlTab = "index.php?l=" . $tab;
                ?>
                <a href="<?= h($urlTab) ?>" class="c-tabs__item <?= $isActive ? 'is-active' : '' ?>" lang-filter="<?= h($tab) ?>" shorten="<?= h($info['short']) ?>"><?= h($info['label']) ?></a>
                <?php endforeach; ?>
                </div>
            </div>
        </nav>



        