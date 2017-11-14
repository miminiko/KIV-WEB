<?php defined('INDEX') OR die('Прямой доступ к странице запрещён!');
/* КОМПОНЕНТ СТРАНИЦЫ */
include_once("/model/database.mod.class.php");
include_once("/model/opennews.mod.class.php");

$db = new MyDB();
$home = new viewNews();
$action = @$_REQUEST["action"];

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
if(isset($_POST["post_comment"])){
    $news_id = $_POST['news_id'];
    $user_id = $_SESSION["user"]["id"];
    $text_comment = $_REQUEST['text_comment'];
    if($db->addNewComment($user_id, $news_id, $text_comment)){

    }
}

$idNews = @$_REQUEST["newsid"];
$home->getNewsTemplate($db->getOneNewsWithArrayComment($idNews), $db->getAllCommentByNewsId($idNews));

?>