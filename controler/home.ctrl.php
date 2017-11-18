<?php defined('INDEX') OR die('Прямой доступ к странице запрещён!');

include_once("/model/database.mod.class.php");
include_once("/model/opennews.mod.class.php");

    $db = new MyDB();
    $home = new viewNews();
    //zaplni home vsema prispevkama, ktery ma typ publish
    $home->viewSmallNews($db->getNewsWithCountComment());


    $db->close();
    unset($db);
?>