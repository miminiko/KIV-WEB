<?php 

    include_once("/model/database.mod.class.php");
    include_once("/view/loginprocess.class.php");

    $db = new MyDB();
    $logUser = new loginprocess();

	$action = @$_REQUEST["action"];
    $alert = true;
    if($action == "login"){
            $username = $_REQUEST['username'];
            $userpassword = $_REQUEST['userpassword'];
//            echo "password is ".$userpassword;
            if(!$db->loginUserInDataBaze($username, $userpassword)){
                $alert = false;
            }
            else{
                $typeNumber = @$_SESSION["user"]["type_id"];
                $logUser ->infoUser();
                $page="home";
            }

    }
    if($action == "logOut"){
        @session_unset($_SESSION["user"]);
    }

    if(!isset($_SESSION["user"])){
        $logUser->logIn($alert);
    }

$db->close();
unset($db);
unset($logUser);
?>

