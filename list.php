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
			<script type="text/javascript">
			
			function sortByNameA(a,b) {				
				var x = a[0].toLowerCase();
				var y = b[0].toLowerCase();
				return ((x < y) ? -1 : ((x > y) ? 1 : 0));
			}
			function sortByNameD(a,b) {				
				var x = a[0].toLowerCase();
				var y = b[0].toLowerCase();
				return ((x > y) ? -1 : ((x < y) ? 1 : 0));
			}
			function sortByHoursA(a,b) {				
				var x = a[2];
				var y = b[2];
				return (x-y);
			}
			function sortByHoursD(a,b) {				
				var x = a[2];
				var y = b[2];
				return (y-x);
			}
			function sortBySizeA(a,b) {				
				var x = a[3];
				var y = b[3];
				return (x-y);
			}
			function sortBySizeD(a,b) {				
				var x = a[3];
				var y = b[3];
				return (y-x);
			}
			function showFiles(choice) {
				var color = "#FFFFFF";
				var flag = 0;
							if(choice==1)
							{								
								table.sort(sortByNameA);
								document.getElementById('filehead').innerHTML = "<td>File name<a onclick=\"showFiles(2)\"> &darr;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>Hours on server<a onclick=\"showFiles(3)\"> &#8634;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>~ Size (KB)<a onclick=\"showFiles(5)\"> &#8634;</a></td>";
							}
							else if(choice==2)
							{
								table.sort(sortByNameD);
								document.getElementById('filehead').innerHTML = "<td>File name<a  onclick=\"showFiles(1)\"> &uarr;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>Hours on server<a onclick=\"showFiles(3)\"> &#8634;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>~ Size (KB)<a onclick=\"showFiles(5)\"> &#8634;</a></td>";
							}
							else if(choice==3)
							{
								table.sort(sortByHoursA);
								document.getElementById('filehead').innerHTML = "<td>File name<a onclick=\"showFiles(1)\"> &#8634;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>Hours on server<a onclick=\"showFiles(4)\"> &darr;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>~ Size (KB)<a onclick=\"showFiles(5)\"> &#8634;</a></td>";
							}
							else if(choice==4)
							{
								table.sort(sortByHoursD);
								document.getElementById('filehead').innerHTML = "<td>File name<a onclick=\"showFiles(1)\"> &#8634;</a></td>";
								document.getElementById('filehead').innerHTML +="<td>Hours on server<a  onclick=\"showFiles(3)\"> &uarr;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>~ Size (KB)<a onclick=\"showFiles(5)\"> &#8634;</a></td>";
							}
							else if(choice==5)
							{
								table.sort(sortBySizeA);
								document.getElementById('filehead').innerHTML = "<td>File name<a onclick=\"showFiles(1)\"> &#8634;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>Hours on server<a onclick=\"showFiles(3)\"> &#8634;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>~ Size (KB)<a onclick=\"showFiles(6)\"> &darr;</a></td>";
							}
							else if(choice==6)
							{
								table.sort(sortBySizeD);
								document.getElementById('filehead').innerHTML = "<td>File name<a onclick=\"showFiles(1)\"> &#8634;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>Hours on server<a onclick=\"showFiles(3)\"> &#8634;</a></td>";
								document.getElementById('filehead').innerHTML += "<td>~ Size (KB)<a  onclick=\"showFiles(5)\"> &uarr;</a></td>";
							}
						for(var i=0;i<table.length;i++)
						{
							if(flag)
							{
								color="#FFFFFF";
								flag=0;
							}
							else
							{
								color="#CCCCCC";
								flag=1;
							}
							if(i==0)
							{
								document.getElementById('tablerow').innerHTML = "<tr>";
							}
							else
							{
								document.getElementById('tablerow').innerHTML += "<tr>";
							}
							s = table[i][1];
							ext = s.substring(s.length-4).toLowerCase();
							gdoc ="";
							<?php
							if($ENABLE_GOOGLEDOCS_LINK == 1)
							{?>
								if(ext==".pdf" || ext=="tiff" || ext==".ppt" || ext=="pptx")
								{
									gdoc = "<a target=\"_blank\" href=\"http://docs.google.com/viewer?url="+table[i][4]+"\"><img src=\"images/gdocs.jpg\" height=\"15\" width=\"13\" /></a>";
								}<?php
							}?>
								document.getElementById('tablerow').innerHTML += "<td bgcolor='"+color+"'> "+gdoc+"<a href=\"vfile.php?i="+escape(table[i][1])+"\">"+table[i][0]+"</a> </td><td bgcolor='"+color+"'>"+table[i][2]+"</td><td bgcolor='"+color+"'>"+table[i][3]+"</td>";
							document.getElementById('tablerow').innerHTML += "</tr>";
						}
			}
<?php
		$target=$SCRIPT_LOCAL_BASE."uploads/";
		$files=scandir($target);
		$now=date("U");
		$switch=0;
		$i=0;
		echo '			var table = new Array();';
		foreach($files as $file)
		{
			if(strcmp($file,"index.html")==0 || strcmp($file,"check_x.png")==0 || strcmp($file,".")==0 || strcmp($file,"..")==0 || strcmp($file,".htaccess")==0)
			{
				continue;
			}
			$fileseconds=date("U", filemtime($target.$file));
			$filehours=($now - $fileseconds)/3600;
			$filename=substr($file,33);
			echo '			
			var line=new Array(4);
				line[0]="'.$filename.'";
				line[1]="'.$file.'";
				line[2]="'.intval($filehours).'";
				line[3]="'.intval(filesize($target.$file)/1024).'";
				line[4]="'.urlencode($SCRIPT_WEB_BASE."file.php?i=".urlencode($file)).'";
				table['.$i.']=line;			
			';				
			$i++;
		}
?>		
		</script>
		<table>
			<thead ><tr id="filehead"></tr></thead>
			<tbody id="tablerow"></tbody>
		</table>
		<script type="text/javascript">
		showFiles(1);
		</script>

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
