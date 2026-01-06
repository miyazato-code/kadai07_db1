/**
 * [assets/js/modules/Constants.js]
 */

// 言語判定に使用する正規表現（プログラミング言語の特徴的な記号を判別します）

export const LANGUAGE_PATTERNS = {
    // PHP: 開始タグ、変数($)、名前空間、アクセス修飾子、アロー演算子、echo
    php: /<\?php|\$[\w]+|namespace\s+[\w\\]+|public\s+function\s+|->|echo\s+/i,

    // Python: 関数定義、インポート、制御構文、self、メインブロック、デコレータ
    python: /\b(def|import|from|as|elif|None|True|False)\b|print\(|self\.|if\s+__name__\s+==|@[\w]+/i,

    // TypeScript: 型定義(interface/type/enum)、型アノテーション(: string等)、アクセス修飾子
    typescript: /\b(interface|type|enum)\s+\w+|:\s+(string|number|boolean|any|void)\b|<\w+>|private\s+\w+:|readonly\s+/i,

    // JavaScript: ES6以降の宣言、アロー関数、コンソール出力、イベントリスナ、DOM操作、JSON
    javascript: /\b(const|let|var)\b|=>|console\.log\(|addEventListener\(|document\.get|JSON\.(parse|stringify)/i,

    // CSS: セレクタ構造、プロパティ定義、メディアクエリ、変数
    css: /[\.#][\w-]+\s*\{|[\w-]+\s*:\s*[^;]+;|@media|@keyframes|calc\(|var\(--/i,

    // HTML: ドキュメント宣言、主要なタグ、class/id属性
    html: /<!DOCTYPE\s+html>|<(?:html|head|body|div|span|script|link|meta|input|form|br)\b|class=["'].*?["']|id=["'].*?["']/i
};

// ローカルストレージ（下書き保存用）のキー名
export const STORAGE_KEY = 'codydex_draft';