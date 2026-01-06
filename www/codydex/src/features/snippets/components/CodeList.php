<?php
global $dataItems;
/**
 * [CodeList.php]
 * 役割：データの配列をループして、カードを並べる「入れ物」。
 */
?>

<div class="c-card-list">
    <?php if (empty($dataItems)): ?>
        <div class="c-none">
            <p class="c-none-message"></p>
        </div>
    <?php else: ?>
    
        <?php foreach ($dataItems as $item): ?>
    
            <?php include(__DIR__ . '/CodeCard.php'); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>