<?php
$id = $_GET["id"];
include("funcs.php");
$pdo = db_conn();

$sql = "SELECT * FROM gs_englishplus_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

$values = "";
if($status==false){
    sql_error($stmt);
}

$v = $stmt->fetch();
?>

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

<form method="POST" action="update.php">
    <div class="jumbotron">
        <fieldset>
            <legend>英単語を記録(更新)</legend>
            <label>Name：<input  type="text" name="name" value="<?=$v["name"]?>"></label><br>
            <label>English Word:<input type="text" name="english" value="<?=$v["english"]?>"><input type="button" value="E→J"></label><br>
            <label>Japanese Word:<input type="text" name="japanese" value="<?=$v["japanese"]?>"></label><input type="button" value="J→E"></label><br>
            <label>Tag:
            <select name="tag">
            <option value="TOEIC" <?= $v["tag"] == "TOEIC" ? 'selected' : '' ?>>TOEIC</option>
            <option value="BOOK" <?= $v["tag"] == "BOOK" ? 'selected' : '' ?>>BOOK</option>
            <option value="MOVIE" <?= $v["tag"] == "MOVIE" ? 'selected' : '' ?>>MOVIE</option>
            <option value="CONVERSATION" <?= $v["tag"] == "CONVERSATION" ? 'selected' : '' ?>>CONVERSATION</option>
            <option value="OTHER" <?= $v["tag"] == "OTHER" ? 'selected' : '' ?>>OTHER</option>
            </select></label><br>
            <label>Comment:<textArea name="comment" rows="4" cols="40"> <?=$v["comment"]?></textArea></label><br>
            <input type="submit" value="更新">
            <input type="hidden" name="id" value="<?=$v["id"]?>">
        </fieldset>
    </div>

</form>

</body>
</html>