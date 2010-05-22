<?php
   // You should change these variables according to your setup&needs :) 
   // If you break something just copy paste the original configuration.php and change them again 
   
   /* ------------ SERVER SETUP VARIABLES ------------ */
   $HOST_NAME="AmmarServer"; // Host Name
   $SCRIPT_WEB_BASE="http://ammarkov.ath.cx/myloader/";
   $SCRIPT_LOCAL_BASE="/home/ammar/public_html/atech/myloader/";
   $SCRIPT_CACHE_FOLDERNAME="uploads";

   
   /* ------------ WEB-DESIGN :P  VARIABLES ------------ */
   $BANNER_PREFIX = "banner_";
   $BANNER_NUMBER = 7;
   $ENABLE_MIRROR_LINK = 1; // 1/0 Switch
   $ENABLE_SHOW_STATS = 1; // 1/0 Switch
   $ENABLE_RANDOM_FILE = 1; // 1/0 Switch
   $RANDOM_FILE_BUTTON_LABEL = "R";
   
   /* ------------ BANDWIDTH RELATED VARIABLES ------------ */
                                 //      MB
   $MAXIMUM_UPLOAD_BANDWIDTH_QUOTA  =   1024           * 1024 * 1024 ; // 1GB max quotta for uploads
   $MAXIMUM_CACHE_QUOTA             =   2024           * 1024 * 1024 ; // 2GB max quotta for uploads
   $LOCAL_PHP_FILE_LIMIT            =   20             * 1024 * 1024; // 20 MB
   $MAXIMUM_STAY_ON_SERVER_HOURS=0; // 0 Means indefinately
   
?>
