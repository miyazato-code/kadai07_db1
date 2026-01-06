/**
 * [assets/js/main.js]
 * アプリケーションのメインエントリーポイント。
 * 各モジュールを初期化し、イベントリスナーを登録します。
 */
import { STORAGE_KEY } from './modules/constants.js';
import { ApiService } from './modules/api-service.js';
import { debounce, updateUrlParam } from './modules/utils.js';
import { EditorController } from './modules/editor-ctl.js';
import * as UI from './modules/ui.js';

document.addEventListener('DOMContentLoaded', () => {
    // --- 1. 要素の取得 ---
    const codeInput = document.querySelector('#js-code');
    const langSelect = document.querySelector('#js-select');
    const commentInput = document.querySelector('.c-form__input-comment');
    const form = document.querySelector('#js-form');
    const tabs = document.querySelectorAll('.c-tabs__item');
    const submitBtn = document.querySelector('.c-search__submit');
    const deleteForm = document.querySelector('#js-delete-form');

    // --- 2. 初期状態の設定 ---

    // A. 下書きの復元
    const savedData = JSON.parse(localStorage.getItem(STORAGE_KEY));
    if (savedData && codeInput) {
        codeInput.value = savedData.code || '';
        if (langSelect) langSelect.value = savedData.lang || 'html';
        if (commentInput) commentInput.value = savedData.comment || '';
        EditorController.adjustHeight(codeInput);
    }

    // B. フィルタとタブの初期化
    const initialActiveTab = document.querySelector('.c-tabs__item.is-active');
    if (initialActiveTab) {
        const initialFilter = initialActiveTab.getAttribute('lang-filter');
        UI.applyFilter(initialFilter);
        updateUrlParam(initialFilter);
        setTimeout(() => UI.scrollToActiveTab(initialActiveTab), 150);
    }

    // --- 3. イベントリスナーの登録 ---

    // 入力エリアの監視（自動保存・高さ調整・言語推測）
    if (codeInput) {
        const debouncedAutoDemand = debounce((el) => {
            EditorController.performAutoDemand(el, langSelect);
        }, 500);

        codeInput.addEventListener('input', function () {
            EditorController.adjustHeight(this);

            // 下書き保存
            const data = {
                code: this.value,
                lang: langSelect?.value || 'html',
                comment: commentInput?.value || ''
            };
            EditorController.saveDraft(data);

            // 言語推測実行
            debouncedAutoDemand(this);
        });
    }

    // 削除フォーム（非同期削除）
    deleteForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(deleteForm);
        const targetId = formData.get('id');

        try {
            
            const result = await ApiService.post('../src/features/snippets/api/delete-snippets.php', formData);
            if (result.status === 'success') {
                UI.ModalUI.close();
                const card = document.querySelector(`.c-card[data-id="${targetId}"]`);
                UI.removeElementWithAnimation(card, () => {
                    UI.showToast('削除しました');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                });
            }
        } catch (error) {
            console.error('Delete error:', error);
            UI.showToast('削除に失敗しました');
        }
    });

    // 新規保存フォーム
    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!submitBtn) return;

        submitBtn.disabled = true;
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'SAVING...';


        const formData = new FormData(form);

        try {
            const formData = new FormData(form);
            const result = await ApiService.post('../src/features/snippets/api/save-snippets.php', formData);

            if (result.status === 'success') {
                // 1. ローカルストレージを削除
                localStorage.removeItem(STORAGE_KEY);

                // 2. フォームをリセット
                form.reset();
                if (codeInput) EditorController.adjustHeight(codeInput);

                // 3. (推奨) リロードせずにカードを擬似的に追加
                UI.prependNewCard({
                    code: formData.get('code'),
                    lang: formData.get('lang'),
                    comment: formData.get('comment')
                });

                UI.showToast('保存しました！');
                setTimeout(() => location.reload(), 500);
            } else {
                alert('エラー: ' + result.message);
            }
        } catch (error) {
            console.error('Save error:', error);
            alert('通信に失敗しました。');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });

    // タブ切り替え（フィルタリング）
    // tabs.forEach(tab => {
    //     tab.addEventListener('click', () => {
    //         document.querySelector('.c-tabs__item.is-active')?.classList.remove('is-active');
    //         tab.classList.add('is-active');

    //         const filter = tab.getAttribute('lang-filter');
    //         UI.applyFilter(filter);
    //         updateUrlParam(filter);
    //         UI.scrollToActiveTab(tab);
    //         window.scrollTo({ top: 0, behavior: 'smooth' });
    //     });
    // });

    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            // JSでDOMを隠す処理(UI.applyFilter)をあえて行わず、
            // リンク(href)によるページ遷移を優先させます。

            // URLパラメータを更新してリロード (aタグのhrefがある場合は不要ですが、念のため)
            const filter = tab.getAttribute('lang-filter');
            if (filter) {
                location.href = `index.php?l=${filter}`;
            }
        });
    });

    // キーボードショートカット (Ctrl+Enterで送信)
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            if (codeInput?.value.trim() !== "") {
                submitBtn?.click();
            }
        }
    });

    // 言語選択のクイックキー (Selectフォーカス中)
    langSelect?.addEventListener('keydown', (e) => {
        const key = e.key.toLowerCase();
        const map = { 'h': 'html', 'c': 'css', 'j': 'js', 'p': 'php', 'y': 'python', 't': 'ts' };
        if (map[key]) {
            e.preventDefault();
            langSelect.value = map[key];
        }
    });

    // 時間表示の自動更新 (外部ライブラリ想定)
    if (typeof TimeUtil !== 'undefined') {
        TimeUtil.updateAll();
        setInterval(() => TimeUtil.updateAll(), 60000);
    }
});