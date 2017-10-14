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

    function getAdminTables($category, $news, $users){
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
                        $booleanIsAdmin = false;
                        ?>
                        <tr <?php $publiting = "";
                        if($item['type_name']== "new"){
                            ?>
                            class = "success";
                            <?php
                        }else if($item['type_name']== "blocked") {
                            ?>
                            class = "danger";
                            <?php
                        }else if($item['type_name']== "admin") {
                            $booleanIsAdmin = true;
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
                                <?php if(!$booleanIsAdmin){ ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="action" value="settype">
                                    <button type="submit"  class="btn btn-success btn-xs" name="block">Confirm</button>
                                    <input type="hidden" name="action" value="block">
                                    <button type="submit"  class="btn btn-warning btn-xs" name="block">Block</button>
                                </form>
                                <?php } ?>
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
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($news as $item){
                        $date=date_create($item['date']);

                        ?>
                        <tr <?php $publiting = "";
                        if($item['public']==0){
                            $publiting = "no";
                           ?>
                            class = "success";
                            <?php
                        }else{
                            $publiting= "yes";
                        }
                        ?> >
                            <td><?php echo $item['id'] ?></td>
                            <td><em><?php echo  date_format($date, 'd-m-Y') ?></em></td>
                            <td><?php echo $item['login'] ?></td>
                            <td><?php echo $item['title'] ?></td>
                            <td><?php echo $item['category_name'] ?></td>
                            <td><?php echo $publiting ; ?></td>
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
                        <td>Column content</td>
                        <td><?php echo $category['image_url'] ?></td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
                <a href="#" class="btn btn-primary">Add new category</a>
            </div>
        </div>
        </div>
        <?php


    }

    function confirmUser(){
        ?>

        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body…</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


        <?php
    }



}
?>