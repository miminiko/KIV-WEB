<?php
    require_once("/model/database.mod.class.php");
    include_once("/model/opennews.mod.class.php");

    $cat_id = @$_REQUEST["cat"];
    $db = new MyDB();
    $category_template = new viewNews();
    //vyhledavani informace o categorie
    $category = $db ->getCategoryById($cat_id);
    //vyhledavani vsech prispevku podle categorie
    $array_news = $db->getNewsByCategoryId($cat_id);
    //template bude zaplnena jenom prispevkama vybrane categorie
    $category_template->viewSmallNewsByCategory($category, $array_news);

    $db->close();
    unset($db);

?>