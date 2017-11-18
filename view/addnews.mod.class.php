<?php
/**
 * Created by PhpStorm.
 * User: endem
 * Date: 11.10.2017
 * Time: 17:19
 */
    class news{

        function __construct(){
            @session_start();
        }

        function alertNewsWasAdded(){
            ?>
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Well don!.</strong> Your news was added. Please waiting for confirmation from admin.
            </div>

            <?php
        }

        function alertNewsWasEdited(){
            ?>
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Well don!.</strong> Your news was edit. Please waiting for confirmation from admin.
            </div>

            <?php
        }

        /***
         * forma pro pridani prispevku
         * @param $category
         */
        function getFormForNews($category){

            ?>
            <div class="row">
                <div class="col-lg-10">
                    <div class="well bs-component">
                        <form  action="" method="post" class="form-horizontal">
                            <fieldset>
                                <legend>New news </legend>
                                <div class="form-group">
                                    <label class="control-label" for="inputDefault">Title</label>
                                    <input type="text" placeholder="Title" required class="form-control" name="newTitle" id="inputDefault">
                                </div>
                                <div class="form-group">
                                    <label for="textArea" class="control-label">Text</label>
                                    <textarea  class="form-control"  name="newText" id="textArea"></textarea>
                                    <script>
                                        CKEDITOR.replace( 'newText' );
                                    </script>
                                    <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="inputDefault">Image news</label>
                                    <input type="text" placeholder="Image" required class="form-control" name="imageNews" id="inputDefault">
                                </div>

                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label">Category</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="selectCategory">
                                        <?php foreach($category as $item){?>
                                            <option value="<?php echo $item['id']?>"><?php echo $item['category_name']?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="addnews"><!--  action contol here  -->
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="reset" class="btn btn-default">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

            <?php
        }

        /***
         * forma pro zmenu prispevku authorem
         * @param $news
         * @param $category
         */
        function setNews($news, $category){
//            echo '<pre>', print_r($news, true), '</pre>';
            ?>
            <div class="row">
                <div class="col-lg-10">
                    <div class="well bs-component">
                        <form  action="" method="post" class="form-horizontal">
                            <fieldset>
                                <legend>Set news </legend>
                                <div class="form-group">
                                    <label class="control-label" for="inputDefault">Title</label>
                                    <input type="text" placeholder="Title" required class="form-control"
                                           name="newTitle" id="inputDefault" value="<?php echo $news["title"] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="textArea" class="control-label">Text</label>
                                    <textarea  class="form-control"  name="newText" id="textArea"><?php echo $news["note"] ?></textarea>
                                    <script>
                                        CKEDITOR.replace( 'newText' );
                                    </script>
                                    <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="inputDefault">Image news</label>
                                    <input type="text" placeholder="Image" required class="form-control"
                                           name="imageNews" id="inputDefault" value="<?php echo $news["image_news_url"] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label">Category</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="selectCategory">
                                            <?php foreach($category as $item){?>
                                                <option value="<?php echo $item['id']?>"><?php echo $item['category_name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="setnews"><!--  action contol here  -->
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
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