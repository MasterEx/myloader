<?php
  require("configuration.php");
  require("stat_keeper.php");   
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
			   // TODO -> remove_from_cache_size(filesize($target.$file));	
                           unlink($target.$file);
			}
		}
	}
 }

?>
