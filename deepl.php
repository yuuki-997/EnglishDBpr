<?php
$deepl_api_url = 'https://api-free.deepl.com/v2/translate';
$your_api_key = '';  // DeepL APIキーを設定

// クライアントから送られてきたデータを取得
$word = $_POST['word'];
$sourceLang = $_POST['sourceLang'];
$targetLang = $_POST['targetLang'];

// HTTPリクエストヘッダとボディを準備
$header = [
    'Content-Type: application/x-www-form-urlencoded',
];
$content = [
    'auth_key'    => $your_api_key,
    'text'        => $word,
    'source_lang' => $sourceLang,
    'target_lang' => $targetLang,
];

// HTTPリクエストパラメータを設定
$params = [
    'http' => [
        'method'  => 'POST',
        'header'  => implode("\r\n", $header),
        'content' => http_build_query($content, '', '&'),
    ]
];

try {
    // DeepL APIを呼び出し
    $request = file_get_contents(
        $deepl_api_url,
        false,
        stream_context_create($params)
    );

    // レスポンスをデコード
    $result = json_decode($request);

    // 結果を返す
    echo json_encode(['translatedText' => $result->translations[0]->text]);
} catch (Exception $e) {
    // エラーメッセージを返す
    echo json_encode(['error' => $e->getMessage()]);
}
?>