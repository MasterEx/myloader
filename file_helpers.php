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
  echo "<!DOCTYPE html>
         <html><body> 
          <h2>Please dont send uncompressed images :P</h2>
          I refuse to waste good bandwidth to upload this file..
         </body></html>"; 
}


function refuse_overquotta()
{ global $ENABLE_MIRROR_LINK;
  echo "<!DOCTYPE html>
         <html><body> 
          <h2>This server has exceeded its upload quotta</h2>";
  if ($ENABLE_MIRROR_LINK==1) { echo "Please try <a href=\"mirrors.php\">one of the mirrors</a>.."; }
  echo "        </body></html>"; 
}


function link_not_found()
{
  echo "<!DOCTYPE html>
          <html><body> 
          <h2>Could not find file / File Expired ?</h2>
          Your link is invalid , or maybe the file expired..
         </body></html>"; 
}
 

function tampered_data()
{
  echo "<!DOCTYPE html>
         <html><body> 
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
       ( $ext == "svg" )||( $ext == "svgz" )|| 
       ( $ext == "bmp" )||( $ext == "ico" )||
      //PPM , and pbm files are not opened by firefox :P ( $ext == "ppm" )||( $ext == "pbm" )||
       ( $ext == "jpg" )||
       ( $ext == "jpeg" )
     ) return 1;
  return 0;
}

function ExtentionIsVideo($ext)
{
  if ( ( $ext == "avi" )||
       ( $ext == "ogv" )||
       ( $ext == "webm" )||
       ( $ext == "mpeg4" )||( $ext == "mp4" )|| 
       ( $ext == "mpeg" )||( $ext == "mpg" ) 
     ) return 1;
  return 0;
}

function ExtentionIsAudio($ext)
{
  if ( ( $ext == "ogg" )|| ( $ext == "mp3" )||( $ext == "wav" ) 
     ) return 1;
  return 0;
}


function PrintFileInBox($weblink,$filename,$ext)
{
  if ( ExtentionIsImage($ext)==1 )
            {
                 echo "<a href=\"".$weblink."\">";
                 echo "<img src=\"".$weblink."\" width=\"70%\" alt=\"Uploaded Image\" >";
                 echo "</a><br><br>";
                 
                 echo "<a href=\"".$weblink."\">";
                 echo $filename;
                 echo "</a><br><br>";
            
            } else
  if ( ExtentionIsVideo($ext)==1 )
            { 
                 echo"<video width=\"320\" src=\"".$weblink."\"  controls autobuffer autoplay>
                       <p> Try this page on HTML5 capable brosers</p>
                      </video>
                        <br><a  href=\"".$weblink."\">Download the video file</a><br><br>";
            } else 
  if ( ExtentionIsAudio($ext)==1 )
            { 
                  echo"<audio controls=\"controls\">";
                  
                  if  ( $ext == "ogg" )  {  echo "<source src=\"".$weblink."\" type=\"audio/ogg\" />"; } else
                  if  ( $ext == "wav" )  {  echo "<source src=\"".$weblink."\" type=\"audio/wav\" />"; } else
                  if  ( $ext == "mp3" )  {  echo "<source src=\"".$weblink."\" type=\"audio/mp3\" />"; } 
                  
                  echo " <p> Try this page on HTML5 capable brosers</p>
                        </audio> 
                        <br><a  href=\"".$weblink."\">Download the audio file</a><br><br>";
            } else
            {
                 echo "If you want you can download the file by clicking its link..";
                 echo "<br>This file has a .".$ext." extention <br><br>";
                 echo "<br>Only png/gif/jpg/jpeg , audio and video files are embedded in the pages for fast viewing :)<br><br>";

                 echo "<a href=\"".$weblink."\">";
                 echo "<img src=\"images/logo.png\">";
                 echo "</a><br><br>";

                 echo "<a href=\"".$weblink."\">";
                 echo $filename;
                 echo "</a><br><br>"; 
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
    
    $ext="bin";
    if (!isset($path_parts["extension"])) { /* EXTENTION REMAINS BIN :P */  } else
                                          { $ext = strtolower($path_parts["extension"]); }
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


        case "svg":
        header("Content-type: image/svg+xml"); // add here more headers for diff. extensions
        break;         
        case "svgz":
        header("Content-type: image/svg-xml"); // add here more headers for diff. extensions         
        break;


        case "pbm":
        header("Content-type: image/x-portable-bitmap"); // add here more headers for diff. extensions
        break;         
        case "ppm":
        header("Content-type: image/x-portable-pixmap"); // add here more headers for diff. extensions         
        break;

        case "ico":
        header("Content-type: image/x-ico"); // add here more headers for diff. extensions         
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


//This function returns the size of a remote file
//it was found here: http://codesnippets.joyent.com/posts/show/1214
function get_remote_file_size($url, $readable = true){
   $parsed = parse_url($url);
   $host = $parsed["host"];
   $fp = @fsockopen($host, 80, $errno, $errstr, 20);
   if(!$fp) return false;
   else {
       @fputs($fp, "HEAD $url HTTP/1.1\r\n");
       @fputs($fp, "HOST: $host\r\n");
       @fputs($fp, "Connection: close\r\n\r\n");
       $headers = "";
       while(!@feof($fp))$headers .= @fgets ($fp, 128);
   }
   @fclose ($fp);
   $return = false;
   $arr_headers = explode("\n", $headers);
   foreach($arr_headers as $header) {
			// follow redirect
			$s = 'Location: ';
			if(substr(strtolower ($header), 0, strlen($s)) == strtolower($s)) {
				$url = trim(substr($header, strlen($s)));
				return get_remote_file_size($url, $readable);
			}
			
			// parse for content length
       $s = "Content-Length: ";
       if(substr(strtolower ($header), 0, strlen($s)) == strtolower($s)) {
           $return = trim(substr($header, strlen($s)));
           break;
       }
   }
   //this part is modified to return size in bytes
   if($return && $readable) {
			$size = $return;
			$return = $size;
   }
   return $return;
}

function DownloadFile($url)
{
	global $ENABLE_URL_UPLOAD,$SCRIPT_LOCAL_BASE,$SCRIPT_CACHE_FOLDERNAME,$SCRIPT_WEB_BASE,$LOCAL_PHP_FILE_LIMIT;
	
	if ( ($ENABLE_URL_UPLOAD == 1 ) )
	{
		/*
			   TODO ADD REGULAR EXPRESSION TO CLEAN URL!
		*/
		if(!strstr($url, "http://"))
		{
			$url = "http://".$url;
		}
		if(get_remote_file_size($url)>$LOCAL_PHP_FILE_LIMIT)
		{
			echo "</br>Files > ".($LOCAL_PHP_FILE_LIMIT/(1024*1024))."MB are not permitted</br>";
		}
		else
		{
			$destination_folder = $SCRIPT_CACHE_FOLDERNAME."/";
			$newfname = basename($url);
			$new_filename=md5($newfname.date('l jS \of F Y h:i:s A'))."-".$newfname;

			$file = fopen ($url, "rb");
			if ($file) {
				$newf = fopen ($destination_folder.$new_filename, "wb");
				if ($newf)
				while(!feof($file)) {
					fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
				}
			}

			if ($file) {
				fclose($file);
			}

			if ($newf) {
				fclose($newf);
			}
			if(file_exists($SCRIPT_LOCAL_BASE.$destination_folder.$new_filename))
			{
				$direct_target_path = "file.php?i=".$new_filename; 
				$new_target_path = "vfile.php?i=".$new_filename; 
				echo "<br/>";
						 echo "You can access the file <a href='$new_target_path' target=\"_new\">here</a><br/><br/>";
						 echo "<table>";
						 echo "<tr>
							   <td>Link : </td>
							   <td><input type=\"text\" value=\"".$SCRIPT_WEB_BASE.$new_target_path."\"></td>
							   </tr>";
						echo "<tr>
							   <td>Direct Link : </td>
							   <td><input type=\"text\" value=\"".$SCRIPT_WEB_BASE.$direct_target_path."\"></td>
							   </tr>
							  </table></br></br>";
				add_to_cache_size(get_remote_file_size($url)); 
			}
			else
			{
			  echo "</br><h2>Sorry, there was an error during the upload!</br>Please check if the url is valid and try again!</h2></br>";
			}
		}					  
	}
}


?>
