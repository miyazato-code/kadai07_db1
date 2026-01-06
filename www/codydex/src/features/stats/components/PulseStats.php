<?php

?>


<div class="c-stats__profile">
        <div class="c-stats__user-info">
            <span class="c-stats__welcome">Welcome back,</span>
            <h2 class="c-stats__username"><?= h($_SESSION['name'] ?? 'Guest Engineer') ?></h2>
        </div>
        <a href="logout.php" class="c-stats__logout-link">Sign out</a>
    </div>

    <section class="c-stats__card c-stats__card--full">
        <div class="c-stats__card-header">
            <h4 class="c-stats__label">Activity Pulse (365 Days)</h4>
            <span class="c-stats__streak-badge">🔥 12 Days Streak</span>
        </div>
        <div class="c-stats__heatmap-container">
            <div id="js-heatmap" class="c-stats__heatmap">
                </div>
        </div>
    </section>

    <section class="c-stats__card">
        <h4 class="c-stats__label">Language Balance</h4>
        <div class="c-stats__github-bar">
        <?php App::render('LanguageBar'); ?>

        </div>
        <ul class="c-stats__legend">
            <li><span class="dot html"></span> HTML 45%</li>
            <li><span class="dot js"></span> JavaScript 30%</li>
            <li><span class="dot php""></span> PHP 15%</li>
        </ul>
    </section>

    <?php
    App::render('TechDocs');
?>
</div>

