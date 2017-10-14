<?php defined('INDEX') OR die('Прямой доступ к странице запрещён!');
/* КОМПОНЕНТ СТРАНИЦЫ */
include_once("/cfg/core.php");
include_once("/cfg/opennews.php");

$db = new MyDB();
$home = new viewNews();
$action = @$_REQUEST["action"];
echo "it is " .$action;

if($action == "by_category"){

}else{
    $idNews = @$_REQUEST["newsid"];
    $home->getNewsTemplate($db->getOneNewsWithArrayComment($idNews));
}

?>