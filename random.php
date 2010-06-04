<?php
 require("configuration.php");
 require("file_helpers.php");

/***************************************************************************
* Copyright (C) 2010 by Periklis Ntanasis , Ammar Qammaz *
* 
* *
* This program is free software; you can redistribute it and/or modify *
* it under the terms of the GNU General Public License as published by *
* the Free Software Foundation; either version 2 of the License, or *
* (at your option) any later version. *
* *
* This program is distributed in the hope that it will be useful, *
* but WITHOUT ANY WARRANTY; without even the implied warranty of *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the *
* GNU General Public License for more details. *
* *
* You should have received a copy of the GNU General Public License *
* along with this program; if not, write to the *
* Free Software Foundation, Inc., *
* 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA. *
***************************************************************************/



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
     $dir_handle  =  @opendir("./".$SCRIPT_CACHE_FOLDERNAME."/")  or  die("Unable  to  open  $path");
     $file_to_choose = rand(1,num_files("./".$SCRIPT_CACHE_FOLDERNAME."/",false)-3); // We want a number between 1 and filenum , we have 3 default files in
     $counter=0;
     $file_served=0;
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
            $file_served=1;
            $file_parts = pathinfo($file); 
            //$ext = strtolower($file_parts["extension"]);
            $ext="bin";
            if (!isset($file_parts["extension"])) { /* EXTENTION REMAINS BIN :P */  } else
                                                  { $ext = strtolower($file_parts["extension"]); }  
          
            //TITLE to make search easier!
            //$clear_name=$file_parts['filename'];
             $filename_parts= explode("-",$file_parts["filename"],2);
             $hash_part=$filename_parts[0];
             $filename_part=$filename_parts[1];                     

            echo "<html>
					<head>
                     <title>".$filename_part."</title>
                     <link rel=\"stylesheet\" type=\"text/css\" href=\"myloader.css\" />";
			echo 	 $HEAD_HTML_INJECTION;
            echo " </head>
                   <body>
                     <center>";
            echo "<br><a href=\"random.php\">See More Random Files!</a> &nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<a href=\"index.php\">Return to MyLoader!</a><br><br>";
            $web_file_server=$SCRIPT_WEB_BASE."file.php?i=".$file;
             
            PrintFileInBox( $web_file_server,$file,$ext);
                        
            echo "<br><br><br><br><a href=\"index.php\">Return to MyLoader!</a>";
            
            echo "   </center>";
            echo " </body>
                  </html>";
            
            break;
          }
        }
      }
  }
 
  if ( $file_served == 0 )
   {
      echo "<h2>No File found!</h2>";
      echo "<a href=\"random.php\">See More Random Files!</a><br><br>";
      echo "<a href=\"index.php\">Return to MyLoader!</a><br><br>";
   }
?>
