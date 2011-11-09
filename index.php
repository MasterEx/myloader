<?php
   $VERSION="0.954";
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


?>
<!DOCTYPE html>
<html>
<head>
<meta name="author" content="Ammar Qammaz" >
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<meta name="keywords" content="personal uploader" />
<meta name="description" content="" /> 
<title>MyLoader @ <?php echo $HOST_NAME; ?></title>

<link rel="stylesheet" type="text/css" href="myloader.css" />
<script src="myloader.js" type="text/javascript"></script>
<style type="text/css">

</style>
<?php echo $HEAD_HTML_INJECTION; ?>
</head>
<body>

<img id="invisible" src="images/host_logo.png" alt="MyLoader <?php echo $HOST_NAME; ?>" > 
<!-- This , here exists in order for url shortners to be able to output the logo of the MyLoader Service :) -->

<div class="MainTab" >
 
<br><br>


<?php 
  
  // THE FOLLOWING CALL PRODUCES THE NICE WEB-DESIGN THINGY ( :P ) WITH THE BLINKING @ IN THE MIDDLE 
  write_nice_logo($HOST_NAME,$BANNER_NUMBER,$SCRIPT_WEB_BASE,$BANNER_PREFIX);
    
    
  echo $AFTERLOGO_HTML_INJECTION; 
  echo "<!-- Version ".$VERSION." -->";
  $cache_size = intval(get_cache_size()); //we get the cache size here because it is needed for the bottom line and for quota checks
      
  
  if(isset($_POST['submit']))
   {
     //THIS IS DONE TO ENABLE GREEK ETC CHARACTERS TO BE SAVED WITH NO PROBLEMS 
     //The text is converted to question marks ( ? ) which can be further improved , but the upload works..!  	
     $incoming_file_name = utf8_decode($_FILES['uploadedfile']['name']);	
     $incoming_file_name = strip_tags($incoming_file_name,0);
     $incoming_file_name = stripslashes($incoming_file_name);
     
   	
     if ($ENABLE_URL_UPLOAD == 1 && (strlen($_POST['website'])>0))
     {
			echo "Website From URL Requested ".$_POST['website'];
			DownloadFile($_POST['website']);
     }
     else
     {
		  $tmpdir = md5($incoming_file_name.date('l jS \of F Y h:i:s A'));

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
				 $new_filename = $tmpdir."-".basename($incoming_file_name);
				  
				 //New file.php file sender 
				 $direct_target_path = "file.php?i=".urlencode($new_filename); 
				 $new_target_path = "vfile.php?i=".urlencode($new_filename); 

				 $target_path = $base_path.$new_filename; 
				  
				 if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'],$target_path))
				  {
					 echo "<br/>The file <b>".basename($incoming_file_name);
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
						 if (in_array(end(explode(".",strtolower($incoming_file_name))),$gdocsExtensions)) 
						 {
							echo " - @<a href=\"http://docs.google.com/viewer?url=".urlencode($SCRIPT_WEB_BASE.$direct_target_path)."\">GoogleDocs</a>";
						 }
					 }
					 echo "<br/><br/> 
                     <table id=\"StayCentered\">					      
					       <tr>
						     <td>Link : </td>
						     <td><input type=\"text\" value=\"".$SCRIPT_WEB_BASE.$new_target_path."\"></td>
						   </tr>";
					echo "<tr>
						     <td>Direct Link : </td>
						     <td><input type=\"text\" value=\"".$SCRIPT_WEB_BASE.$direct_target_path."\"></td>
						   </tr>
						  </table>
						  </br></br>";
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

  "<br>
   <table id=\"StayCentered\" > 
   <tr><td>";
  
 if ( ($MAXIMUM_CACHE_QUOTA!=0) && ($cache_size>$MAXIMUM_CACHE_QUOTA) )
 { 
   /* Server over cache quotta no use uploading anything*/
   echo "<b>This Server has exceeded its cache quotta!</b>";
 } else
 {  
 echo "  
   <form   enctype=\"multipart/form-data\" action=\"index.php\" method=\"POST\">
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
<br/><br/> 
<?php echo $BEFOREFOOTER_HTML_INJECTION;  
  write_footer($time_enter,$HOST_NAME,$LOCAL_PHP_FILE_LIMIT,$cache_size,$ENABLE_FILE_INDEXING,$ENABLE_MIRROR_LINK,$ENABLE_SHOW_STATS);
 echo $AFTERFOOTER_HTML_INJECTION; ?>
 
</div>
</body>
</html>

<?php
  if ( $WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING==1 ) 
   {
		check_and_clean_uploads();
   } 
?>
