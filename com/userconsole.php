<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 10.10.2017
 * Time: 20:42
 */

include_once("/cfg/core.php");
include_once("/cfg/userprocess.php");

   $userInfo = new userprocess();
    $userInfo ->getUserMainInfo();

?>