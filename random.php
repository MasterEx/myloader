<?php
 require("configuration.php");

 function num_files($dir, $recursive=false, $counter=0) {
    static $counter;
    if(is_dir($dir)) {
      if($dh = opendir($dir)) {
        while(($file = readdir($dh)) !== false) {
          if($file != "." && $file != "..") {
              $counter = (is_dir($dir."/".$file)) ? num_files($dir."/".$file, $recursive, $counter) : $counter+1;
          }
        }
        closedir($dh);
      }
    }
    return $counter;
  }



 if ( $ENABLE_RANDOM_FILE  == 0 )
  {
    echo "<html><body>Random File Support is disabled</body></html>";
  } else
  { 
     $dir_handle  =  @opendir("./uploads/")  or  die("Unable  to  open  $path");
     $file_to_choose = rand(1,num_files("./uploads/",false)-3); // We want a number between 1 and filenum , we have 3 default files in
     $counter=0;
     while  ($file  =  readdir($dir_handle))  
      {
        if ( ( $file == "." )||
             ( $file == ".." )||
             ( $file == "index.html" )||
             ( $file == ".htaccess" )||
             ( $file == "check_x.png" ) ) 
        {
           /* These files are not uploaded from users :P */
        } else
        {
         $counter+=1;  
         if ( $file_to_choose == $counter )
          {
            echo "<html>
                   <head>
                     <style type=\"text/css\">
                       a:link {color:#FF0000;}
                       a:visited {color:#CC0000;}
                       a:hover {color:#FF00FF;}
                       a:active {color:#0000FF;} 
                     </style>
                   </head>
                   <body>
                     <center>";
            echo "<a href=\"".$SCRIPT_WEB_BASE."file.php?i=".$file."\">".$file."</a> is the Lucky file<br><br>";
            echo "<a href=\"random.php\">See another random file!</a><br><br>";
            echo "<a href=\"index.php\">Return to MyUploader!</a><br><br>";
            $file_parts = pathinfo($file); 
            $ext = strtolower($file_parts["extension"]);
           
            if ( ( $ext == "png" )||
                 ( $ext == "gif" )||
                 ( $ext == "jpg" )||
                 ( $ext == "jpeg" )
               )
            {
                 echo "<img src=\"".$SCRIPT_WEB_BASE."file.php?i=".$file."\"><br>";
            } else
            {
                 echo "If you want you can download the file by clicking its link.. <br>Only png/gif/jpg/jpeg files will be embedded to this page for fast viewing :)";
            }
            echo "   </center>";
            echo " </body>
                  </html>";
            
            break;
          }
        }
      }
  }

?>
