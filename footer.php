<?php  

function write_footer($starttime,$servername,$localfilelimit,$cache_size,$fileindex_sw,$mirrorlink_sw,$showstats_sw)
{
 echo "<span id=\"Footnote\">Every file should be < ";
                        $max_upload = (int)(ini_get('upload_max_filesize')); 
                        if ($max_upload>$localfilelimit) $max_upload=$localfilelimit;
                        echo $max_upload."MB";
                        if ($WILL_CHECK_IF_UPLOAD_DIR_NEEDS_CLEANING == 1)
                        {
							echo " and all the uploaded files are deleted in daily basis";
						}
						echo ".<br>";


echo
"
Written by <a href=\"https://github.com/MasterEx\" title=\"Periklis Ntanasis\" target=\"_blank\">Master_Ex</a> , 
           <a href=\"http://ammarkov.ath.cx/\" title=\"Ammar Qammaz\" target=\"_blank\">AmmarkoV</a> , MyLoader is <a href=\"http://en.wikipedia.org/wiki/Free_and_open_source_software\">f.o.s.s.</a> get it 
           <a href=\"http://github.com/MasterEx/myloader\" title=\"GitHub repository for MyLoader project\" target=\"_blank\">here</a>
           <br><br>
";


if($fileindex_sw==1)
{
	echo "View file list <a href=\"list.php\">here</a><br/>";
}
if ( $mirrorlink_sw == 1 )
 {
       echo "Is ".$servername." slow ? , <a href=\"http://masterex.github.com/myloader/\" target=\"_blank\">try another host</a><br><br>";
 }


if ( $showstats_sw == 1 )
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
