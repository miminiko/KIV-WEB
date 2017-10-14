<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 11.10.2017
 * Time: 15:21
 */
include_once("/cfg/core.php");
include_once("/cfg/adminclass.php");

$administration = new admin();
$db = new MyDB();
$_SESSION["menu"] = $db->getAllCategory();
$news = $db->getInfoAboutNews();
$users = $db->getAllUsers();

$administration->getAdminTables($_SESSION["menu"], $news, $users);

$action = @$_REQUEST["action"];
if($action == "settype"){
    $administration->confirmUser();
}


?>