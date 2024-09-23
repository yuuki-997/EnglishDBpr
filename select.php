
<?php

session_start();
ini_set("display_errors",1);

include("funcs.php");
$pdo = db_conn();

sschk();

$search = isset($_GET['search']) ? $_GET['search'] : '';

$stmt = $pdo->prepare("SELECT * FROM gs_englishplus_table WHERE name LIKE :search OR english LIKE :search OR japanese LIKE :search OR comment LIKE :search");
$stmt->bindValue(':search', '%' .$search . '%', PDO::PARAM_STR);
$status = $stmt->execute();

$view="";
if($status==false){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

$values = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($values,JSON_UNESCAPED_UNICODE);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>単語帳</title>
</head>
<body>
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="index.php">単語登録</a>
    <?php if($_SESSION["kanri_flg"]=="1") {?><a class="navbar-brand" href="logout.php">ログアウト</a><?php } ?>
    <a class="navbar-brand" href="user.php"> ユーザー登録</a><br>
    <?=$_SESSION["name"]?>さん、こんにちは！
    </div></div>
  </nav>
</header>

<div class="container">

    <form action="" method="get">
        <input type="text" name="search" placeholder="検索ワード" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8')?>">
        <button type="submit">検索</button>
    </form>

    <div class="container jumbotron">
        <table border="1">
            <thead>
                <tr>
                    <th>name</th>
                    <th>english</th>
                    <th>japanese</th>
                    <th>tag</th>
                    <th>comment</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($values as $v) { ?>
                    <tr>
                        <td><?= htmlspecialchars($v["name"],ENT_QUOTES,'UTF-8') ?></td>
                        <td><?= htmlspecialchars($v["english"],ENT_QUOTES,'UTF-8') ?></td>
                        <td><?= htmlspecialchars($v["japanese"],ENT_QUOTES,'UTF-8') ?></td>
                        <td><?= htmlspecialchars($v["tag"],ENT_QUOTES,'UTF-8') ?></td>
                        <td><?= htmlspecialchars($v["comment"],ENT_QUOTES,'UTF-8') ?></td>
                        <td><a href="detail.php?id=<?=htmlspecialchars($v["id"])?>">📝</a></td>
                        <td><a href="delete.php?id=<?=htmlspecialchars($v["id"])?>">🚮</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>    
    </div>
        <!-- <?php foreach($values as $v){ ?>
            <div><?=$v["name"]?></div>
            <div><?=$v["english"]?></div>
            <div><?=$v["japanese"]?></div>
            <div><?=$v["tag"]?></div>
            <div><?=$v["comment"]?></div>
            <?php }?>
        </div>
     -->

<script>
    const j =JSON.parse('< ?=$json?>');
    console.log(j);
</script>
</body>
</html>
