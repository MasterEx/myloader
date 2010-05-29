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
            $file_served=1;
            $file_parts = pathinfo($file); 
            $ext = strtolower($file_parts["extension"]);
            
            //TITLE to make search easier!
            //$clear_name=$file_parts['filename'];
             $filename_parts= explode("-",$file_parts["filename"],2);
             $hash_part=$filename_parts[0];
             $filename_part=$filename_parts[1];                     

            echo "<html>
                   <head>
                     <title>".$filename_part."</title>
                     <link rel=\"stylesheet\" type=\"text/css\" href=\"myloader.css\" />
                   </head>
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
            
            
        }
      }
  }
 
  if ( $file_served == 0 )
   {
      echo "<h2>No File found!</h2>";
      echo "<a href=\"random.php\">See another random file!</a><br><br>";
      echo "<a href=\"index.php\">Return to MyLoader!</a><br><br>";
   }
?>