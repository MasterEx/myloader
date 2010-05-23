<?php
   // You should change these variables according to your setup&needs :) 
   // If you break something just copy paste the original configuration.php and change them again 
   
   /* ------------ SERVER SETUP VARIABLES ------------ */
   $HOST_NAME="AmmarServer"; // Host Name
   $SCRIPT_WEB_BASE="http://ammarkov.ath.cx/myloader/";
   $SCRIPT_LOCAL_BASE="/home/ammar/public_html/atech/myloader/";
   $SCRIPT_CACHE_FOLDERNAME="uploads";

   
   /* ------------ WEB-DESIGN :P  VARIABLES ------------ */
   $BANNER_PREFIX = "banner_"; //Change this to make your own banners while keeping the old ones , reminder : you will have to make a banner_mask.png too!
   $BANNER_NUMBER = 7; // The total number of banners that exist
   $ENABLE_MIRROR_LINK = 1; // 1/0 Switch - This switch will enable/disable the link to mirrors
   $ENABLE_SHOW_STATS = 1; // 1/0 Switch - This switch will enable/disable the output of webserver statistics on the index
   $ENABLE_RANDOM_FILE = 1; // 1/0 Switch - This switch will enable/disable the random file capability
   $ENABLE_FILE_INDEXING = 1; // 1/0 Switch - This switch will enable/disable the file listing capability
   $WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING = 0; // 1/0 Switch - This switch will enable/disable the file autodelete capability - $MAXIMUM_STAY_ON_SERVER_HOURS should have a value >0
   $RANDOM_FILE_BUTTON_LABEL = "R"; // This variable changes the label on the random button , you may want to make it /b/ or something else :P
   
   /* MODDING VARIABLES */
   /* You can use these variables to make additions to the page i.e. javascripts,css,music embeds,w/e without altering index.php  */
   $HEAD_HTML_INJECTION=" ";
   $AFTERLOGO_HTML_INJECTION=" ";
   $BEFOREFOOTER_HTML_INJECTION=" ";
   $AFTERFOOTER_HTML_INJECTION=" ";

   /* ------------ BANDWIDTH RELATED VARIABLES ------------ */
                                 //  DISABLE          MB
   $MAXIMUM_UPLOAD_BANDWIDTH_QUOTA  =  0*            1024           * 1024 * 1024 ; // 1GB max quotta for uploads
   $MAXIMUM_CACHE_QUOTA             =  0*            2024           * 1024 * 1024 ; // 2GB max quotta for uploads
   $LOCAL_PHP_FILE_LIMIT            =  1*            20             * 1024 * 1024; // 20 MB
   $MAXIMUM_STAY_ON_SERVER_HOURS=0; // 0 Means indefinately
   
?>
