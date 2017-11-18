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

    /****
     * template s uzivatelskymi data
     * @param $newsByUser
     * @param $news_review
     */
    function getUserMainInfo($newsByUser, $news_review)
    {
        $type = "";
        switch ($_SESSION["user"]["type_id"]) {
            case 4:
                $type = "Hi, you are new here!";
                break;
            case 3:
                $type = "<p class=\"text-danger\"> Ops, you are blocked! </p>";
                break;
            case 2:
                $type = "Hi!";
                break;
        }

        ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="well bs-component">
                    <form action="" method="post" class="form-horizontal">
                        <fieldset>
                            <legend><?php echo $type ?> (your ID is <?php echo $_SESSION["user"]["id"] ?>)</legend>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Login</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputDefault" disabled=""
                                           value="<?php echo $_SESSION["user"]["login"] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputDefault" disabled=""
                                           value="<?php echo $_SESSION["user"]["email"] ?>">
                                </div>
                            </div>

                            <input type="hidden" name="action" value="edit_user_info"><!--  action here  -->
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php if (count($newsByUser) > 0) { ?>
        <h2>Your news</h2>
        <table class="table table-striped table-hover ">
            <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Publish</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php foreach ($newsByUser

                as $item){
                $date = date_create($item['date']);

                ?>
            <tr <?php $publiting = "";
            if ($item['public'] == 0) {
                $publiting = "Edit";
                ?>
                class="success";
                <?php
            } else {
                $publiting = "Is publish";
            }
            ?> >
                <td><em><?php echo date_format($date, 'd-m-Y') ?></em></td>
                <td>
                    <?php if ($item['public'] == 0){ //it is not publish

                    ?>
                    <a href='index.php?page=addnews&&newsid=<?php echo $item['id'] ?>' action="set_news">
                        <?php }else{ ?>
                        <a href='index.php?page=page&&newsid=<?php echo $item['id'] ?>' action="open_news">
                            <?php } ?>
                            <?php echo $item['title'] ?></a>
                </td>
                <td>
                    <?php
                    if ($item['public'] == 1) {
                        echo $publiting;
                    } else {
                        ?>
                        <a href='index.php?page=addnews&&newsid=<?php echo $item['id'] ?>' type="submit"
                           class="btn btn-success btn-xs" name="edit_news"><?php echo $publiting; ?> </a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            </tr>
            </tbody>
        </table>
        <?php
    }
        if (count($news_review) > 0) {
            $choise = array("1" => "excellent", "2" => "good", "3" => "bad");
//             echo '<pre>', print_r($news_review, true), '</pre>';

            ?>
            <h2>News for control</h2>


            <table class="table table-striped table-hover ">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Actualite</th>
                    <th>Quality</th>
                    <th>Style</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php foreach ($news_review as $item){

                        ?>
                    <form method="post" class="table_content_form">

                    <td>
                        <a href='index.php?page=page&&newsid=<?php echo $item['id'] ?>' action="open_news">
                            <?php echo $item['title'] ?></a>
                    </td>
                    <td>

                        <select class="form-control" name="selectActualite<?php echo $item['id'] ?>">
                            <?php foreach ($choise as $key => $value) {
                                if($item['actualite']!= NULL && $item['actualite']==$key){
                                    ?>
                                    <option selected="selected" value="<?php echo $value ?>"><?php echo $value ?></option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                    <?php
                                }
                            } ?>
                        </select>

                    </td>
                    <td>
                        <select class="form-control" name="selectQuality<?php echo $item['id'] ?>">
                            <?php foreach ($choise as $key => $value) {
                                if($item['quality']!= NULL && $item['quality']==$key){
                                    ?>
                                    <option selected="selected" value="<?php echo $value ?>"><?php echo $value ?></option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                    <?php
                                }
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" name="selectStyle<?php echo $item['id'] ?>">
                            <?php foreach ($choise as $key => $value) {
                                if($item['style']!= NULL && $item['style']==$key){
                                    ?>
                                    <option selected="selected" value="<?php echo $value ?>"><?php echo $value ?></option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                    <?php
                                }
                            } ?>
                        </select>
                    </td>
                    <td>
                        <form method="post" class="table_content_form">
                            <button type="submit" class="btn btn-success" name="save_chose">save</button>
                            <input type="hidden" name="news_id" value="<?php echo $item['id'] ?>"/>
                            <input type="hidden" name="review_news_id" value="<?php echo $item['review_news_id'] ?>"/>
                        </form>
                    </td>
                    </form>

                </tr>
                <?php } ?>
                </tr>
                </tbody>
            </table>
            <?php
        }
    }


    /***
     * forma pro zmenu uzivatelem date
     */
    function setUserInfoTemplate(){

        ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="well bs-component">
                    <form  action="" method="post" class="form-horizontal">
                        <fieldset>
                            <legend>User</legend>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Login</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputDefault"  name="newuserlogin"
                                           value="<?php echo $_SESSION["user"]["login"] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputDefault"  name="newUserEmail"
                                           value="<?php echo $_SESSION["user"]["email"] ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                                <div class="col-lg-10">
                                    <input type="password" class="form-control" id="inputPassword"  name="newUserPassword"
                                           placeholder="Password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" autocomplete="off">
                                </div>
                            </div>
                            <input type="hidden" name="action" value="save_user_info"><!--  action here  -->
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
<!--                                    <button type="reset" class="btn btn-default">Cancel</button>-->
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
<?php
    }

}
?>