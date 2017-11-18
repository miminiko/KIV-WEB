<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 13.10.2017
 * Time: 16:48
 */

class admin{

    public $cat;

    function __construct(){
        @session_start();
    }

    /***
     * vrati tabulu pro pridani uzivatelem na hodnoceni prispevek
     * @param $news_id
     * @param $author_login
     * @param $users
     * @param $news_review
     */
    function selection_users_for_review($news_id, $author_login, $users, $news_review){



        ?>
        <table class="table table-striped table-hover ">
            <thead>
            <tr>
                <th>User ID</th>
                <th>User login</th>
                <th>Select</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $item){
                if($author_login != $item['login']){
                    $can_confirm = true;
                    $result = "no result";
                }else{
                    $can_confirm = false;
                    $result = "it`s author";

                }
                               ?> >
                    <td><?php echo $item['id'] ?></td>
                    <td><?php echo $item['login']   ?></td>
                    <td>
                        <?php foreach ($news_review as $review){
                            if($review['user_id']==$item['id']){
                                $can_confirm=false;
                                if($review['actualite'] != null && $review['style'] && $review['quality']){
                                    $result = ($review['actualite']+$review['style']+$review['quality'])/3;
                                }
                            }
                        }
                        if($can_confirm){
                ?>
                        <form method="post" class="table_content_form">

                                <button type="submit"  class="btn btn-success btn-xs"
                                        name="review_news" data-toggle="modal" data-target="#modalConfirm<?php echo $item['id'] ?>" >Confirm</button>
                            <input type="hidden" name="user_id" value="<?php echo $item['id'] ?>"/>
                            <input type="hidden" name="news_id" value="<?php echo $news_id ?>"/>

                        </form>
                            <?php }else{
                            echo $result;
                        } ?>

                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>


        <?php
    }

    /***
     * vrati controlni panel pro administratora
     * @param $category
     * @param $news
     * @param $users
     * @param $news_review
     */
    function getAdminTables($category, $news, $users, $news_review){
        $cat = $category;

        $count_new_users = 0;
        foreach ($users as $item){
            if($item['type_name']=="new") $count_new_users++;
        }

        $count_dont_publish_news = 0;
        foreach ($news as $item){
            if($item['public']==0) $count_dont_publish_news++;
        }
        ?>
        <div class="jumbotron">
            <h1 class="display-3">Hi, admin!</h1>
            <p> Your account setting is <a href="index.php?page=userconsole">here</a></p>
            <br/>
        </div>

        <div>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#userstable" data-toggle="tab" aria-expanded="true">User
                    <?php if($count_new_users >0 ){ ?><span class="badge"><?php echo $count_new_users ?></span>
                    <?php } ?></a> </a></li>
            <li class=""><a href="#newspanel" data-toggle="tab" aria-expanded="false">News
                    <?php if($count_dont_publish_news >0 ){ ?><span class="badge"><?php echo $count_dont_publish_news ?></span>
                    <?php } ?></a> </a></li>
            <li class=""><a href="#categorytable" data-toggle="tab" aria-expanded="true">Category</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="userstable">
                <h2>Users table</h2>
                <br>
                <table class="table table-striped table-hover ">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User login</th>
                        <th>e-mail</th>
                        <th>User type</th>
                        <th>Edit type</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $item){
                        $type = 2;
                        ?>
                        <tr <?php $publiting = "";
                        if($item['type_name']== "new"){
                            $type = 0;
                            ?>
                            class = "success";
                            <?php
                        }else if($item['type_name']== "blocked") {
                            $type = 3;
                            ?>
                            class = "danger";
                            <?php
                        }else if($item['type_name']== "admin") {
                            $type = 1;
                            ?>
                            class = "info";
                            <?php
                        }
                        ?> >
                            <td><?php echo $item['id'] ?></td>
                            <td><?php echo $item['login']   ?></td>
                            <td><?php echo $item['email'] ?></td>
                            <td><?php echo $item['type_name'] ?></td>
                            <td>
                                <form method="post" class="table_content_form">

                                <?php if($type==0){ ?> <!-- "new"-->
<!--                                    <input type="hidden" name="action" value="settype">-->
                                    <button type="submit"  class="btn btn-success btn-xs"
                                            name="confirm" data-toggle="modal" data-target="#modalConfirm<?php echo $item['id'] ?>" >Confirm</button>
                                <?php }
                                if($type == 3){ ?> <!-- "blocked"-->
                                        <button type="submit"  class="btn btn-warning btn-xs"
                                                name="unblock" data-toggle="modal" data-target="#modalUnBlock<?php echo $item['id'] ?>" >Unblock</button>
                                <?php }
                                if($type == 2 || $type==0){ ?>
                                        <button type="submit"  class="btn btn-warning btn-xs"
                                                name="block" data-toggle="modal" data-target="#modalBlock<?php echo $item['id'] ?>" >Block</button>
                                <?php }
                                if($type == 2 || $type==0 || $type==3){ ?>
                                        <button type="submit"  class="btn btn-danger btn-xs"
                                                name="delete" data-toggle="modal" data-target="#modalDelete<?php echo $item['id'] ?>" >Delete</button>
                                <?php }?>
                                    <input type="hidden" name="user_id" value="<?php echo $item['id'] ?>"/>
                                </form>

                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>

            </div>
            <div class="tab-pane fade " id="newspanel">
                <h2>News table</h2>
                <br>
                <table class="table table-striped table-hover ">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>User</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Publish</th>
                        <th>Rating (already voted / total)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($news as $item){
                        $count_users = 0;
                        $rating = 0;
                        $count_users_for_rating = 0;
                        foreach ($news_review as $review){
                            if($review['news_id']==$item['id']){
                                $count_users++;
                                if($review['actualite'] != null && $review['style'] && $review['quality']){
                                    $rating += ($review['actualite']+$review['style']+$review['quality'])/3;
                                    $count_users_for_rating++;
                                }
                            }
                        }
                        if($count_users_for_rating > 0){
                            $rating = $rating/$count_users_for_rating;
                        }
                        $date=date_create($item['date']);

                        ?>
                        <tr <?php $publiting = "";
                        $add_user = false;
                        if($item['public']==0){
                            $publiting = "Accept";
                            $add_user = true;
                           ?>
                            class = "success";
                            <?php
                        }else{
                            $publiting= "Is publish";
                        }
                        ?> >
                            <td><?php echo $item['id'] ?></td>
                            <td><em><?php echo  date_format($date, 'd.m.Y') ?></em></td>
                            <td><?php echo $item['login'] ?></td>
                            <td>
                                <a href='index.php?page=page&&newsid=<?php echo $item['id']?>' action="open_news">
                                    <?php echo $item['title'] ?></a>
                            </td>
                            <td><?php echo $item['category_name'] ?></td>
                            <td>
                                <div style="display: inline-block;">
                                    <form method="post" class="table_content_form">
                                        <?php if($add_user){
                                            ?>
                                            <button type="submit"  class="btn btn-primary btn-xs" name="add_users_for_review">select</button>
                                            <input type="hidden" name="news_id" value="<?php echo $item['id'] ?>"/>
                                            <button type="submit"  class="btn btn-success btn-xs" name="publish_news">Accept</button>
                                            <input type="hidden" name="news_id" value="<?php echo $item['id'] ?>"/>
                                            <?php
                                        }else{
                                            ?>
                                            <button type="button" class="btn btn-success btn-xs disabled">Is publish</button>
                                            <?php
                                        }
                                        ?>
                                        <button type="submit"  class="btn btn-danger btn-xs" name="delete_news">delete </button>
                                        <input type="hidden" name="news_id" value="<?php echo $item['id'] ?>"/>
                                        <input type="hidden" name="author_login" value="<?php echo $item['login'] ?>"/>

                                    </form>
                                </div>
                            </td>
                            <td>
                                <?php echo $rating?>(<?php echo $count_users_for_rating?>/<?php echo $count_users?>)
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade " id="categorytable">
                <h2>Category table</h2>
                <br>
                <table class="table table-striped table-hover ">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name category</th>
                        <th>News in category</th>
                        <th>Image</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cat as $category){ ?>
                    <tr>
                        <td><?php echo $category['id'] ?></td>
                        <td><?php echo $category['category_name'] ?></td>
                        <td><?php echo $category['count_news']?></td>
                        <td><?php echo $category['image_url'] ?></td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
                <button type="submit"  class="btn btn-primary" data-toggle="modal" data-target="#modalForCategory">Add new category</button>
            </div>
        </div>
        </div>

        <!-- Modal For Category -->
        <div class="modal fade" id="modalForCategory" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Adding new category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group has-success">
                            <form  action="" method="post" class="form-horizontal">
                                <label class="form-control-label" for="inputSuccess1">Name new category</label>
                                <input type="text" class="form-control is-valid" id="inputValid" name="name_new_category">
                            <br/>
                                <label class="form-control-label" for="inputSuccess1">Image url</label>
                                <input type="text" class="form-control is-valid" id="inputValid" name="url_img_category">
                            </form>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <form method="post" class="table_content_form">
                            <button type="submit"  class="btn btn-success" name="add_new_category">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!--        <!-- Modal For Confirmation User -->-->
<!--        --><?php //foreach ($users as $item) {
////                echo "ID is" .$item['id'];
//            ?>
<!--            <div class="modal fade" id="modalConfirm--><?php //echo $item['id'] ?><!--" role="dialog">-->
<!--                <div class="modal-dialog modal-lg">-->
<!--                    <div class="modal-content">-->
<!--                        <div class="modal-header">-->
<!--                            <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--                            <h4 class="modal-title">Confirmation</h4>-->
<!--                        </div>-->
<!--                        <div class="modal-body">-->
<!--                            <p>Do you really want to confirm user --><?php //echo  $item['login']?><!--?</p>-->
<!--                        </div>-->
<!--                        <div class="modal-footer">-->
<!--                            <form action="" method="POST">-->
<!--                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--                            <input type="hidden" name="action" value="confirmUser">-->
<!--                            <button type="submit" class="btn btn-primary" data-dismiss="modal" name="--><?php //echo $item['id'] ?><!--">Confirm</button>-->
<!--                            </form>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <!--            block user -->-->
<!--            <div class="modal fade" id="modalBlock--><?php //echo $item['id'] ?><!--" role="dialog">-->
<!--                <div class="modal-dialog modal-lg">-->
<!--                    <div class="modal-content">-->
<!--                        <div class="modal-header">-->
<!--                            <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--                            <h4 class="modal-title">Confirmation</h4>-->
<!--                        </div>-->
<!--                        <div class="modal-body">-->
<!--                            <p>Do you really want to block user --><?php //echo  $item['login']?><!--?</p>-->
<!--                        </div>-->
<!--                        <div class="modal-footer">-->
<!--                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--                            <input type="hidden" name="action" value="blockUser">-->
<!--                            <button type="submit" class="btn btn-primary" >Block</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <!--            unblock user -->-->
<!--            <div class="modal fade" id="modalUnBlock--><?php //echo $item['id'] ?><!--" role="dialog">-->
<!--                <div class="modal-dialog modal-lg">-->
<!--                    <div class="modal-content">-->
<!--                        <div class="modal-header">-->
<!--                            <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--                            <h4 class="modal-title">Confirmation</h4>-->
<!--                        </div>-->
<!--                        <div class="modal-body">-->
<!--                            <p>Do you really want to unblock user --><?php //echo  $item['login']?><!--?</p>-->
<!--                        </div>-->
<!--                        <div class="modal-footer">-->
<!--                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--                            <input type="hidden" name="action" value="unblockUser">-->
<!--                            <button type="submit" class="btn btn-primary" >Block</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <!--            delete user -->-->
<!--            <div class="modal fade" id="modalDelete--><?php //echo $item['id'] ?><!--" role="dialog">-->
<!--                <div class="modal-dialog modal-lg">-->
<!--                    <div class="modal-content">-->
<!--                        <div class="modal-header">-->
<!--                            <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--                            <h4 class="modal-title">Confirmation</h4>-->
<!--                        </div>-->
<!--                        <div class="modal-body">-->
<!--                            <p>Do you really want to delete user --><?php //echo  $item['login']?><!--?</p>-->
<!--                        </div>-->
<!--                        <div class="modal-footer">-->
<!--                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--                            <input type="hidden" name="action" value="deleteUser">-->
<!--                            <button type="submit" class="btn btn-primary" >Block</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!---->
<!--            --><?php
//        }



    }

    }
?>