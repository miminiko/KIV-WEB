<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 11.10.2017
 * Time: 17:58
 */
include_once("/cfg/core.php");
include_once("/cfg/addnews.php");

$db = new MyDB();
$news = new news();

$action = @$_REQUEST["action"];
echo "it is " .$action;

if($action == "addnews"){
    $user_id = @$_SESSION["user"]["id"];;
    $newTitle = $_REQUEST['newTitle'];
    $newText = $_REQUEST['newText'];
//    $userpassword = $_REQUEST['userpassword'];
    echo "info user is ".$user_id." title ".$newTitle." text ".$newText;
    $db->addNewNews($newTitle, $newTitle, $user_id, 1);
    $news->alertNewsWasAdded();
}
$news->getFormForNews();


?>