<?php
$name = $_POST["name"];
$english = $_POST["english"];
$japanese = $_POST["japanese"];
$id = $_POST["id"];
$tag = $_POST["tag"];
$comment = $_POST["comment"];

include("funcs.php");
$pdo = db_conn();

$sql = "UPDATE gs_englishplus_table SET name =:name, english=:english, japanese=:japanese, tag=:tag, comment=:comment WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':english', $english, PDO::PARAM_STR);
$stmt->bindValue(':japanese', $japanese, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){
    sql_error($stmt);
}else{
    redirect("select.php");
}