<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 10.10.2017
 * Time: 20:42
 */

include_once("/model/database.mod.class.php");
include_once("/view/userprocess.mod.class.php");

$db = new MyDB();
$userInfo = new userprocess();

$action = @$_REQUEST["action"];
$allIsOk = true;

///zmena uzivatelskych udaj
if($action == "edit_user_info"){
    $allIsOk = false;
    $userInfo ->setUserInfoTemplate();
}else if($action == "save_user_info"){
    $false_boolean = 0;

    $newLogin = $_REQUEST['newuserlogin'];
    if($newLogin != $_SESSION["user"]["login"]){//user want to have new login
        echo "user want to set login ".$_SESSION["user"]["login"]." to ".$newLogin;

        if($db->controlNewLogin($newLogin)){//login is new
            if($db->setUsersLogin($_SESSION["user"]["id"], $newLogin)){
                ?>
                <div class="alert alert-dismissible alert-info">
                    <strong>Login was set</strong>
                </div>
                <?php
            }
        }else{
            $false_boolean++;
            ?>
            <div class="alert alert-danger">
                <strong>This login is actually exist</strong>
            </div>
            <?php
        }
    }
    $newEmail = $_REQUEST["newUserEmail"];
    if($newEmail != $_SESSION["user"]["email"]){//user want to have new login
        if(!$db->setUsersEmail($_SESSION["user"]["id"], $newEmail)){//login is new
            $false_boolean++;

            ?>
            <div class="alert alert-danger">
                <strong>Error while changing email</strong>
            </div>
            <?php
        }else{
            ?>
            <div class="alert alert-dismissible alert-info">
                <strong>Email was set</strong>
            </div>
            <?php

        }
    }
    $newpassword = $_REQUEST["newUserPassword"];
    if($newpassword != ""){
        if($newpassword != $_SESSION["user"]["password"]){
            if(!$db->setUsersPassword($_SESSION["user"]["id"], $newpassword)){
                $false_boolean++;

                ?>
                <div class="alert alert-danger">
                    <strong>Error while changing password</strong>
                </div>
                <?php
            }else{
                ?>
                <div class="alert alert-dismissible alert-info">
                    <strong>Password was set</strong>
                </div>
                <?php

            }
        }
    }

    if($false_boolean!=0){
        $allIsOk = true;
    }else{
        $_SESSION["user"] = $db ->getAllInfoUsersByID($_SESSION["user"]["id"]);
    }
}

/// hodnoceni uzivatelem prispevku
if(isset($_POST["save_chose"])){
    $news_id = $_REQUEST["news_id"];
    $review_news_id = $_REQUEST["review_news_id"];
    $quality = $_REQUEST["selectQuality".$news_id];
    $style = $_REQUEST["selectStyle".$news_id];
    $actualite = $_REQUEST["selectActualite".$news_id];
    if(!($db->addResultUserReview($review_news_id, $quality, $style, $actualite))){
        //error
    }
}

//template accounta uzivatele
if($allIsOk){
    $id_user = $_SESSION["user"]["id"];
    $userInfo ->getUserMainInfo($db->getNewsByUserId($id_user), $db->getAllNewsReviewByUserId($id_user));
}


$db->close();
unset($db);
unset($userInfo);
?>