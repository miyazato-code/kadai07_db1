/**
 * [assets/js/modules/EditorController.js]
 */
import { LANGUAGE_PATTERNS, STORAGE_KEY } from './constants.js';

export const EditorController = {
    // 高さの自動調整
    adjustHeight(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    },

    // 言語を自動で推測してセレクトボックスを変える
    performAutoDemand(textarea, selectEl) {
        if (!textarea || !selectEl) return;

        const code = textarea.value;
        // const selectEl = document.querySelector('#js-select'); // HTML内のセレクトボックスを取得
        const priorityOrder = ['php', 'python', 'typescript', 'javascript', 'css', 'html'];
        let detectedLang = '';

        // 優先順位が高い順に、コードの中に特徴的な文字があるかテストします
        for (const lang of priorityOrder) {
            if (LANGUAGE_PATTERNS[lang] && LANGUAGE_PATTERNS[lang].test(code)) {
                detectedLang = lang;
                break; // 1つ見つかったらループを抜ける
            }
        }

        if (detectedLang && selectEl) {
            const targetValue = (detectedLang === 'php') ? 'php' :
                                (detectedLang === 'python') ? 'py' :
                                (detectedLang === 'typescript') ? 'ts' :
                                (detectedLang === 'javascript') ? 'js' : 
                                (detectedLang === 'css') ? 'css' : detectedLang;

            if (selectEl.value !== targetValue) {
                selectEl.value = targetValue;
                // 視覚効果：一瞬だけ光らせて「自動で切り替わったこと」を伝えます
                selectEl.style.transition = "outline 0.3s";
                selectEl.style.outline = "2px solid var(--color-accent)";
                setTimeout(() => { selectEl.style.outline = "none"; }, 500);
            }
        }
    },

    // 下書きを保存
    saveDraft(data) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
    }
};