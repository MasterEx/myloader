#!/usr/bin/env bash
#
# GNU General Public License version 2 or later
#
# Copyright (C) 2011 by Periklis Ntanasis , Ammar Qammaz
# 

function createconfiguration() {
	echo   "<?php
   // You should change these variables according to your setup&needs :) 
   // If you break something just copy paste the original configuration.php and change them again 
   
   /* ------------ SERVER SETUP VARIABLES ------------ */
   \$HOST_NAME=\"$hostname\"; // Host Name
   \$SCRIPT_WEB_BASE=\"$url\";
   \$SCRIPT_LOCAL_BASE=\"$scriptlocal/\";
   \$SCRIPT_CACHE_FOLDERNAME=\"uploads\";

   
   /* ------------ WEB-DESIGN :P  VARIABLES ------------ */
   \$BANNER_PREFIX = \"banner_\"; //Change this to make your own banners while keeping the old ones , reminder : you will have to make a banner_mask.png too!
   \$BANNER_NUMBER = 7; // The total number of banners that exist
   \$DISABLE_PREVIEW_FOR_NON_IMAGE_FILES = 1; // 1/0 Switch - This switch will enable/disable preview of file images ( they will be sent at once )
   \$ENABLE_URL_UPLOAD =    1; // 1/0 Switch - This switch will enable/disable the use of other upload options
   \$ENABLE_MIRROR_LINK =   1; // 1/0 Switch - This switch will enable/disable the link to mirrors
   \$ENABLE_SHOW_STATS =    1; // 1/0 Switch - This switch will enable/disable the output of webserver statistics on the index
   \$ENABLE_RANDOM_FILE =   1; // 1/0 Switch - This switch will enable/disable the random file capability
   \$ENABLE_FILE_INDEXING = 1; // 1/0 Switch - This switch will enable/disable the file listing capability   
   \$ENABLE_GOOGLEDOCS_LINK= 1; // 1/0 Switch - This switch will enable/disable the googledocs capability
   \$WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING = 0; // 1/0 Switch - This switch will enable/disable the file autodelete capability - $MAXIMUM_STAY_ON_SERVER_HOURS should have a value >0
   \$RANDOM_FILE_BUTTON_LABEL = \"R\"; // This variable changes the label on the random button , you may want to make it /b/ or something else :P
   
   /* ------------ HTML5 CAPABILITIES  ------------ */
   \$FLASH_EMBEDS = 1; // 1/0 Switch - This switch will enable/disable automatic embedded flash in the pages  
   \$HTML5_VIDEO = 1; // 1/0 Switch - This switch will enable/disable video tag usage , in some years when html5 will be common place , these 3 switches may not be needed any longer :P
   \$HTML5_AUDIO = 1; // 1/0 Switch - This switch will enable/disable audio tag usage 
   \$HTML5_COMPATIBILITY_AUDIO_VIDEO = 1; // 1/0 Switch - This switch will enable/disable audio video compatibility ( See https://github.com/etianen/html5media )
   \$HTML5_CLIPBOARD = 1; // 1/0 Switch - This switch will enable/disable html5 clibboard 
   \$HTML5_KEYBOARD = 1; // 1/0 Switch - This switch will enable/disable html5 keyboard shortcuts
   
   /* MODDING VARIABLES */
   /* You can use these variables to make additions to the page i.e. javascripts,css,music embeds,w/e without altering index.php  */
   \$HEAD_HTML_INJECTION=\" \";
   \$AFTERLOGO_HTML_INJECTION=\" \";
   \$BEFOREFOOTER_HTML_INJECTION=\" \";
   \$AFTERFOOTER_HTML_INJECTION=\" \";

   /* ------------ BANDWIDTH RELATED VARIABLES ------------ */
                                 //  ENABLED          MB
   \$MAXIMUM_UPLOAD_BANDWIDTH_QUOTA  =  0*            1024           * 1024 * 1024 ; // 1GB max quotta for uploads
   \$MAXIMUM_CACHE_QUOTA             =  1*            2024           * 1024 * 1024 ; // 2GB max quotta for uploads
   \$LOCAL_PHP_FILE_LIMIT            =  1*            20             * 1024 * 1024; // 20 MB
   \$MAXIMUM_STAY_ON_SERVER_HOURS=0; // 0 Means indefinately
   
?>" > configuration.php
}

echo "chmod 777 . ./uploads"
chmod 777 . ./uploads

hostname=$(hostname)
echo "hostname: $hostname"

scriptlocal=$(pwd)
echo "script local base: $scriptlocal/"

echo "Enter the myloader url (i.e. http://localhost/myloader/ ):"
read url;

echo "Create the configuration.php"
createconfiguration

echo "chmod 700 install.sh"
chmod 666 install.sh

echo "See configuration.php for more exensive configuration of myloader"

echo "To complete myloader configuration edit your PHP and Apache configuration
as mentioned here https://github.com/MasterEx/myloader/blob/master/README.mkdn"

exit 0
