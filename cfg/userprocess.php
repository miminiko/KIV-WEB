<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 11.10.2017
 * Time: 16:59
 */


class userprocess{

    function __construct(){
        @session_start();
    }

    function getUserMainInfo(){
        ?>

        <div class="container">
            <h3>User</h3>
            <b>Name: </b> <?php echo $_SESSION["user"]["login"] ?> <br>
            <b>E-main: </b> <?php echo $_SESSION["user"]["email"] ?> <br>
        </div>

        <?php
    }


}
?>