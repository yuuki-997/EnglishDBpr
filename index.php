<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>みんなの英単語帳プレミアム</title>
    <script>
        async function translateWord(sourceLang, targetLang, word, outputElement) {
            const response = await fetch('deepl.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    word: word,
                    sourceLang: sourceLang,
                    targetLang: targetLang
                })
            });

            const data = await response.json();
            if (data.translatedText) {
                document.querySelector(outputElement).value = data.translatedText;
            } else {
                alert("翻訳に失敗しました: " + data.error);
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // 英語から日本語への翻訳
            document.querySelector('input[value="E→J"]').addEventListener("click", function(event) {
                event.preventDefault();
                const englishText = document.querySelector('input[name="english"]').value;
                translateWord('EN', 'JA', englishText, 'input[name="japanese"]');
            });

            // 日本語から英語への翻訳
            document.querySelector('input[value="J→E"]').addEventListener("click", function(event) {
                event.preventDefault();
                const japaneseText = document.querySelector('input[name="japanese"]').value;
                translateWord('JA', 'EN', japaneseText, 'input[name="english"]');
            });
        });
    </script>
</head>
<body>
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">単語帳</a></div>
    </div>
  </nav>
</header>

<form method="post" action="insert.php">
    <div class="jumbotron">
        <fieldset>
            <legend>英単語を記録</legend>
            <label>Name：<input  type="text" name="name" required></label><br>
            <label>English Word:<input type="text" name="english" required><input type="button" value="E→J"></label><br>
            <label>Japanese Word:<input type="text" name="japanese" required></label><input type="button" value="J→E"></label><br>
            <label>Tag:
            <select name="tag">
            <option>TOEIC</option>
            <option>BOOK</option>
            <option>MOVIE</option>
            <option>CONVERSATION</option>
            <option>OTHER</option>
            </select></label><br>
            <label>Comment:<textArea name="comment" rows="4" cols="40"></textArea></label><br>
            <input type="submit" value="送信">
        </fieldset>
    </div>

</form>

</body>
</html>