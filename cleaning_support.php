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


 /*
     NOT TESTED YET!
 */

/*
                    //    MB
   $MAXIMUM_CACHE_QUOTA=   2024              * 1024 * 1024 ; // 2GB max quotta for uploads
   $MAXIMUM_STAY_ON_SERVER_HOURS=0; // 0 Means indefinately 
   Moved to configuration :D
*/

 function check_and_clean_uploads()
 {
	if($MAXIMUM_STAY_ON_SERVER_HOURS!=0)
	{
		$target=$SCRIPT_WEB_BASE."uploads/";
		$files=scandir($target);
		$now=date("U");
		foreach($files as $file)
		{
			if(strcmp($file,"index.html")==0 || strcmp($file,"check_x.png")==0)
			{
				continue;
			}
			$fileseconds=date("U", filemtime($file));
			$filehours=($now - $fileseconds)/3600;
			if($filehours>$MAXIMUM_STAY_ON_SERVER_HOURS)
			{
			   remove_from_cache_size(filesize($target.$file));	
                           unlink($target.$file);
			}
		}
	}
 }

?>
