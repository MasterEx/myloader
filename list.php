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
        $time_enter=microtime(true); 
		require("configuration.php"); 
        require("stat_keeper.php");
		require("cleaning_support.php");  
        require("footer.php");  
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
<?php echo $HEAD_HTML_INJECTION; ?>
</head>
<body>
<center>
<?php
	if ( $WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING==1 ) 
	{
		check_and_clean_uploads();
	} 
	if($ENABLE_FILE_INDEXING==1)
	{
?>

	<table>	
	<tr>
			<td>File name</td>
			<td>Hours on server</td>
			<td>~ Size (KB)</td>
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
				<td bgcolor='.$color.'>'.intval(filesize($target.$file)/1024).'</td>
			</tr>
		';
		}
?>
	</table>

<?php
	}
	
?>
<br/><br/><b><a href="index.php">Go Back?</a></b><br/><br/>
 <?php
     $cache_size = intval(get_cache_size()); //we get the cache size here because it is needed for the bottom line and for quota checks
     write_footer($time_enter,$HOST_NAME,$LOCAL_PHP_FILE_LIMIT,$cache_size,$ENABLE_FILE_INDEXING,$ENABLE_MIRROR_LINK,$ENABLE_SHOW_STATS);
  ?>
</center>
</body>
</html>
