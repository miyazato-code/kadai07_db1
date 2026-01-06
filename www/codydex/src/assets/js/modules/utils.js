/**
 * [assets/js/modules/utils.js]
 */

/**
 * デバウンス関数：短時間に連続して発生するイベント（入力など）の実行を、
 * 最後の発生から指定時間（delay）待ってから1回だけ実行するように制限します。
 */
export function debounce(func, delay) { // ← exportを追加
    let timeoutId;
    return function (...args) {
        if (timeoutId) clearTimeout(timeoutId); // 前回の予約をキャンセル
        timeoutId = setTimeout(() => {
            func.apply(this, args); // 指定時間後に本番の関数を実行
        }, delay);
    };
}

/**
 * URLパラメータを更新する関数
 */
export const updateUrlParam = (filter) => { // ← exportを追加
    const url = new URL(window.location.origin + window.location.pathname);
    // 常に l だけをセットしたクリーンなURLを作成
    url.searchParams.set('l', filter);
    // ブラウザの履歴を更新（ページ遷移はしない）
    window.history.replaceState({}, '', url.toString());
};