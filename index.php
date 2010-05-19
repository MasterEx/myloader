<?php
   // VERSION 0.83
    
   $HOST_NAME="AmmarServer"; // Host Name
   $SCRIPT_WEB_BASE="http://ammarkov.ath.cx/uploads/";
   $LOCAL_PHP_FILE_LIMIT=20  *1024*1024; // 20 MB
   $time_enter=microtime(true);
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="el" xml:lang="el">
<head>
<META name="author" content="Periklis Ntanasis a.k.a. Master_ex">
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

#Logo
   {
     visibility:hidden;
   }

a:link {color:#FF0000;}      /* unvisited link */
a:visited {color:#CC0000;}  /* visited link */
a:hover {color:#FF00FF;}  /* mouse over link */
a:active {color:#0000FF;}  /* selected link */
</style>

</head>
<body><img id="Logo" src="images/logo.png"> 
<div><center><br><br>
<div id="Banner">MyUploads @ <?php echo $HOST_NAME; ?></div>

<?php

  if(isset($_POST['submit']))
   {
      $tmpdir = md5($_FILES['uploadedfile']['name'].date('l jS \of F Y h:i:s A'));
      if($_FILES['uploadedfile']['size']>$LOCAL_PHP_FILE_LIMIT)
       {
         echo "Files > ".($LOCAL_PHP_FILE_LIMIT/1024*1024)." are not permitted";
       }
          else
       { 
             $base_path = "./uploads/";
             $new_filename = $tmpdir."-".basename( $_FILES['uploadedfile']['name']);
              
             //New file.php file sender 
             $new_target_path = "file.php?i=".$new_filename; 

             $target_path = $base_path.$new_filename; 
              
             if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path))
              {
               echo "The file <b>".basename( $_FILES['uploadedfile']['name'])."</b> has been uploaded<br/>";
               
               echo "You can access the file <a href='$new_target_path' target=\"_new\">here</a><br/>";
                
              }
                else
              {
                echo "There was an error uploading the file, please try again! 1 ";
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
           <input type=\"submit\" value=\"Upload File\" name=\"submit\" /> 
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
Written by <a href="http://periklis.is-a-geek.com/" target="_new">Master_Ex</a> , <a href="http://ammarkov.ath.cx/" target="_new">AmmarkoV</a><br><br>
Generated in <?php echo (microtime(true)-$time_enter); ?> ms<br>
</span>
</center>
</div>
</body>
</html>


