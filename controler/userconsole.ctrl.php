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
if($allIsOk){
    $userInfo ->getUserMainInfo($db->getNewsByUserId($_SESSION["user"]["id"]));
}


?>