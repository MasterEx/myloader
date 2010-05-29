<?php


function ExtentionIsExecutable($ext)
{
  if ( ( $ext == "exe" )||
       ( $ext == "scr" )||
       ( $ext == "bat" )
     ) return 1;
  return 0;
}

function ExtentionIsImage($ext)
{
  if ( ( $ext == "png" )||
       ( $ext == "gif" )||
       ( $ext == "jpg" )||
       ( $ext == "jpeg" )
     ) return 1;
  return 0;
}

function PrintFileInBox($weblink,$filename,$ext)
{
  if ( ExtentionIsImage($ext)==1 )
            {
                 echo "<a href=\"".$weblink."\">";
                 echo "<img src=\"".$weblink."\" width=\"70%\">";
                 echo "</a><br><br>";
                 
                 echo "<a href=\"".$weblink."\">";
                 echo $filename;
                 echo "</a><br><br>";
            
            } else
            {
                 echo "If you want you can download the file by clicking its link..";
                 echo "<br>Only png/gif/jpg/jpeg files will be embedded to this page for fast viewing :)<br><br>";

                 echo "<a href=\"".$weblink."\">";
                 echo "<img src=\"images/logo.png\">";
                 echo "</a><br><br>";

                 echo "<a href=\"".$weblink."\">";
                 echo $filename;
                 echo "</a><br><br>"; 
            }
 
}


?>
