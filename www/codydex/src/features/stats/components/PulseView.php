<?php
/**
 * [src/features/stats/components/PulseView.php]
 * 役割：Pulseセクション（ログイン前のゲートとログイン後の統計）を表示。
 */
$isLoggedIn = isset($_SESSION['uid']);
?>
<section id="js-pulse-container" class="c-pulse">
    
    <?php if (!isset($_SESSION['uid'])): ?>
        <?php // include(__DIR__ .  '/PulseGate.php');
        App::render('PulseGate');
        App::render('TechDocs');
        ?>

    <?php else: ?>
        <?php // include(__DIR__ . '/PulseStats.php');
        App::render('PulseStats');
        ?>
    <?php endif; ?>

    <?php // include(__DIR__ . '/TechDocs.php'); 

    ?>

</section>