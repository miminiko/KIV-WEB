<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 11.10.2017
 * Time: 15:21
 */
include_once("/model/database.mod.class.php");
include_once("/view/admin.mod.class.php");

//osetreni je-li uzivatel typu admin
if(@$_SESSION["user"]["type_id"] == 1){
    $administration = new admin();
    $db = new MyDB();
    $_SESSION["menu"] = $db->getAllCategory();

    $action = @$_REQUEST["action"];

    if(isset($_POST["publish_news"])){
        $news_id = $_POST['news_id'];
        if($db->publishNews($news_id)){

        }
    }
    if(isset($_POST["delete_news"])){
        $news_id = $_POST['news_id'];
        if($db->deleteNews($news_id)){

        }

    }
    if(isset($_POST["confirm"]) || isset($_POST["unblock"])){
        $user_id=$_POST["user_id"];
        if($db->setTypeUser($user_id, 2)){

        }
    }
    if(isset($_POST["block"])){
        $user_id=$_POST["user_id"];
        if($db->setTypeUser($user_id, 3)){

        }
    }
    if(isset($_POST["delete"])){
        $user_id=$_POST["user_id"];
        if($db->deleteUser($user_id)){

        }
    }
    if(isset($_POST["review_news"])){
        $news_id = $_POST['news_id'];
        $users = $_POST['user_id'];
        if(!($db->add_news_review_to_user($news_id, $users))){
            ?>
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Oh snap!</strong> <a href="#" class="alert-link">Change a few things up</a> and try submitting again.
            </div>
            <?php
        }
    }
    if(isset($_POST["add_new_category"])){
        echo "Add new category!!!";
        $name_new_category = $_REQUEST['name_new_category'];
        $url_img = $_REQUEST["url_img_category"];
    }

    $news = $db->getInfoAboutNews();
    $users = $db->getAllUsers();
    $news_review = $db->getAllNewsReview();
    if(isset($_POST["add_users_for_review"])){
        $news_id = $_POST['news_id'];
        $author_login = $_POST['author_login'];
        $administration->selection_users_for_review($news_id, $author_login, $users, $db->getNewsReviewByNewsId($news_id));
    }else{
        $administration->getAdminTables($_SESSION["menu"], $news, $users, $news_review);
    }


    $db->close();
    unset($db);
    unset($administration);

}else{
    // je-li uzivatel jineho typu, aplikace ho vrati na hlavni stranku
    header('Location: http://localhost/index.php?page=home');
}



?>
