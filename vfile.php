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

        $file_served=0; 

        $file=$_GET["i"];
        if ( ( $file == "." )||
             ( $file == ".." )||
             ( $file == "index.html" )||
             ( $file == ".htaccess" )||
             ( $file == "check_x.png" ) ) 
        {
           /* These files are not uploaded from users :P */
        } else
        {  
          $file_parts = pathinfo($file); 
          //$ext = strtolower($file_parts["extension"]);
          $ext="bin";
          if (!isset($file_parts["extension"])) { /* EXTENTION REMAINS BIN :P */  } else
                                                { $ext = strtolower($file_parts["extension"]); }

          if ( (ExtentionIsImage($ext)==1)||
               (ExtentionIsVideo($ext)==1)||
               (ExtentionIsAudio($ext)==1)||
               ($DISABLE_PREVIEW_FOR_NON_VIEWABLE_FILES==0) )
          {   
        
            $file_served=1;
            
            //TITLE to make search easier!
            //$clear_name=$file_parts['filename'];
             $filename_parts= explode("-",$file_parts["filename"],2);
             $hash_part=$filename_parts[0];
             $filename_part=$filename_parts[1];                     

            echo "<!DOCTYPE html>
                  <html>
                   <head>
                     <title>".$filename_part."</title>
                     <link rel=\"stylesheet\" type=\"text/css\" href=\"myloader.css\" />";
                     
            if ( $HTML5_COMPATIBILITY_AUDIO_VIDEO == 1 )
                { echo "<script src=\"http://html5media.googlecode.com/svn/trunk/src/html5media.min.js\"></script>"; }
            
            echo " </head>
                   <body>
                     <center>"; 
            echo "<br> <a href=\"index.php\">Return to MyLoader!</a><br><br>";
            $web_file_server=$SCRIPT_WEB_BASE."file.php?i=".urlencode($file);
             
            PrintFileInBox( $web_file_server,$file,$ext);
                        
            echo "<br><br><br><br><a href=\"index.php\">Return to MyLoader!</a><br>";
            echo "<img src=\"images/host_logo.png\" id=\"invisible\">";
            echo "   </center>";
            echo " </body>
                  </html>";
            
           } else
           { // if file not image no use in "displaying" it , better to send it at once
             $file_served=1;
             ServeFile($file);
           }
        }  
 
  if ( $file_served == 0 )
   {
      echo "<h2>No File found!</h2>";
      echo "<a href=\"random.php\">See another random file!</a><br><br>";
      echo "<a href=\"index.php\">Return to MyLoader!</a><br><br>";
   }
?>
