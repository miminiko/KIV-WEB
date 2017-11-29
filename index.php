<?php

session_start();

define("INDEX", ""); // ????????? ????????? ???????? ???????????
include("view/menu.mod.class.php"); //get menu
require_once("/model/database.mod.class.php"); // ??????????? ????
//wrapper
require_once ("model/phpWrapper.mod.class.php");
$wrapper = new wrapper();

$menu = new myMenu();
$page = @$_REQUEST["page"];
$db = new MyDB();
$category = $db->getAllCategory();

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
    default:$filename = $pages[9];//404
        break;

}

$content = $wrapper ->phpWrapperFromFile($filename);
$getMenu = $menu->getMenuByUser( $category);
$title = $menu->namepage($page);

    // nacist twig - kopie z dokumentace
    require_once 'twig-master/lib/Twig/Autoloader.php';
    Twig_Autoloader::register();

    // cesta k adresari se sablonama - od index.php
    $loader = new Twig_Loader_Filesystem('sablon');
    $twig = new Twig_Environment($loader); // takhle je to bez cache

    // nacist danou sablonu z adresare
    $template = $twig->loadTemplate('sablon.html');

    // render vrati data pro vypis nebo display je vypise
    // v poli jsou data pro vlozeni do sablony
    $template_params = array();
//    $template_params["menu"] = $getMenu;
    $template_params["content"] = $content;
    $template_params["title"] = $title;
    echo $template->render($template_params);


?>
