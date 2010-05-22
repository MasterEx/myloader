<?php 

/* configuration.php and stat_keeper.php are required before this */

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


 /*
     NOT TESTED YET!
 */

 function check_and_clean_uploads()
 {
	global $MAXIMUM_STAY_ON_SERVER_HOURS, $SCRIPT_LOCAL_BASE;
	if($MAXIMUM_STAY_ON_SERVER_HOURS!=0)
	{
		echo "run";
		$target=$SCRIPT_LOCAL_BASE."uploads/";
		$files=scandir($target);
		$now=date("U");
		foreach($files as $file)
		{
			if(strcmp($file,"index.html")==0 || strcmp($file,"check_x.png")==0 || strcmp($file,".")==0 || strcmp($file,"..")==0 || strcmp($file,".htaccess")==0)
			{
				continue;
			}
			$fileseconds=date("U", filemtime($target.$file));
			$filehours=($now - $fileseconds)/3600;
			echo "in";
			if($filehours>$MAXIMUM_STAY_ON_SERVER_HOURS)
			{
				echo "not in";
			   remove_from_cache_size(filesize($target.$file));	
                           unlink($target.$file);
                           echo "not in2";
			}
		}
	}
 }
 

?>
