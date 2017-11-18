<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 13.10.2017
 * Time: 18:11
 */
    class viewNews{
        function __construct(){
            @session_start();
        }

        /***
         * template prispevku
         * @param $news
         * @param $comment
         */
        function getNewsTemplate($news, $comment){
            $date=date_create($news['date']);

            ?>
            <div class="col-lg-12">
                <div class="row">
                    <div col-lg-10>
                        <img src="<?php echo $news['image_news_url'] ?>" height="60%" width="60%" style="padding-bottom: 20px;">
                    </div>
                    <div col-lg-6>
                        <?php
                        if(isset($_SESSION["user"])){
                            if($_SESSION["user"]["type_id"] == 1  && $news["public"] == 0){
                                ?>

                                <form method="post" class="table_content_form">
                                    <button type="submit"  class="btn btn-success btn-lg" name="publish_news"> PUBLISH </button>
                                    <input type="hidden" name="news_id" value="<?php echo $news['id'] ?>"/>
                                </form>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <br>
            <h2><?php echo $news['title']?></h2>
            <div>
                <p><span class="text-muted"><?php echo date_format($date, 'd.m.Y');?> </span>
                <span  class="text-success"><?php echo $news['login']?></span ></p>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-10">
                    <div class="news_template">
                        <?php echo $news['note'];?>
                    </div>
                </div>
            </div>

            <?php
//                echo '<pre>', print_r($news, true), '</pre>';

////pridani commentu jenom v pripade jestli prispevek je public
            if($news["public"] == 1){

                if(isset($_SESSION["user"])){
                    ?>
                    <form action="" method="post" class="form-horizontal">
                        <fieldset>
                            <legend>Add a comment</legend>
                            <div class="form-group">
                                <div class="col-lg-4">
                                    <textarea class="form-control" rows="3" id="textArea" name="text_comment"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <form method="post" class="table_content_form">
                                        <button type="submit" class="btn btn-success" name="post_comment">Post a comment</button>
                                        <input type="hidden" name="news_id" value="<?php echo $news['id'] ?>"/>
                                    </form>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                    <?php
                }

                foreach ($comment as $item){
                    $date_comment = date_create($item["date_comment"]);

                    ?>
                    <div class="row">

                        <!--                <div class="comment_item">-->
                        <div class="col-lg-8">

                            <div class="comment_head">
                                <span class="text-muted"><?php echo date_format($date_comment, 'd.m.Y H:i')?></span>
                                <span  class="text-success"><?php echo $item["login"]?></span>
                            </div>
                            <div class="comment-message">
                                <?php echo $item["comment"]?>
                            </div>
                        </div>
                        <!--                </div>-->
                    </div>

                    <?php
                }

            }

        }

        /***
         * mala predstava prispevku
         * @param $arrayNews
         */
        function viewSmallNews($arrayNews){
            ?>
            <div class="posts">
            <?php
            foreach ($arrayNews as $news){
                $date=date_create($news['date']);
                ?>
                <div class="row post text">
                    <div class="col-lg-2">
                        <br>
                        <div class="date">
                            <span class="text-muted"><?php echo date_format($date, 'd.m.Y');?> </span>
                        </div>
                        <div>
                            <p>
                                <span  class="text-success"><?php echo $news['login']?></span ></p>
                        </div>
                    </div>
                    <div class="col-lg-6 entry">
                        <div class="title">
                            <h2>
                                <a href='index.php?page=page&&newsid=<?php echo $news['id'] ?>' action="open_news">
                                    <?php echo $news['title']?></a>
                            </h2>
                        </div>
                        <div class="POST">
                            <figure class="tmblr-full">
                                    <img src="<?php echo $news['image_news_url'] ?>" alt="image" style="width: 500px; height:300px;">
                                <br>
                            </figure>
                        </div>
                    </div>
                <div> <p>
                        <?php if($news['category_name'] != null){
                            ?>
                    <p><span class="text-info"><?php echo $news['category_name']?></span></p>

                            <?php
                        }?>

                </div>
                </div>
                <br>
                <?php

            }
            ?>
            </div>
            <?php
        }

        function viewSmallNewsByCategory($category, $arrayNews){
            ?>
            <div class="col-lg-12">
                <div class="page-header">
                    <img src="<?php echo $category['image_url'] ?>" height="75%" width="75%">
                    <h1><?php echo $category['category_name'] ?></h1>
                </div>
            </div>
            <br>
            <?php
            $this->viewSmallNews($arrayNews);
        }
    }

?>