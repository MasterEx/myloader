<?php

/* THE MESSAGES CAN BE IMPROVED BUT SHOULD NOT TAKE MORE THAN 10 lines each in the php file*/
function refuse_withoutcompression()
{
  echo "<html><body> 
          <h2>Please dont send uncompressed images :P</h2>
          I refuse to waste good bandwidth to upload this file..
         </body></html>"; 
}

function link_not_found()
{
  echo "<html><body> 
          <h2>Could not find file / File Expired ?</h2>
          Your link is invalid , or maybe the file expired..
         </body></html>"; 
}

$path = $SCRIPT_WEB_BASE."/uploads/";
$fullPath = $path.$_GET['i'];
 
if ($fd = fopen ($fullPath, "r")) 
{
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) 
    {
        case "pdf":
        header("Content-type: application/pdf"); // add here more headers for diff. extensions
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
        break;
        case "png":
        header("Content-type: image/png"); // add here more headers for diff. extensions    
        break;     
        case "gif":
        header("Content-type: image/gif"); // add here more headers for diff. extensions         
        break;
        case "jpg":
        header("Content-type: image/jpg"); // add here more headers for diff. extensions         
        break;
        case "jpeg":
        header("Content-type: image/jpg"); // add here more headers for diff. extensions         
        break;
        case "bmp":
         refuse_withoutcompression();
        exit;      
        break;
        default;
        header("Content-type: application/octet-stream"); 
    }
    $filename_parts= explode("-",$path_parts["basename"],2);
    $hash_part=$filename_parts[0];
    $filename_part=$filename_parts[1];
    
    header("Content-Disposition: filename=\"".$filename_part."\"");
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
 fclose ($fd);
} else
{ 
   link_not_found();
}
exit; 
?>
