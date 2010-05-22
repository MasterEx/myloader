<?php
   $VERSION="0.925";
   $time_enter=microtime(true);
   require("configuration.php");  
   require("cleaning_support.php");  
   require("stat_keeper.php");   
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
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="el" xml:lang="el">
<head>
<META name="author" content="Periklis Ntanasis a.k.a. Master_ex , Ammar Qammaz a.k.a. AmmarkoV">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<meta name="keywords" content="personal uploader" />
<meta name="description" content="" />
<meta name="distribution" content="global" />
<title>MyLoader @ <?php echo $HOST_NAME; ?></title>

<link rel="stylesheet" type="text/css" href="myloader.css" />
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
</style>
<?php echo $HEAD_HTML_INJECTION; ?>
</head>
<body><img id="Logo" src="images/logo.png"> 
<div><center><br><br>
<div width=600 height=148 id="BannerInside"><table width=600 height=148 id="BannerMask"><tr><td align="center">MyLoader <blink>@</blink> <?php echo $HOST_NAME; ?></td></tr></table></div>
<?php echo $AFTERLOGO_HTML_INJECTION; ?>

<?php
  echo "<!-- Version ".$VERSION." -->";
  $WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING=0;
  $cache_size = intval(get_cache_size()); //we get the cache size here because it is needed for the bottom line and for quota checks
      

  if(isset($_POST['submit']))
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
          else
       { 
             $base_path = "./".$SCRIPT_CACHE_FOLDERNAME."/";
             $new_filename = $tmpdir."-".basename( $_FILES['uploadedfile']['name']);
              
             //New file.php file sender 
             $new_target_path = "file.php?i=".$new_filename; 

             $target_path = $base_path.$new_filename; 
              
             if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'],$target_path))
              {
                 echo "<br/>The file <b>".basename( $_FILES['uploadedfile']['name'])."</b> has been uploaded<br/>";
                 add_to_cache_size($_FILES['uploadedfile']['size']); 

                 echo "You can access the file <a href='$new_target_path' target=\"_new\">here</a><br/>";
                 $WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING=1;
   
              }
                else
              {
                echo "There was an error uploading the file, please try again! ( the file could not be moved )<br> ";
              } 
       }
     echo '<a href="index.php">Return to MyLoader!</a>';
   }
 else
{  
 echo
  "
   <table >
   <tr height=10><td><td></tr>
   <tr><td>
   <form enctype=\"multipart/form-data\" action=\"index.php\" method=\"POST\">
           <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"33554432\" />
           File to upload: <input name=\"uploadedfile\" type=\"file\" /> 
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type=\"submit\" value=\"Upload File\" name=\"submit\" />"; 
     if ($ENABLE_RANDOM_FILE==1) 
         {
          echo "&nbsp;&nbsp;<input type=\"button\" value=\"".$RANDOM_FILE_BUTTON_LABEL."\" name=\"submit\" onclick=\"window.location.href='random.php';return false\" />"; 
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
  write_footer($time_enter,$HOST_NAME,$cache_size,$ENABLE_FILE_INDEXING,$ENABLE_MIRROR_LINK,$ENABLE_SHOW_STATS);
 echo $AFTERFOOTER_HTML_INJECTION; ?>
</center>
</div>
</body>
</html>

<?php
  if ( $WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING==1 ) 
   {
    // Disabled for now , first make sure code in cleaning support is stable
    // check_and_clean_uploads();
   } 
?>
