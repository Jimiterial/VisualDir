<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style type="text/css">
            body{
                background: hsl(35, 0%, 10%);
                color:white;
            }
            ul{
                list-style:none;
                margin:0;
                padding:0;
            }
            li{
                /*background:hsl(35, 0%, 5%);*/
                /*margin: 2px 2px 2px 2px;*/
                height:5px;
                border: solid black 1px;
            }
            
            li:hover{
                /*background-color:white;*/
                border: solid white 1px;
            }
            
            /*li > span:hover{
                background-color:white;
            }*/
            
            .image{
                background:hsl(125, 40%, 50%);
            }
            
            .image_back{
                background: hsl(125, 40%, 5%);
            }
            
            .audio{
                background:yellow;
            }
            
            .text{
                background:hsl(35, 100%, 50%);
            }
            
            .text_back{
                background: hsl(35, 100%, 5%);
            }
            
            .video{
                background:purple;
            }
            
            .undefined{
                background: hsl(250, 50%, 50%);
            }
            
            .undefined_back{
                background: hsl(250, 50%, 5%);
            }
            
            
            span{
                background:hsl(35, 0%, 50%);
                display:block;
                height:5px;
            }
            
            #listwrapper{
                width:500px;
                margin:auto;
                background: hsl(40, 100%, 0%);
                border:solid hsl(30, 0%, 15%) 5px;
            }
            
            #detail1{
                position:fixed;
                top:10px;
                margin:auto;
            }
            #detail2{
                position:fixed;
                top:30px;
            }
            
            #time{
                position:fixed;
                top:50px;
            }
            
            #title{
                padding:5px;
                font-family:verdana;
                font-size:20px;
                text-align:center;
            }
            
            .highlight{
                border: solid pink 1px;
            }
            
            #stickyinfo{
                position:absolute;
                display:none;
                height:100px;
                width:250px;
                top:50px;
                left:900px;
                border: solid white 1px;
                padding: 4px;
                border-radius: 0 8px 8px 8px;
            }
        </style>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script>
        $(document).ready(function(){
            $("li").mouseover(function(){
                //$(this).css("border", "solid red 1px");
                var name = $(this).children().attr("data-name");
                var size = $(this).children().attr("data-size");
                var output1 = "Name = " + name;
                var output2 = "Size = " + (size/1024).toFixed(2) + "KB";
                $("div#detail1").text(output1);
                $("div#detail2").text(output2);
            });
            
            //var highlight_elem = "";
            $("li").toggle(function(){
                //if(highlight_elem) {
                    $(".highlight").removeClass("highlight");
                //}
                $(this).addClass("highlight");
                var id = $(this).attr("id");
                $("#stickyinfo").show().css("top",50+(7*id)).html(
                    "Name = "+$(this).children().attr("data-name")+
                    "<br />Size = "+($(this).children().attr("data-size")/1024).toFixed(2) + "KB"
                );
                //alert("ID = "+ $(this).attr("id"));
                
            },function(){
                $(this).removeClass("highlight");
            });
           /*$("li").mouseout(function(){
                $(this).css("border","solid black 1px");
            });
            $("li").mouseover(function(){
                $(this).css("border","solid #ccc 1px");
            });*/
            /*$("li").hover(function(){
                 
                 $(this).css("border","solid #ccc 1px");
            },
            function(){
                $(this).css("border","solid black 1px");
            });*/
        });
    
        </script>
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
        echo "<div id='listwrapper'>", PHP_EOL;
        echo "<div id='title'>Visual Listing of $filepath</div>", PHP_EOL;
        //echo print_r($_SERVER);
        echo "<ul>", PHP_EOL;

        $count = 0;
        
        foreach ($images as $item) {
            $size_percent = number_format($item['size'] / $images[0]['size'] * 100, 2);
            $file = pathinfo($item['name']);
            //echo $file['extension'];
            
            $li_class = '';
            $span_class='';
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
        echo "<div id='stickyinfo'>Some info</div>";
        
        ?>
    </body>
</html>
