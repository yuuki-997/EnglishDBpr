<?php
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

function db_conn(){
    try{

        return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
}

function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

function redirect($filename){
    header("Location:".$filename);
    exit();
}

function sschk(): void{
    if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
        exit("Login Error");
    }else{
        session_regenerate_id(delete_old_session: true);
        $_SESSION["chk_ssid"] = session_id();
    }
}