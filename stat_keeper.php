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

function add_to_uploaded_bandwidth($new_file_size)
{ 
   //echo "Adding a new file of total ".$new_file_size." bytes ";
   if (!file_exists ("upload_size.ini"))
   {
     // AUTO GENERATION OF FILE :)
     echo "Auto Generation of file while adding to upload_size! :P ";
     $file=fopen("upload_size.ini","w+");
     fwrite($file,0); 
     fclose($file);   
     return 0;
   }  else
   {
    $theData=0;  $the_count=0;    

    $file=fopen("upload_size.ini","r") or exit("Internal Cache Counting error!");
    if ($file) 
    { 
     $theData = fread($file, filesize("upload_size.ini")); 
     fclose($file);  
     $the_count=intval($theData)+intval($new_file_size);
    } else
    { echo "Could not retrieve new filesize from cache :S<br>"; }

    $file=fopen("upload_size.ini","w");
    if ($file) 
    {  
     fwrite($file, $the_count); 
     fclose($file);  
    } else 
    { echo "Could not add new filesize to cache :S<br>"; }

    return $the_count;
   }
 
  echo "Something Weird Happening , this function should return before reaching here :P ";
  return 0;
}

function get_uploaded_bandwidth()
 {
   if (!file_exists ("upload_size.ini"))
   {
     // AUTO GENERATION OF FILE :)
     echo "Auto Generation of file while getting upload_size! :P ";
     $file=fopen("upload_size.ini","w+");
     fwrite($file,0); 
     fclose($file);   
     return 0;
   }  else
   {
    $file=fopen("upload_size.ini","r") or exit("Internal Cache Counting error!");
    $theData = fread($file, filesize("upload_size.ini")); 
    fclose($file);  
    return intval($theData); 
   } 
   return 0;
 }


function add_to_cache_size($new_file_size)
{ 
   //echo "Adding a new file of total ".$new_file_size." bytes ";
   if (!file_exists ("cache_size.ini"))
   {
     // AUTO GENERATION OF FILE :)
     echo "Auto Generation of file while adding to cache_size! :P ";
     $file=fopen("cache_size.ini","w+");
     fwrite($file,0); 
     fclose($file);   
     return 0;
   }  else
   {
    $theData=0;  $the_count=0;    

    $file=fopen("cache_size.ini","r") or exit("Internal Cache Counting error!");
    if ($file) 
    { 
     $theData = fread($file, filesize("cache_size.ini")); 
     fclose($file);  
     $the_count=intval($theData)+intval($new_file_size);
    } else
    { echo "Could not retrieve new filesize from cache :S<br>"; }

    $file=fopen("cache_size.ini","w");
    if ($file) 
    {  
     fwrite($file, $the_count); 
     fclose($file);  
    } else 
    { echo "Could not add new filesize to cache :S<br>"; }

    return $the_count;
   }
 
  echo "Something Weird Happening , this function should return before reaching here :P ";
  return 0;
}

function remove_from_cache_size($new_file_size)
  {  
   //echo "Removing a new file of total ".$new_file_size." bytes ";
   if (!file_exists ("cache_size.ini"))
   {
     // AUTO GENERATION OF FILE :)
     echo "Auto Generation of file while adding to cache_size! :P ";
     $file=fopen("cache_size.ini","w+");
     fwrite($file,0); 
     fclose($file);   
     return 0;
   }  else
   {
    $theData=0;  $the_count=0;    

    $file=fopen("cache_size.ini","r") or exit("Internal Cache Counting error!");
    if ($file) 
    { 
     $theData = fread($file, filesize("cache_size.ini")); 
     fclose($file);  
     $the_count=intval($theData)-intval($new_file_size);
    } else
    { echo "Could not retrieve new filesize from cache :S<br>"; }

    $file=fopen("cache_size.ini","w");
    if ($file) 
    {  
     fwrite($file, $the_count); 
     fclose($file);  
    } else 
    { echo "Could not add new filesize to cache :S<br>"; }

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
     echo "Auto Generation of file while adding to cache_size! :P ";
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
   return 0;
 }

?>
