﻿<?php defined('INDEX') OR die('Прямой доступ к странице запрещён!');
/* КОМПОНЕНТ СТРАНИЦЫ */
include_once("/model/database.mod.class.php");
include_once("/model/opennews.mod.class.php");

$db = new MyDB();
$home = new viewNews();
$action = @$_REQUEST["action"];

//publikace prispevku adminem
if(isset($_POST["publish_news"])){
    $news_id = $_POST['news_id'];
    if($db->publishNews($news_id)){
       ?>
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Well done!</strong> News was publishing</a>.
        </div>

<?php
    }
}

//pridani commenta
if(isset($_POST["post_comment"])){
    $news_id = $_POST['news_id'];
    $user_id = $_SESSION["user"]["id"];
    $text_comment = $_REQUEST['text_comment'];
    if($db->addNewComment($user_id, $news_id, $text_comment)){

    }
}

if(isset($_POST["download"])){
    $file_name= $_POST["file_url"];
    $file_path = "uploads/".$_POST["file_url"];
    if(file_exists($file_path)){
        header("Cache-Control: public");
        header("Content-disposition: attachment; filename=".$file_name);
        header("Content-type: application/pdf");
        readfile($file_path);
    }else{
?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ops! Something was wrong...</strong>
        </div>

        <?php
    }
}

$idNews = @$_REQUEST["newsid"];
$home->getNewsTemplate($db->getOneNewsWithArrayComment($idNews), $db->getAllCommentByNewsId($idNews));


$db->close();
unset($db);
unset($home);
?>