<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link href="css/style.css" rel="stylesheet" type="text/css"></script>
        <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="js/visualdir.js"></script>
    </head>
    <body>
        <?php
        
        /*define ('IMAGE','png,jpg,jpeg,gif,bmp,tif');
        define ('AUDIO', 'mp3,ogg,wav');
        define ('VIDEO', 'mpeg,mp4,wmv,flv');
        define ('TEXT','html,php,css,txt');*/
        $images = array();
        
        $start = microtime(true);
        $filepath = "../";
        $dir_iterator = new RecursiveDirectoryIterator($filepath, 0);
        $recursive_iterator = new RecursiveIteratorIterator($dir_iterator);

        //$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('../brav/images'));

        foreach ($recursive_iterator as $filename => $current) {
            $images[] = array(
                "name" => $current->getFilename(),
                "size" => $current->getSize()
            );
            //$images['title'] = $cur->getSize();
            //echo $cur->getFilename()," = ",$cur->getSize();
            //echo "<br />\n";
        }

        usort($images, "custom_sort");

        // Define the custom sort function
        // If this returns true, $b is moved up in the array
        function custom_sort($a, $b) {
            return $a['size'] < $b['size'];
        }
        echo "<div id='detail1'>Nothing selected</div>", PHP_EOL;
        echo "<div id='detail2'></div>", PHP_EOL;
        echo "<div id='listwrapper'><div id='stickyinfo'>Some info</div>", PHP_EOL;
        echo "<div id='title'>Visual Listing of $filepath</div>", PHP_EOL;
        //echo print_r($_SERVER);
        echo "<ul>", PHP_EOL;

        $count = 0;
        
        foreach ($images as $item) {
            $size_percent = number_format($item['size'] / $images[0]['size'] * 100, 2);
            $file         = pathinfo($item['name']);
            $li_class     = '';
            $span_class   = '';
            $ext = @$file['extension'];
            switch ($ext){
                case "jpg" :$span_class = "image";$li_class = "image_back";break;
                case "png" :$span_class = "image";$li_class = "image_back";break;
                case "gif" :$span_class = "image";$li_class = "image_back";break;
                case "jpeg":$span_class = "image";$li_class = "image_back";break;

                case "html":$span_class = "text";$li_class="text_back";break;
                case "htm" :$span_class = "text";$li_class="text_back";break;
                case "php" :$span_class = "text";$li_class="text_back";break;
                case "js"  :$span_class = "text";$li_class="text_back";break;
                case "css" :$span_class = "text";$li_class="text_back";break;
                case "txt" :$span_class = "text";$li_class="text_back";break;
                case "xml" :$span_class = "text";$li_class="text_back";break;
                default:$span_class = "undefined";$li_class="undefined_back";break;
           
            }
           echo "<li class='$li_class' id='$count'><span class='$span_class' style='width:{$size_percent}%;' data-name='{$item['name']}' data-size='{$item['size']}'></span>", "</li>", PHP_EOL;
           $count++;
        }
        /* echo "<pre>";
          var_dump($images); */
        echo "</ul>", PHP_EOL;
        echo "</div>", PHP_EOL;
        echo "<div id='time'>Listed ", $count ," item",($count > 0) ? "s": false, " in ", number_format(microtime(true) - $start,4), " seconds.</div>";
        //echo "<div id='stickyinfo'>Some info</div>";
        
        ?>
    </body>
</html>