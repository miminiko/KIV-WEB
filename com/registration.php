<?php

include_once("/cfg/core.php");
include_once("/cfg/registrationprocess.php");

$db = new MyDB();
$registration = new registrationprocess();

$action = @$_REQUEST["action"];

//$alert = true;
if($action == "registration"){

    if($_REQUEST['pswNewUser'] != $_REQUEST['pswNewUser-repeat']){
        echo "this password is no correct";
    }else{
        $loginNewUser = $_REQUEST['loginNewUser'];
        echo "password is good";

        if($db->controlNewLogin($loginNewUser)){
            echo "login is good";
            $emailNewUser = $_REQUEST['emailNewUser'];
            $pswNewUser = $_REQUEST['pswNewUser'];
            $db->addNewUser($loginNewUser, $emailNewUser, $pswNewUser);
            $db->loginUserInDataBaze($loginNewUser, $pswNewUser);

        }else{
            //TODO alert bad login
        }
    }
}

//if(!isset($_SESSION["user"])){
    $registration->getFormRegistration();
//}

$db->close();
unset($db);
unset($registration);
?>