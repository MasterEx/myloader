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

function check_if_its_too_soon_after_last_clean_operation()
{ 
  if (!file_exists ("last_cleanup.ini"))
   {
     // AUTO GENERATION OF FILE :)
     echo "Auto Generation of cleanup file!";
     $file=fopen("last_cleanup.ini","w+");
     fwrite($file,""); 
     fclose($file);   
     return 0; // NO FILE EXISTS MEANS NO CLEANUP HAS BEEN CALLED ( EVER )
   }
     else 
   { 
     /* TODO ADD CODE THAT CHECKS IF IT IS TOO SOON BY USING A FILE TO STORE LAST CLEAN UP DATE&TIME! */ 
   }
  return 0;
}


function check_and_clean_uploads()
 {
   if ( check_if_its_too_soon_after_last_clean_operation() == 1 ) return;


	global $MAXIMUM_STAY_ON_SERVER_HOURS, $SCRIPT_LOCAL_BASE;
	if($MAXIMUM_STAY_ON_SERVER_HOURS!=0)
	{
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
			if($filehours>$MAXIMUM_STAY_ON_SERVER_HOURS)
			{
			   remove_from_cache_size(filesize($target.$file));	
                           unlink($target.$file);
			}
		}
	}
 }
 

?>
