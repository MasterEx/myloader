<?php
   $VERSION="0.951";
   $time_enter=microtime(true);
   require("file_helpers.php"); 
   require("cleaning_support.php");   
   require("footer.php");   

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
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="el" xml:lang="el">
<head>
<META name="author" content="Periklis Ntanasis a.k.a. Master_ex , Ammar Qammaz a.k.a. AmmarkoV">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<meta name="keywords" content="personal uploader" />
<meta name="description" content="" />
<meta name="distribution" content="global" />
<title>MyLoader @ <?php echo $HOST_NAME; ?></title>

<link rel="stylesheet" type="text/css" href="myloader.css" />
<script src="myloader.js" language="javascript" type="text/javascript"></script>
<style type="text/css">
#BannerInside
   {
     background-image:url('<?php  $num=rand(1,$BANNER_NUMBER); echo $SCRIPT_WEB_BASE."images/".$BANNER_PREFIX.$num.".jpg";?>');
     background-repeat:no-repeat;
     width:600px;
     height:148px;
     color:#EEEEEE;
     font-size:33px;
     font-weight:900;  
     #clip:rect(0px,00px,600px,148px);
   }

#BannerMask
   {
     background-image:url('<?php echo "images/".$BANNER_PREFIX."mask.png"; ?>');
     background-repeat:no-repeat;
     width:600px;
     height:148px;
     color:#EEEEEE;
     font-size:33px;
     font-weight:900;  
     position:absolute;
     z-index:100;
   }

#invisible
  { visibility:hidden; }
</style>
<?php echo $HEAD_HTML_INJECTION; ?>
</head>
<body><img id="invisible" src="images/host_logo.png"> 
<div><center><br><br>
<div width=600 height=148 id="BannerInside"><table width=600 height=148 id="BannerMask"><tr><td align="center">MyLoader <blink>@</blink> <?php echo $HOST_NAME; ?></td></tr></table></div>
<?php echo $AFTERLOGO_HTML_INJECTION; ?>

<?php
  echo "<!-- Version ".$VERSION." -->";
  $cache_size = intval(get_cache_size()); //we get the cache size here because it is needed for the bottom line and for quota checks
      
  
  if(isset($_POST['submit']))
   {
     if ($ENABLE_URL_UPLOAD == 1 && (strlen($_POST['website'])>0))
     {
			echo "Website From URL Requested ".$_POST['website'];
			DownloadFile($_POST['website']);
     }
     else
     {
		  $tmpdir = md5($_FILES['uploadedfile']['name'].date('l jS \of F Y h:i:s A'));

		  if ( ($MAXIMUM_CACHE_QUOTA!=0) && ($cache_size>$MAXIMUM_CACHE_QUOTA) )
		   {
			 echo "<h2> ".$HOST_NAME." has exceeded its storage quota </h2>";
			 echo "<h4> We are sorry but you will have to wait until some of the older content is removed , thank you!</h4>";
			 if ( $ENABLE_MIRROR_LINK == 1 )
			  { echo "<h5> You can also <a href=\"mirrors.php\">try another host</a></h5>"; } 
		   } 
			  else
		  if($_FILES['uploadedfile']['size']>$LOCAL_PHP_FILE_LIMIT)
		   {
			 echo "Files > ".($LOCAL_PHP_FILE_LIMIT/(1024*1024))."MB are not permitted";
		   }
		  if($_FILES['uploadedfile']['size']==0)
		   {
			 echo "<h2>You provided no file to upload!</h2>";  
		   }
			  else    
		   { 
				 $base_path = "./".$SCRIPT_CACHE_FOLDERNAME."/";
				 $new_filename = $tmpdir."-".basename($_FILES['uploadedfile']['name']);
				  
				 //New file.php file sender 
				 $direct_target_path = "file.php?i=".urlencode($new_filename); 
				 $new_target_path = "vfile.php?i=".urlencode($new_filename); 

				 $target_path = $base_path.$new_filename; 
				  
				 if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'],$target_path))
				  {
					 echo "<br/>The file <b>".basename( $_FILES['uploadedfile']['name']);
					 $thefilesize=filesize($target_path);
					 if ( $thefilesize>1024*1024 ) { echo " ".number_format($thefilesize/(1024*1024),2)." MB ";  } else 
					 if ( $thefilesize>1024 )      { echo " ".number_format($thefilesize/1024,2)." KB ";  } else 
												   { echo " ".$thefilesize." bytes ";  }    
					 echo "</b> has been uploaded<br/>";
					 add_to_cache_size($_FILES['uploadedfile']['size']); 					
					 
					 echo "<br/>";
					 echo "You can access the file <a href='$new_target_path' target=\"_new\">here</a>";
					 if($ENABLE_GOOGLEDOCS_LINK == 1)
					 {
						 $gdocsExtensions = array("pdf","ppt","pptx","tiff");
						 if (in_array(end(explode(".",strtolower($_FILES['uploadedfile']['name']))),$gdocsExtensions)) 
						 {
							echo " - @<a href=\"http://docs.google.com/viewer?url=".urlencode($SCRIPT_WEB_BASE.$direct_target_path)."\">GoogleDocs</a>";
						 }
					 }
					 echo "<br/><br/><table>";
					 echo "<tr>
						   <td>Link : </td>
						   <td><input type=\"text\" value=\"".$SCRIPT_WEB_BASE.$new_target_path."\"></td>
						   </tr>";
					echo "<tr>
						   <td>Direct Link : </td>
						   <td><input type=\"text\" value=\"".$SCRIPT_WEB_BASE.$direct_target_path."\"></td>
						   </tr>
						  </table></br></br>";
					 $WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING=1;
	   
				  }
					else
				  {
					echo "There was an error uploading the file, please try again! ( the file could not be moved )<br> ";
				  } 
		   }
	   }
     echo '<a href="index.php">Return to MyLoader!</a>';
   }
 else
{  
 echo

  "<table >
   <tr height=10><td><td></tr>
   <tr><td>";
  
 if ( ($MAXIMUM_CACHE_QUOTA!=0) && ($cache_size>$MAXIMUM_CACHE_QUOTA) )
 { 
   /* Server over cache quotta no use uploading anything*/
   echo "<b>This Server has exceeded its cache quotta!</b>";
 } else
 {  
 echo "
   <form enctype=\"multipart/form-data\" action=\"index.php\" method=\"POST\">
           <input type=\"hidden\" name=\"rawresponse\" value=\"NO\" />
           File to upload: <input name=\"uploadedfile\" type=\"file\" /> 
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type=\"submit\" value=\"Upload File\" name=\"submit\" />";
  
 }
     if ($ENABLE_RANDOM_FILE==1) 
         {
          echo "&nbsp;&nbsp;<input type=\"button\" value=\"".$RANDOM_FILE_BUTTON_LABEL."\" name=\"submit\" onclick=\"window.location.href='random.php';return false\" />"; 
         }
    
    if ($ENABLE_URL_UPLOAD ==1 )
    {
    // MORE OPTIONS ARE INCLUDED HERE
    echo "<br><span id=\"buttonmoreoptions\" class=\"is_on\" onclick=\"make_moreoptions_visible();\"><span id=\"Footnote\"><a href=\"#\" >More Upload Options</a></span></span>"; 
    echo "<span id=\"moreoptions\" class=\"is_off\"><br>
           URL :  <input name=\"website\" type=\"text\" /> 
 
           <br><br><span id=\"Footnote\"><a href=\"#\" onclick=\"make_moreoptions_invisible()\" >Less Upload Options</a></span>
          </span>"; 
    // MORE OPTIONS ARE INCLUDED HERE
    }

 echo 
   "
   </form>
   </td></tr> 
   </table>
  ";
 
}
?>
<br/><br/><br/><br/>
<?php echo $BEFOREFOOTER_HTML_INJECTION;  
  write_footer($time_enter,$HOST_NAME,$LOCAL_PHP_FILE_LIMIT,$cache_size,$ENABLE_FILE_INDEXING,$ENABLE_MIRROR_LINK,$ENABLE_SHOW_STATS);
 echo $AFTERFOOTER_HTML_INJECTION; ?>
</center>
</div>
</body>
</html>

<?php
  if ( $WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING==1 ) 
   {
		check_and_clean_uploads();
   } 
?>
