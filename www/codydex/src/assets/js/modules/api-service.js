/**
 * [assets/js/modules/ApiService.js]
 */
export const ApiService = {
    /**
     * POSTリクエストの共通処理
     * @param {string} url - 送信先PHP
     * @param {FormData} formData - 送信データ
     */
    async post(url, formData) {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!response.ok) throw new Error('通信エラーが発生しました');
        return await response.json();
    }
};