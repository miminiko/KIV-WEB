<?php 

    include_once("/cfg/core.php");
    include_once("/cfg/loginprocess.php");
//    session_start();

    $db = new MyDB();
    $logUser = new loginprocess();

	$action = @$_REQUEST["action"];
    echo "it is " .$action;

    $alert = true;
    if($action == "login"){
            $username = $_REQUEST['username'];
            $userpassword = $_REQUEST['userpassword'];
            if(!$db->loginUserInDataBaze($username, $userpassword)){
                $alert = false;
            }

    }
    if($action == "logOut"){
        @session_unset($_SESSION["user"]);
    }

//    if(!isset($_SESSION["user"])){
        $logUser->logIn($alert);
//    }

$db->close();
unset($db);
unset($logUser);
?>

