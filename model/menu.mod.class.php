<?php 


class myMenu {

        private $pages = array(
            "home"=>"Home",
            "category"=>"Category",
            "login"=>"Log in",
            "registration"=>"Registration",
            "addnews"=>"Add news",
            "contact"=>"Contact",
            "userconsole" => "Account",
            "admin" => "Admin"
        );
        
        /* return name page as title */
        function namepage($page){
            $name = "";
            if ($this->pages != null){
                foreach ($this->pages as $key => $title){
    			 if($page == $key){
    				$name = $title;
    			 }
    		  }
            }
            return $name;
        }
        ///!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        function getmenu($page){
            $menu = "";
            if ($this->pages != null){
    			foreach ($this->pages as $key => $title) {
    				if ($page == $key) $active_pom = "class='active'";
    				else $active_pom = "";
    				$menu .= " <li ".$active_pom." ><a href='index.php?page=$key'>$title</a></li>";
    			}
            }
            return $menu;
        }


        /***
         * vrati standartni startove
         * @param $page
         * @param $type
         */
        function getMenuByUser( $category){
            ?>

<div class="container">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href='index.php?page=home'>Hi-Tech 2017</a>
                </div>
                    
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href='index.php?page=home'>Home</a></li>
                        <li class="dropdown">
                            <a href='index.php?page=category'  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Category <span class="caret"></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php foreach($category as $item){?>
                                    <li><a href='index.php?page=category&&cat=<?php echo $item['id']?>'><?php echo $item['category_name']  ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>

                        <?php 
                            if(@$_SESSION["user"]["type_id"] == null || @$_SESSION["user"]["type_id"] == 0) {
                            ?>
                                <li class="active"><a href='index.php?page=login'>Log in</a></li>
                                <li><a href='index.php?page=registration'>Registration</a></li>

                                <?php
                            }
                            if(@$_SESSION["user"]["type_id"] == 1){
                                ?>
                                <li class="dropdown">
                                    <a href='index.php?page=admin'  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Account<span class="caret"></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href='index.php?page=admin'>Admin</a></li>
                                        <li class="divider"></li>
                                        <li><a href='index.php?page=login&action=logOut' action="logOut">Log out</a></li>
                                    </ul>
                                </li>
                                <?php
                            }
                            if(@$_SESSION["user"]["type_id"] >= 2){
                                ?>
                                <li class="active"><a href='index.php?page=addnews'  class="active">Add news</a></li>
                                <li class="dropdown">
                                    <a href='index.php?page=userconsole'  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Account<span class="caret"></a>
                                    <ul class="dropdown-menu">
                                        <li><a href='index.php?page=userconsole'>Your account</a></li>
                                        <li class="divider"></li>
                                        <li><a href='index.php?page=login&action=logOut' action="logOut">Log out</a></li>
                                    </ul>
                                </li>
                                <?php
                            }
                        ?>
                        <li><a href='index.php?page=contact'>Contact</a></li>
                    </ul>
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
            </div>
        </nav>
</div>
<?php            
        }
        
    }

?>