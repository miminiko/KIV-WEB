<?php defined('INDEX') OR die('Прямой доступ к странице запрещён!');

global $dbhost, $dblogin, $dbpass, $db;
global $pages;
global $actualpage;
global $webUser;

$webUser[0] = 0;//type
$webUser[1] = ''; //name

$pages[0] = 'com/home.php';
$pages[1] = 'com/category.php';
$pages[2] = 'com/login.php';
$pages[3] = 'com/registration.php';
$pages[4] = 'com/contact.php';
$pages[5] = 'com/userconsole.php';
$pages[6] = 'com/admin.php';
$pages[7] ='com/newstemplate.php';
$pages[8] ='com/page.php';


// MYSQL
class MyDB{
    public $conn;
    
    function __construct (){
        // Create connection
        try { //https://www.w3schools.com/PhP/php_mysql_connect.asp
            $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
            $this->conn = new PDO("mysql:host=localhost;dbname=db_web", 'root', '');
            if(!isset($_SESSION))
            {
                session_start();
            }

//            echo "Connected successfully";
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }
    
    function loginUserInDataBaze($userLogin, $userPassword){
        if($this->controlLoginAndPassword($userLogin, $userPassword)){
            $_SESSION["user"] = $this->getAllInfoUsers($userLogin);

            return true;
        }else{
            return false;
        }
    }
    
    function controlLoginAndPassword($login, $password){        
        $pom = $this->getAllInfoUsers($login);
        if($pom != null && $pom["password"]== $password){
            return true;
        }else{
            return false;
        }
    }

    function addNewNews( $title, $text, $user_id, $category_id){
        $mysql_pdo_error = false;
        echo "<br>add new news";
        $query = 'INSERT INTO news (title, date, note, user_id, category_id, public)
            VALUES (:title, :date_today, :text, :user_id, :category_id, 0 );';
        $sth = $this->conn->prepare($query);
        $sth->bindValue(':title', $title, PDO::PARAM_STR);
        $sth->bindValue(':date_today', date("Y-m-d H:i:s"), PDO::PARAM_STR);
        $sth->bindValue(':text', $text, PDO::PARAM_STR);
        $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $sth->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $sth->execute();//insert to db
        $errors = $sth->errorInfo();
        if ($errors[0] + 0 > 0){
            $mysql_pdo_error = true;
        }
        if ($mysql_pdo_error == false){
            //all is ok
            return true;
        }else{
            echo "Eror - PDOStatement::errorInfo(): ";
            print_r($errors);
            echo "SQL : $query";
        }

    }
    
    function addNewUser($loginNewUser, $emailNewUser, $pswNewUser){
            $mysql_pdo_error = false;
            echo "<br>add new user";
            $query = 'INSERT INTO user (login, email, password, type_id)
            VALUES (:loginUser, :emailUser, :passwordUser, 4 )';
            $sth = $this->conn->prepare($query);
            $sth->bindValue(':loginUser', $loginNewUser, PDO::PARAM_STR);
            $sth->bindValue(':emailUser', $emailNewUser, PDO::PARAM_STR);
            $sth->bindValue(':passwordUser', $pswNewUser, PDO::PARAM_STR);
            $sth->execute();//insert to db
            $errors = $sth->errorInfo();
            if ($errors[0] + 0 > 0){
                $mysql_pdo_error = true;
            }
            if ($mysql_pdo_error == false){
                //all is ok
                return true;
            }else{
                echo "Eror - PDOStatement::errorInfo(): ";
                print_r($errors);
                echo "SQL : $query";
            }
    }

    function getAllCategory(){
        $mysql_pdo_error = false;
        $query = "SELECT * FROM category;";
        $sth = $this->conn->prepare($query);
        $sth->execute();
        $errors = $sth->errorInfo();
        if ($errors[0] + 0 > 0){
            $mysql_pdo_error = true;
        }
        if ($mysql_pdo_error == false){
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }else{
            echo "Eror - PDOStatement::errorInfo(): ";
            print_r($errors);
            echo "SQL : $query";
        }
        }

    function controlNewLogin($loginNewUser){
        $mysql_pdo_error = false;
        $query = "SELECT login FROM user;";
        $sth = $this->conn->prepare($query);
        $sth->execute();
        $errors = $sth->errorInfo();
        if ($errors[0] + 0 > 0){
            $mysql_pdo_error = true;
        }
        if ($mysql_pdo_error == false){
            $all = $sth->fetchAll(PDO::FETCH_ASSOC);
            foreach ($all as $oneLogin){
//                echo "<br> Login is ".$oneLogin["login"];
                if($oneLogin["login"]==$loginNewUser){
                    return false;
                }
            }
            return true;
        }else{
            echo "Eror - PDOStatement::errorInfo(): ";
            print_r($errors);
            echo "SQL : $query";
        }
    }

    function getAllUsers(){
        $mysql_pdo_error = false;
        $query = "SELECT user.id, login,email, type_name from  user, type_user 
where user.type_id=type_user.id;";

        $sth = $this->conn->prepare($query);
        $sth->execute();
        $errors = $sth->errorInfo();
        if ($errors[0] + 0 > 0){
            $mysql_pdo_error = true;
        }
        if ($mysql_pdo_error == false){
            $allDate = $sth->fetchAll(PDO::FETCH_ASSOC);
//            echo '<pre>', print_r($allDate, true), '</pre>';
            return $allDate;
        }
        else{
            echo "Eror - PDOStatement::errorInfo(): ";
            print_r($errors);
            echo "SQL : $query";
        }

    }

    function getOneNewsWithArrayComment($id){
        $mysql_pdo_error = false;
        $query = "SELECT title, date, note, public, login, category_name, image_url from news, user, category 
where news.id=:id and news.user_id=user.id and news.category_id=category.id;";

        $sth = $this->conn->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $errors = $sth->errorInfo();
        if ($errors[0] + 0 > 0){
            $mysql_pdo_error = true;
        }
        if ($mysql_pdo_error == false){
            $ourUser = $sth->fetchAll(PDO::FETCH_ASSOC);
//            echo '<pre>', print_r($ourUser, true), '</pre>';
            //Возвращаем следующую строку в виде массива, индексированного именами столбцов
            //http://php.net/manual/ru/pdostatement.fetch.php
            return $ourUser[0];
        }
        else{
            echo "Eror - PDOStatement::errorInfo(): ";
            print_r($errors);
            echo "SQL : $query";
        }

    }


    function getInfoAboutNews(){
        $mysql_pdo_error = false;
        $query = "SELECT news.id, title, date, public, note, login, category_name
FROM  news, user,category where news.user_id = user.id and category.id=category_id order by date DESC ;";

        $sth = $this->conn->prepare($query);
        $sth->execute();
        $errors = $sth->errorInfo();
        if ($errors[0] + 0 > 0){
            $mysql_pdo_error = true;
        }
        if ($mysql_pdo_error == false){
            $allDate = $sth->fetchAll(PDO::FETCH_ASSOC);
//            echo '<pre>', print_r($allDate, true), '</pre>';
            //Возвращаем следующую строку в виде массива, индексированного именами столбцов
            //http://php.net/manual/ru/pdostatement.fetch.php
            return $allDate;
//            }
        }
        else{
            echo "Eror - PDOStatement::errorInfo(): ";
            print_r($errors);
            echo "SQL : $query";
        }
    }

    function getCategoryById($id){
        $mysql_pdo_error = false;
        $query = "SELECT * FROM db_web.category where id=:id;";

        $sth = $this->conn->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $errors = $sth->errorInfo();
        if ($errors[0] + 0 > 0){
            $mysql_pdo_error = true;
        }
        if ($mysql_pdo_error == false){
            $allData = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $allData[0];
        }
        else{
            echo "Eror - PDOStatement::errorInfo(): ";
            print_r($errors);
            echo "SQL : $query";
        }
    }

    function getNewsByCategoryId($id){
        $mysql_pdo_error = false;
        $query = "SELECT news.id, title, date, note, login, category_name 
FROM news, user, category where category_id=:id AND news.user_id=user.id AND news.public=1 AND category_id=category.id AND news.public=1 order by date DESC;";

        $sth = $this->conn->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $errors = $sth->errorInfo();
        if ($errors[0] + 0 > 0){
            $mysql_pdo_error = true;
        }
        if ($mysql_pdo_error == false){
            $allData = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $allData;
        }
        else{
            echo "Eror - PDOStatement::errorInfo(): ";
            print_r($errors);
            echo "SQL : $query";
        }

    }


    function getNewsWithCountComment(){
        $mysql_pdo_error = false;
        $query = "SELECT news.id, title, date, note, login, category_name
FROM  news, user,category where public='1' and news.user_id = user.id and category.id=category_id order by date DESC ;";

        $sth = $this->conn->prepare($query);
        $sth->execute();
        $errors = $sth->errorInfo();
        if ($errors[0] + 0 > 0){
            $mysql_pdo_error = true;
        }
        if ($mysql_pdo_error == false){
            $allDate = $sth->fetchAll(PDO::FETCH_ASSOC);
//            echo '<pre>', print_r($allDate, true), '</pre>';
            //Возвращаем следующую строку в виде массива, индексированного именами столбцов
            //http://php.net/manual/ru/pdostatement.fetch.php
            return $allDate;
//            }
        }
        else{
            echo "Eror - PDOStatement::errorInfo(): ";
            print_r($errors);
            echo "SQL : $query";
        }
    }


    function getAllInfoUsers($login){        
        $mysql_pdo_error = false;
         $query = "select * from user,type_user
     			  where login = :loginUser
     			  and type_user.id = user.id;";

        $sth = $this->conn->prepare($query);
        $sth->bindValue(':loginUser', $login, PDO::PARAM_STR);
        $sth->execute();
        $errors = $sth->errorInfo();
        if ($errors[0] + 0 > 0){
     		$mysql_pdo_error = true;
     	}
        if ($mysql_pdo_error == false){
            $ourUser = $sth->fetchAll(PDO::FETCH_ASSOC);
//            echo '<pre>', print_r($ourUser, true), '</pre>';
            //Возвращаем следующую строку в виде массива, индексированного именами столбцов
            //http://php.net/manual/ru/pdostatement.fetch.php
     		return $ourUser[0];
//            }
     	}
     	else{
     		echo "Eror - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL : $query";
     	} 
    }

    function close() {
        $conn = null; 
        unset($conn);
}

    function run($query) {
        $this->query = $query;
        $this->result = mysql_query($this->query, $this->link);
        $this->err = mysql_error();
    }
    function row() {
    $this->data = mysql_fetch_assoc($this->result);
}
    function fetch() {
    while ($this->data = mysql_fetch_assoc($this->result)) {
    $this->fetch = $this->data;
    return $this->fetch;
}
}
    function stop() {
    unset($this->data);
    unset($this->result);
    unset($this->fetch);
    unset($this->err);
    unset($this->query);
}
}


?>