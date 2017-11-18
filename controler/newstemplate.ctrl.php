<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 11.10.2017
 * Time: 17:58
 */
include_once("/model/database.mod.class.php");
include_once("/view/addnews.mod.class.php");

$db = new MyDB();
$news = new news();

$action = @$_REQUEST["action"];
$idNews = @$_REQUEST["newsid"];

///pridani prispevku
if($action == "addnews"){
    $user_id = @$_SESSION["user"]["id"];;
    $newTitle = $_REQUEST['newTitle'];
    $newText = $_REQUEST['newText'];
    $category = $_REQUEST['selectCategory'];
    $imageNews = $_REQUEST['imageNews'];
//            echo '<pre>', print_r($_SESSION["user"], true), '</pre>';
    if($db->addNewNews($newTitle, $newText, $user_id, $category, $imageNews)){
        $news->alertNewsWasAdded();
    }else{
        ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ops!</strong> something was wrong, please, try again.
        </div>
    <?php
    }
}else if($action == "setnews"){
    $idNews = @$_REQUEST["newsid"];
    $newTitle = $_REQUEST['newTitle'];
    $newText = $_REQUEST['newText'];
    $category = $_REQUEST['selectCategory'];
    $imageNews = $_REQUEST['imageNews'];

    if($db->setNews($idNews, $newTitle, $newText, $category, $imageNews)){
        $news->alertNewsWasEdited();
    }
}else if($idNews ==  ""){
    $news->getFormForNews($db -> getAllCategory());
}else{
    $newsForSet = $db->getOneNewsWithArrayComment($idNews);
    ///kontrola aby uzivatel nemel pristup k cizim a jiz publikovanym prispevku
    if($newsForSet["public"]==0 && $newsForSet["user_id"] == @$_SESSION["user"]["id"]){
        $news->setNews($newsForSet,$db->getAllCategory());
    }else{
        header('Location: http://localhost/index.php?page=404');
    }
}
$db->close();
unset($db);
unset($news);

?>


