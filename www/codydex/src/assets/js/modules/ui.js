/**
 * [assets/js/modules/ui.js]
 * 役割：トースト表示やアニメーションなど、画面の「動き」を担当します。
 */

// トースト通知を表示
export const showToast = (message) => {
    const toast = document.querySelector('#js-toast');
    if (!toast) return;

    toast.textContent = message; // メッセージを注入
    toast.classList.add('is-show'); // 表示クラスを追加

    // 3秒後に非表示にする
    setTimeout(() => {
        toast.classList.remove('is-show');
    }, 3000);
};

// 指定した要素（カード）をアニメーション付きで消す
export const removeElementWithAnimation = (element, callback) => {
    if (!element) return;
    element.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
    element.style.opacity = '0';
    element.style.transform = 'scale(0.95) translateY(10px)';
    setTimeout(() => {
        element.remove();
        if (callback) callback();
    }, 400);
};

// タブを中央へスクロール
export const scrollToActiveTab = (tabElement) => {
    if (!tabElement) return;
    tabElement.scrollIntoView({
        behavior: 'smooth', // ぬるっと動かす
        block: 'nearest',   // 縦方向は動かさない
        inline: 'center'    // 横方向の中央に
    });
};

/**
 * カードの表示/非表示を切り替える
 */
export const applyFilter = (filter) => {
    const cards = document.querySelectorAll('.c-card');
    cards.forEach(card => {
        const cardLang = card.getAttribute('data-lang'); // index.phpの属性名に合わせる
        card.style.display = (filter === 'all' || cardLang === filter) ? 'block' : 'none';
    });
};

/**
 * モーダル操作
 */
export const ModalUI = {
    open(id) {
        const modal = document.querySelector('#js-delete-modal');
        const idInput = document.querySelector('#js-delete-id');
        const langInput = document.querySelector('#js-delete-active-lang');
        const activeTab = document.querySelector('.c-tabs__item.is-active');

        if (!modal || !idInput) return;
        
        // 削除対象のIDをセット
        idInput.value = id;
        if (activeTab && langInput) {
            langInput.value = activeTab.getAttribute('lang-filter');
        }
        modal.showModal();
    },

    close() {
        document.querySelector('#js-delete-modal')?.close();
    }
};
// XSS対策のエスケープ関数
const escapeHtml = (str) => {
    if (!str) return '';
    return str.replace(/[&<>"']/g, (m) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    })[m]);
};

/**
 * 保存されたデータを元に、新しいカードをリストの先頭に追加する
 */
export const prependNewCard = (data) => {
    const list = document.querySelector('.c-card-list');
    if (!list) return;

    // 「投稿がありません」の表示があれば削除
    list.querySelector('.c-none')?.remove();

    const card = document.createElement('article');
    card.className = 'c-card';
    card.setAttribute('data-lang', data.lang);

    // PHPのCodeCard.phpと同じ構造を再現
    card.innerHTML = `
        <div class="c-card__header">
            <span class="c-card__badge" data-lang="${data.lang}">${data.lang.toUpperCase()}</span>
            <time class="c-card__date">Just now</time>
        </div>
        <div class="c-card__body">
            <p class="c-card__comment">${escapeHtml(data.comment)}</p>
            <div class="c-card__code-wrapper">
                <pre><code class="language-${data.lang}">${escapeHtml(data.code)}</code></pre>
            </div>
        </div>
        <div class="c-card__footer">
            <button type="button" class="c-btn-delete js-open-delete-modal" data-id="new">
                <i class="icon-trash"></i> DELETE
            </button>
        </div>
    `;

    // アニメーション用の初期スタイル
    card.style.opacity = '0';
    card.style.transform = 'translateY(-20px)';
    card.style.transition = 'all 0.5s ease';

    list.prepend(card);

    // 次のフレームで表示（リフローを待つ）
    requestAnimationFrame(() => {
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    });
};