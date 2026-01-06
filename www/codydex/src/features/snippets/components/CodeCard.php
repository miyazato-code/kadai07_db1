<?php
// 1つのカード専用
if (!isset($item)) return;
// $item が空でないことを確認（安全策）
?>


<article class="c-card" data-id="<?= h($item['id']) ?>" data-lang="<?= h($item['lang']) ?>">
    <div class="c-card__header">
        <span class="c-card__badge" data-lang="<?= h($item['lang']) ?>">
            <?= h(strtoupper($item['lang'])) ?>
        </span>
        <time class="c-card__date"><?= h($item['created_at']) ?></time>
    </div>

    <div class="c-card__body">
        <p class="c-card__comment"><?= h($item['comment']) ?></p>
        <div class="c-card__code-wrapper">
            <pre><code class="language-<?= h($item['lang']) ?>"><?= h($item['code']) ?></code></pre>
        </div>
    </div>

    <div class="c-card__footer">
        <button type="button" 
                class="c-btn-delete js-open-delete-modal" 
                data-id="<?= h($item['id']) ?>">
            <i class="icon-trash"></i> DELETE
        </button>
    </div>
</article>