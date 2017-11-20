<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 11.10.2017
 * Time: 17:58
 */
include_once("/model/database.mod.class.php");
include_once("/view/addnews.mod.class.php");

$db = new MyDB();
$news = new news();

$action = @$_REQUEST["action"];
$idNews = @$_REQUEST["newsid"];
$id_user = @$_SESSION["user"]["id"];
//zakazovani pristupu neprihlasenych uzivatelu
if($id_user){
    ///pridani prispevku
    if($action == "addnews"){
        $user_id = @$_SESSION["user"]["id"];;
        $newTitle = $_REQUEST['newTitle'];
        $newText = $_REQUEST['newText'];
        $category = $_REQUEST['selectCategory'];
        $imageNews = $_REQUEST['imageNews'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $result = "something";
        if(!empty($_FILES["fileToUpload"])){
            $fileToUpdate = $_FILES["fileToUpload"];
            if($fileToUpdate["error"]!== UPLOAD_ERR_OK){
                echo "<p>An error occurred.</p>";
            }
        }else{
            $result = "nothing";
        }
        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $fileToUpdate["name"]);

        // don't overwrite an existing file
        $i = 0;
        $parts = pathinfo($name);
        while (file_exists($target_dir . $name)) {
            $i++;
            $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
        }

        // preserve file from temporary directory
        $success = move_uploaded_file($fileToUpdate["tmp_name"],
            $target_dir . $name);
        if (!$success) {
            echo "<p>Unable to save file.</p>";
            exit;
        }

        // set proper permissions on the new file
        chmod($target_dir . $name, 0644);

//            echo '<pre>', print_r($_SESSION["user"], true), '</pre>';
        if($db->addNewNews($newTitle, $newText, $user_id, $category, $imageNews, $name)){
            $news->alertNewsWasAdded();
        }else{
            ?>
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Ops!</strong> something was wrong, please, try again.
            </div>
            <?php
        }
    }else if($action == "setnews"){
        $idNews = @$_REQUEST["newsid"];
        $newTitle = $_REQUEST['newTitle'];
        $newText = $_REQUEST['newText'];
        $category = $_REQUEST['selectCategory'];
        $imageNews = $_REQUEST['imageNews'];




        if($db->setNews($idNews, $newTitle, $newText, $category, $imageNews)){
            $news->alertNewsWasEdited();
        }
    }else if($idNews ==  "" &&  @$_SESSION["user"]["id"]>0){
        $news->getFormForNews($db -> getAllCategory());
    }else{
        $newsForSet = $db->getOneNewsWithArrayComment($idNews);
        ///kontrola aby uzivatel nemel pristup k cizim a jiz publikovanym prispevku
        if($newsForSet["public"]==0 && $newsForSet["user_id"] == $id_user){
            $news->setNews($newsForSet,$db->getAllCategory());
        }else{
            header('Location: http://localhost/index.php?page=404');
        }
    }
}else{
    header('Location: http://localhost/index.php?page=404');
}


$db->close();
unset($db);
unset($news);

?>


