<?php

session_start();

define("INDEX", ""); // ????????? ????????? ???????? ???????????
include("model/menu.php"); //get menu
require_once("/cfg/core.php"); // ??????????? ????
$menu = new myMenu();
$page = @$_REQUEST["page"];

if($page == ""){
    $page = 'home';
}
// set page
switch ($page) {
case "home": $filename = $pages[0]; break;
case "category": $filename = $pages[1]; break;
case "login": $filename = $pages[2]; break;
case "registration": $filename = $pages[3]; break;
case "contact": $filename = $pages[4]; break;
case "userconsole": $filename = $pages[5]; break;
case "admin": $filename =$pages[6]; break;
case "addnews": $filename=$pages[7]; break;
case "page": $filename=$pages[8]; break;
        //+ 404
}

$typeNumber = @$_SESSION["user"]["type_id"];
$name = @$_SESSION["user"]["login"];
if($typeNumber == ""){
    $typeNumber = 0;
}
echo "<br> typeNumber is " .$typeNumber. "<br>";

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css\sandstone\bootstrap.css" media="screen">
        <link rel="stylesheet" href="css\sandstone\bootstrap.min.css">
        <link rel="stylesheet" href="../css/assets/css/custom.min.css">
        <link rel="stylesheet" href="\css\mystyle.css">
        Try it Yourself »

        <script type="text/javascript" src="bootstrap/bootstrap.js" charset="UTF-8"></script>
        <script src="/js/ValidationFormScript.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <title><?=$title?></title>
    </head>
    <body>
       <div class="container">
<?php
$getMenu = $menu->getMenuByUser( $typeNumber);
?>

           
<?php
include($filename);

?>

       </div>
       <footer>
       <div class="row">
       <div class="col-lg-10">
           <p>Made by <a href="https://www.facebook.com/marjia.sivakova" rel="nofollow">Sivakova Maryia</a>. Contact me at <a href="mailto:mari.sivakova@seznam.cz">mari.sivakova@seznam.cz</a>.</p>
       </div>
       </div>
       </footer>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    </body>
</html>
