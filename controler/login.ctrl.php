<?php 

    include_once("/model/database.mod.class.php");
    include_once("/view/loginprocess.class.php");

    $db = new MyDB();
    $logUser = new loginprocess();

	$action = @$_REQUEST["action"];
    $alert = true;
/// controla logina a hesla uzivatele
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
            }

    }

//// odhlaseni uzivatele
    if($action == "logOut"){
        @session_unset($_SESSION["user"]);
    }
///prihlaseni jestli uzivatel zatim nebyl prihlasen
    if(!isset($_SESSION["user"])){
        $logUser->logIn($alert);
    }else{
        header('Location: http://localhost/index.php?page=404');
    }

$db->close();
unset($db);
unset($logUser);
?>

