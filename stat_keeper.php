<?php

function message_error_adding_stats()
  {
    echo "Please make sure that cache_size.ini exists and apache has write permissions ";
  }

function add_to_cache_size($new_file_size)
  {
   if (!file_exists ("cache_size.ini"))
   {
     // AUTO GENERATION OF FILE :)
     $file=fopen("cache_size.ini","w+");
     fwrite($file,0); 
     fclose($file);   
     return 0;
   }  else
   {
    $file=fopen("cache_size.ini","r") or exit("Internal Cache Counting error!");
    $theData = fread($file, filesize("cache_size.ini")); 
    $the_count=intval($theData)+intval($new_file_size);
    fclose($file);  
    
    $file=fopen("cache_size.ini","w");
    fwrite($file, $the_count); 
    fclose($file);  
    return $the_count;
   }
 
  echo "Something Weird Happening , this function should return before reaching here :P ";
  return 0;
  }

function remove_from_cache_size($new_file_size)
  {  
    if (!file_exists ("cache_size.ini"))
   {
     // AUTO GENERATION OF FILE :)
     $file=fopen("cache_size.ini","w+");
     fwrite($file,0); 
     fclose($file);   
     return 0;
   }  else
   {
    $file=fopen("cache_size.ini","r") or exit("Internal Cache Counting error!");
    $theData = fread($file, filesize("cache_size.ini")); 
    $the_count=intval($theData)-intval($new_file_size);
    fclose($file);  
    
    $file=fopen("cache_size.ini","w");
    fwrite($file, $the_count); 
    fclose($file);  
    return $the_count;
   }
 
  echo "Something Weird Happening , this function should return before reaching here :P ";
  return 0;
  }

function get_cache_size()
  {
   if (!file_exists ("cache_size.ini"))
   {
     // AUTO GENERATION OF FILE :)
     $file=fopen("cache_size.ini","w+");
     fwrite($file,0); 
     fclose($file);   
     return 0;
   }  else
   {
   $file=fopen("cache_size.ini","r") or exit("Internal Cache Counting error!");
   $theData = fread($file, filesize("cache_size.ini")); 
   fclose($file);  
   return intval($theData); 
   } 
  }

?>
