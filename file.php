<?php
require("configuration.php"); // File.php is not based on index.php so we require configuration.php
require("stat_keeper.php"); // File.php is not based on index.php so we require stat_keeper.php


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


/* THE MESSAGES CAN BE IMPROVED BUT SHOULD NOT TAKE MORE THAN 10 lines each in the php file*/
function refuse_withoutcompression()
{
  echo "<html><body> 
          <h2>Please dont send uncompressed images :P</h2>
          I refuse to waste good bandwidth to upload this file..
         </body></html>"; 
}


function refuse_overquotta()
{
  echo "<html><body> 
          <h2>This server has exceeded its upload quotta</h2>";
  if ($ENABLE_MIRROR_LINK==1) { echo "Please try <a href=\"mirrors.php\">one of the mirrors</a>.."; }
  echo "        </body></html>"; 
}


function link_not_found()
{
  echo "<html><body> 
          <h2>Could not find file / File Expired ?</h2>
          Your link is invalid , or maybe the file expired..
         </body></html>"; 
}
 



if ( ($MAXIMUM_UPLOAD_BANDWIDTH_QUOTA!=0) && ( $MAXIMUM_UPLOAD_BANDWIDTH_QUOTA<get_uploaded_bandwidth() ) )
{
  // Upload guard quota
  refuse_overquotta();
} else
{
$fullPath =  $SCRIPT_LOCAL_BASE.$SCRIPT_CACHE_FOLDERNAME."/".$_GET['i'];

if ($fd = fopen ($fullPath, "r")) 
{
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) 
    {
        case "pdf":
        header("Content-type: application/pdf"); // add here more headers for diff. extensions
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
        break;
        case "png":
        header("Content-type: image/png"); // add here more headers for diff. extensions    
        break;     
        case "gif":
        header("Content-type: image/gif"); // add here more headers for diff. extensions         
        break;
        case "jpg":
        header("Content-type: image/jpg"); // add here more headers for diff. extensions         
        break;
        case "jpeg":
        header("Content-type: image/jpg"); // add here more headers for diff. extensions         
        break;
        case "bmp":
         refuse_withoutcompression();
        exit;      
        break;
        default;
        header("Content-type: application/octet-stream"); 
    }
    $filename_parts= explode("-",$path_parts["basename"],2);
    $hash_part=$filename_parts[0];
    $filename_part=$filename_parts[1];
    
    header("Content-Disposition: filename=\"".$filename_part."\"");
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while(!feof($fd)) 
    {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }   
   fclose ($fd);
   add_to_uploaded_bandwidth($fsize);
} else
{ 
   link_not_found();/* DEBUG ONLY :P
   echo "<br><br>".$oldfullPath;
   echo "<br><br>".$fullPath;*/
}
}
exit; 
?>
