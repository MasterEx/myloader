<?php 

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

	require("configuration.php"); 

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="el" xml:lang="el">
<head>
<META name="author" content="Periklis Ntanasis a.k.a. Master_ex , Ammar Qammaz a.k.a. AmmarkoV">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<meta name="keywords" content="personal uploader" />
<meta name="description" content="" />
<meta name="distribution" content="global" />
<title>MyLoader @ <?php echo $HOST_NAME; ?></title>

<style type="text/css">

#Footnote
   {     
    color:#000000;
    font-size:9px;
    font-style:italic; 
   }

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

#Logo { visibility:hidden; }
a:link {color:#FF0000;}      /* unvisited link */
a:visited {color:#CC0000;}  /* visited link */
a:hover {color:#FF00FF;}  /* mouse over link */
a:active {color:#0000FF;}  /* selected link */
</style>

</head>
<body>
<center>
<?php
	if($ENABLE_FILE_INDEXING==1)
	{
?>

	<table>	
	<tr>
			<td>File name</td>
			<td>Hours on server</td>
	</tr>
<?php
		$target=$SCRIPT_LOCAL_BASE."uploads/";
		$files=scandir($target);
		$now=date("U");
		$switch=0;
		foreach($files as $file)
		{
			if(strcmp($file,"index.html")==0 || strcmp($file,"check_x.png")==0 || strcmp($file,".")==0 || strcmp($file,"..")==0 || strcmp($file,".htaccess")==0)
			{
				continue;
			}
			if($switch==1)
			{
				$color="#FFFFFF";
				$switch=0;
			} else
			{
				$color="#CCCCCC";
				$switch=1;
			}
			$fileseconds=date("U", filemtime($target.$file));
			$filehours=($now - $fileseconds)/3600;
			$filename=substr($file,33);
			echo '
			<tr>
				<td bgcolor='.$color.'> <a href="file.php?i='.$file.'">'.$filename.'</a> </td>
				<td bgcolor='.$color.'> '.intval($filehours).' </td>
			</tr>
		';
		}
?>
	</table>

<?php
	}
	
?>
<br/><br/><b><a href="index.php">Go Back?</a></b><br/><br/>
<span id="Footnote">
Every file should be < <?php $max_upload = (int)(ini_get('upload_max_filesize'));  echo $max_upload; ?> MB 
and all the uploaded files are deleted in daily basis.<br>
Written by <a href="http://periklis.is-a-geek.com/" title="Periklis Ntanasis" target="_new">Master_Ex</a> , 
           <a href="http://ammarkov.ath.cx/" title="Ammar Qammaz" target="_new">AmmarkoV</a> , MyLoader is opensource get it 
           <a href="http://github.com/MasterEx/myloader" title="GitHub repository for MyLoader project" target="_new">here</a>
           <br><br>


<?php 

if ( $ENABLE_MIRROR_LINK == 1 )
 {
       echo "Is ".$HOST_NAME." slow ? , <a href=\"mirrors.php\" target=\"_new\">try another host</a><br><br>";
 }


if ( $ENABLE_SHOW_STATS == 1 )
 {
      if ($cache_size>0) { echo number_format($cache_size / (1024*1024),2);
                           echo " MB of shared data <br>"; 
                         }

      $uploaded_bandwidth=get_uploaded_bandwidth();
      if ($uploaded_bandwidth>0) { echo number_format($uploaded_bandwidth / (1024*1024),2);
                                   echo " MB of data uploaded <br>"; 
                                 }
 }
    
?>

Generated in <?php echo number_format((microtime(true)-$time_enter),4); ?> seconds<br>

</span>
</center>
</body>
</html>
