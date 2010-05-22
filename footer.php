<?php 
require("configuration.php"); 

function write_footer($starttime)
{
 echo "<span id=\"Footnote\">Every file should be < ";
                        $max_upload = (int)(ini_get('upload_max_filesize')); 
                        if ($max_upload>$LOCAL_PHP_FILE_LIMIT) $max_upload=$LOCAL_PHP_FILE_LIMIT;
                        echo $max_upload."MB and all the uploaded files are deleted in daily basis.<br>";

if($ENABLE_FILE_INDEXING==1)
{
	echo "View file list <a href=\"list.php\">here</a><br/>";
}

echo
"
Written by <a href=\"http://periklis.is-a-geek.com/\" title=\"Periklis Ntanasis\" target=\"_blank\">Master_Ex</a> , 
           <a href=\"http://ammarkov.ath.cx/\" title=\"Ammar Qammaz\" target=\"_blank\">AmmarkoV</a> , MyLoader is opensource get it 
           <a href=\"http://github.com/MasterEx/myloader\" title=\"GitHub repository for MyLoader project\" target=\"_blank\">here</a>
           <br><br>
";



if ( $ENABLE_MIRROR_LINK == 1 )
 {
       echo "Is ".$HOST_NAME." slow ? , <a href=\"mirrors.php\" target=\"_blank\">try another host</a><br><br>";
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
    

echo "Generated in ".number_format((microtime(true)-$starttime),4)."  seconds<br>
      </span><br>";
}
?>
