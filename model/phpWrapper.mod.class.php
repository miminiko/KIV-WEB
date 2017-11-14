<?php


class wrapper{

    function phpWrapperFromFile($filename){
	    ob_start();
	    if (file_exists($filename) && !is_dir($filename)) {
    		include($filename);
	    }
	    return ob_get_clean();
    }
}


?>