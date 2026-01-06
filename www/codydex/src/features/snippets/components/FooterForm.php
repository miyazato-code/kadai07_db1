<?php

?>


            <form action="../src/features/snippets/api/save-snippets.php" method="post" id="js-form" class="c-search__form">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                
                <div class="c-search__box">
                    <textarea name="code" id="js-code" class="c-search__input" placeholder="コードを書く" tabindex="1" required></textarea>
                    
                    <div class="c-search__actions">
                        <div class="c-search__actions-left">
                            <select name="lang" id="js-select" class="c-search__select" tabindex="2">
                                <option value="html">HTML</option>
                                <option value="css">CSS</option>
                                <option value="js">JavaScript</option>
                                <option value="php">PHP</option>
                                <option value="py">Python</option>
                                <option value="ts">TypeScript</option>
                            </select>
                            <input type="text" name="comment" class="c-form__input-comment" placeholder="// コメントアウト" autocomplete="off" tabindex="3" required>
                        </div>
                        <button type="submit" class="c-search__submit" tabindex="4">COMMIT<span class="kbd"></span></button>
                    </div>
                </div>
            </form>
