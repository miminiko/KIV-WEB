<?php defined('INDEX') OR die('Прямой доступ к странице запрещён!');

include_once("/cfg/core.php");
include_once("/cfg/opennews.php");

    $db = new MyDB();
    $home = new viewNews();
    $home->viewSmallNews($db->getNewsWithCountComment());

?>