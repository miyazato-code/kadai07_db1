<?php
/**
 * [src/features/snippets/components/DeleteModal.php]
 * 役割：削除ボタンを押した時に表示される「本当に消しますか？」という確認画面
 */
?>

<dialog id="js-delete-modal" class="c-modal">
    <div class="c-modal__inner">
        <h3 class="c-modal__title">このコードを削除しますか？</h3>
        <p class="c-modal__text">これにより、SQLデータベースから<br>完全に削除されます。</p>
    
        <form action="delete-snippets.php" method="post" id="js-delete-form">
            <input type="hidden" name="id" id="js-delete-id">
            
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <input type="hidden" name="active_lang" id="js-delete-active-lang" value="<?= h($active_lang) ?>">
        
            <div class="c-modal__actions">
                <button type="button" class="c-btn c-btn--secondary" onclick="closeDeleteModal()">cancel</button>
                
                <button type="submit" class="c-btn c-btn--danger">delete</button>
            </div>
        </form>
    </div>
</dialog>

<div id="js-toast" class="c-toast">削除しました</div>