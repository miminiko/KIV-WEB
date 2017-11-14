<?php
    require_once("/model/database.mod.class.php");
    include_once("/model/opennews.mod.class.php");

    $cat = @$_REQUEST["cat"];
    $db = new MyDB();
    $home = new viewNews();
    $category = $db ->getCategoryById($cat);
    $array_news = $db->getNewsByCategoryId($cat);
    $home->viewSmallNewsByCategory($category, $array_news);


?>