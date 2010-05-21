<?php
   $VERSION="0.89";
   $time_enter=microtime(true);
   require("configuration.php");  
   require("cleaning_support.php");  
   require("stat_keeper.php");   

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
<title>MyUploads @ <?php echo $HOST_NAME; ?></title>

<style type="text/css">

#Footnote
   {     
    color:#000000;
    font-size:9px;
    font-style:italic; 
   }

#Banner
   {
     background-image:url('<?php  $num=rand(1,3); echo $SCRIPT_WEB_BASE."images/banner_".$num.".jpg";?>');
     background-repeat:no-repeat;
     width:600px;
     height:148px;
     color:#EEEEEE;
     font-size:33px;
     font-weight:900; 
     padding-top:55px;
   }

#Logo { visibility:hidden; }
a:link {color:#FF0000;}      /* unvisited link */
a:visited {color:#CC0000;}  /* visited link */
a:hover {color:#FF00FF;}  /* mouse over link */
a:active {color:#0000FF;}  /* selected link */
</style>

</head>
<body><img id="Logo" src="images/logo.png"> 
<div><center><br><br>
<div id="Banner">MyUploads <blink>@</blink> <?php echo $HOST_NAME; ?></div>

<?php
  echo "<!-- Version ".$VERSION." -->";
  $WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING=0;
  if(isset($_POST['submit']))
   {
      $tmpdir = md5($_FILES['uploadedfile']['name'].date('l jS \of F Y h:i:s A'));
      if($_FILES['uploadedfile']['size']>$LOCAL_PHP_FILE_LIMIT)
       {
         echo "Files > ".($LOCAL_PHP_FILE_LIMIT/(1024*1024))."MB are not permitted";
       }
          else
       { 
             $base_path = "./uploads/";
             $new_filename = $tmpdir."-".basename( $_FILES['uploadedfile']['name']);
              
             //New file.php file sender 
             $new_target_path = "file.php?i=".$new_filename; 

             $target_path = $base_path.$new_filename; 
              
             if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'],$target_path))
              {
                 echo "The file <b>".basename( $_FILES['uploadedfile']['name'])."</b> has been uploaded<br/>";
               
                 add_to_cache_size($_FILES['uploadedfile']['size']); 

                 echo "You can access the file <a href='$new_target_path' target=\"_new\">here</a><br/>";
                 $WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING=1;
   
              }
                else
              {
                echo "There was an error uploading the file, please try again! ( the file could not be moved ) ";
              } 
       }
     echo '<a href="index.php">Upload a new file!</a>';
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
          echo "&nbsp;&nbsp;<input type=\"button\" value=\"R\" name=\"submit\" onclick=\"window.location.href='random.php';return false\" />"; 
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
<span id="Footnote">
Every file should be < <?php $max_upload = (int)(ini_get('upload_max_filesize'));  echo $max_upload; ?> MB 
and all the uploaded files are deleted in daily basis.<br>
Written by <a href="http://periklis.is-a-geek.com/" title="Periklis Ntanasis" target="_new">Master_Ex</a> , 
           <a href="http://ammarkov.ath.cx/" title="Ammar Qammaz" target="_new">AmmarkoV</a> , MyUploads is opensource get it 
           <a href="http://github.com/MasterEx/myloader" title="GitHub repository for MyUploads project" target="_new">here</a>
           <br><br>


<?php 
      $cache_size = intval(get_cache_size()); 
      if ($cache_size>0) { echo $cache_size / (1024*1024);
                           echo " MB of shared data <br>"; 
                         }
?>

Generated in <?php echo (microtime(true)-$time_enter); ?> seconds<br>

</span>
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
