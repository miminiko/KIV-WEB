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

        function getNewsTemplate($news){
            $date=date_create($news['date']);

            if($news['image_url'] != null){
                echo "image exist";
            }?>
            <h2><?php echo $news['title']?></h2>
            <div>
                <p><span class="text-muted"><?php echo date_format($date, 'd.m.Y');?> </span>
                <span  class="text-success"><?php echo $news['login']?></span ></p>
            </div>

            <p><?php echo $news['note']?></p>

            <?php
        }

        function viewSmallNews($arrayNews){
            foreach ($arrayNews as $news){
                $date=date_create($news['date']);

                ?>
                <div class="container">
                <h2><a href='index.php?page=page&&newsid=<?php echo $news['id'] ?>' action="open_news"><?php echo $news['title']?></a></h2>

                <div> <p><span class="text-muted"><?php echo date_format($date, 'd.m.Y');?> </span>
                        <span  class="text-success"><?php echo $news['login']?></span >
                        <?php if($news['category_name'] != null){
                            ?>
                        <span class="text-info"><?php echo $news['category_name']?></span></p>

                            <?php
                        }?>

                </div>
                </div>
                <?php
            }
        }

        function viewSmallNewsByCategory($category, $arrayNews){
            ?>
            <div class="col-lg-12">
                <img src="<?php echo $category['image_url'] ?>" height="75%" width="75%">
            </div>
            <h1><?php echo $category['category_name'] ?></h1>
            <br>
            <?php
            $this->viewSmallNews($arrayNews);
        }
    }

?>