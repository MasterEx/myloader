<?php
require("configuration.php"); 
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
{ global $ENABLE_MIRROR_LINK;
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
 

function tampered_data()
{
  echo "<html><body> 
          <h2>Tampered Request ?</h2>
            Get Lost..!
         </body></html>"; 
}


function ExtentionIsExecutable($ext)
{
  if ( ( $ext == "exe" )||
       ( $ext == "scr" )||
       ( $ext == "bat" )
     ) return 1;
  return 0;
}

function ExtentionIsImage($ext)
{
  if ( ( $ext == "png" )||
       ( $ext == "gif" )||
       ( $ext == "jpg" )||
       ( $ext == "jpeg" )
     ) return 1;
  return 0;
}

function PrintFileInBox($weblink,$filename,$ext)
{
  if ( ExtentionIsImage($ext)==1 )
            {
                 echo "<a href=\"".$weblink."\">";
                 echo "<img src=\"".$weblink."\" width=\"70%\">";
                 echo "</a><br><br>";
                 
                 echo "<a href=\"".$weblink."\">";
                 echo $filename;
                 echo "</a><br><br>";
            
            } else
            {
                 echo "If you want you can download the file by clicking its link..";
                 echo "<br>This file has a .".$ext." extention <br><br>";
                 echo "<br>Only png/gif/jpg/jpeg files are embedded in the pages for fast viewing :)<br><br>";

                 echo "<a href=\"".$weblink."\">";
                 echo "<img src=\"images/logo.png\">";
                 echo "</a><br><br>";

                 echo "<a href=\"".$weblink."\">";
                 echo $filename;
                 echo "</a><br><br>"; 
            }
 
}

function DownloadFile($dirty_url)
{ 
  if ( ( $ENABLE_URL_UPLOAD == 1 ) && (0 /*DEBUG SAFETY SWITCH :P*/) )
  {
   /*
           TODO ADD REGULAR EXPRESSION TO CLEAN URL!
   */
   $url = $dirty_url;
   $file=fopen($SCRIPT_CACHE_FOLDERNAME."/todownload.wwwlist","w+");
   if ($file)
   {
     fwrite($file,$url."\n"); 
     fclose($file);   
   
     exec("wget -i ".$SCRIPT_CACHE_FOLDERNAME."/todownload.wwwlist");
   }
   echo "WEB DOWNLOAD NOT IMPLEMENTED ( YET )";
 }
}





function ServeFile($dirty_filename)
{ 
  $dirty_filename=trim($dirty_filename,"/"); // Accept requests for http://xxx/file.php?i=hash-file.ext/ ( the last slash )
  
  //A triple = sign (===) is a comparison to see whether two variables / expresions / constants are equal AND have the same type 
  //- i.e. both are strings or both are integers.
  $exploit_pos = strpos($dirty_filename,"/");
  if ($exploit_pos === false) { } else { tampered_data(); return; }
  $exploit_pos = strpos($dirty_filename,"\\");
  if ($exploit_pos === false) { } else { tampered_data(); return; }

  //FIX EXPLOITABLE HOLE THAT CAN SERVE THE WRONG FILE :P
  $filename = filter_var(stripslashes($dirty_filename),FILTER_SANITIZE_STRIPPED);
  str_ireplace("/",".",$filename);
  //FIX EXPLOITABLE HOLE THAT CAN SERVE THE WRONG FILE :P
  //DEBUG OUTPUT TO FIGURE OUT IF INPUT FILTERING WORKS OK echo $filename;

 global $MAXIMUM_UPLOAD_BANDWIDTH_QUOTA,$MAXIMUM_UPLOAD_BANDWIDTH_QUOTA,$SCRIPT_LOCAL_BASE,$SCRIPT_CACHE_FOLDERNAME;
if ( ($MAXIMUM_UPLOAD_BANDWIDTH_QUOTA!=0) && ( $MAXIMUM_UPLOAD_BANDWIDTH_QUOTA<get_uploaded_bandwidth() ) )
{
  // Upload guard quota
  refuse_overquotta();
} else
{
 $fullPath =  $SCRIPT_LOCAL_BASE.$SCRIPT_CACHE_FOLDERNAME."/".$filename;

 if ($fd = fopen ($fullPath, "r")) 
 {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    $filename_parts= explode("-",$path_parts["basename"],2);
    $hash_part=$filename_parts[0];
    if (!isset( $filename_parts[1]) ) { tampered_data(); return; }
    $filename_part=$filename_parts[1];

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
   link_not_found();/* DEBUG ONLY :P */
 }
}
exit; 
}


?>
