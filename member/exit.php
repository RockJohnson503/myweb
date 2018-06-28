<?php
session_start();
require_once("../duomiphp/common.php");
$mac = $_SESSION["cfg_ac"];
$res = $dsql->ExecuteNoneQuery2("delete from wanshi_session where sess_id = '". $_COOKIE["PHPSESSID"] ."'");
session_destroy();
//生成同步退出的代码
if($mac){
    $mac = "?mac=".$mac;
}
header("Location:/".$mac);
?>