/**
 * [assets/js/features/snippets/js/editor.js]
 * 役割：入力エリアの自動リサイズ、下書きの保存・復元を担当
 */
export const initEditor = () => {
    const codeInput = document.querySelector('#js-code');
    const DRAFT_KEY = 'codydex_draft';

    // A. 下書きの復元
    const savedDraft = localStorage.getItem(DRAFT_KEY);
    if (savedDraft && codeInput) {
        codeInput.value = savedDraft;
    }

    // B. 自動リサイズ & 下書き保存
    codeInput?.addEventListener('input', () => {
        // 高さの調整
        codeInput.style.height = 'auto';
        codeInput.style.height = codeInput.scrollHeight + 'px';
        
        // ローカルストレージへ保存
        localStorage.setItem(DRAFT_KEY, codeInput.value);
    });
};