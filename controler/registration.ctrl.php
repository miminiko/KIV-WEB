<?php

include_once("/model/database.mod.class.php");
include_once("/model/registrationprocess.mod.class.php");

$db = new MyDB();
$registration = new registrationprocess();

$action = @$_REQUEST["action"];

//registrace novyho uzivatele
if($action == "registration"){

    if($_REQUEST['pswNewUser'] != $_REQUEST['pswNewUser-repeat']){
        ?>
        <div class="alert alert-danger">
            <strong>Password incorrectly repeated</strong>
        </div>
        <?php

    }else{
        $loginNewUser = $_REQUEST['loginNewUser'];

        if($db->controlNewLogin($loginNewUser)){
            $emailNewUser = $_REQUEST['emailNewUser'];
            $pswNewUser = $_REQUEST['pswNewUser'];
            $db->addNewUser($loginNewUser, $emailNewUser, $pswNewUser);
            if($db->loginUserInDataBaze($loginNewUser, $pswNewUser)){
                $registration->infoUser();
            }
        }else{
            ?>
            <div class="alert alert-danger">
                <strong>Bad login.</strong>
            </div>
            <?php
        }
    }
}

///jestli uzivatel neni prihlasen
if(!isset($_SESSION["user"])){
    $registration->getFormRegistration();
}else{
    header('Location: http://localhost/index.php?page=404');
}

$db->close();
unset($db);
unset($registration);
?>