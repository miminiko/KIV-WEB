<?php
    require_once("/cfg/core.php");
    include_once("/cfg/opennews.php");

    $cat = @$_REQUEST["cat"];
    $db = new MyDB();
    $home = new viewNews();
    $category = $db ->getCategoryById($cat);
    $array_news = $db->getNewsByCategoryId($cat);
    $home->viewSmallNewsByCategory($category, $array_news);


?>