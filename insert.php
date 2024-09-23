<?php
ini_set("display_errors", 1);

$name = $_POST["name"];
$english = $_POST["english"];
$japanese = $_POST["japanese"];
$tag = $_POST["tag"];
$comment = $_POST["comment"];

include("funcs.php");
$pdo = db_conn();

$sql = "INSERT INTO gs_englishplus_table(name,english,japanese,tag,comment,indate)VALUES(:name,:english,:japanese,:tag,:comment,sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',$name, PDO::PARAM_STR);
$stmt->bindValue(':english',$english, PDO::PARAM_STR);
$stmt->bindValue(':japanese',$japanese, PDO::PARAM_STR);
$stmt->bindValue(':tag',$tag, PDO::PARAM_STR);
$stmt->bindValue(':comment',$comment, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}else{
    header("Location: index.php");
    exit();
}
?>