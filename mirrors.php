<?php
  require("configuration.php");
  if 
  ( $ENABLE_MIRROR_LINK == 1 ) 
   
  {
 
  echo "
         <html>  
          <head>
             <title>MyUploads mirrors</title>
          </head>
          <body>
            <h2>My Uploads mirror servers : </h2><br><hr>
                <a href=\"http://periklis.is-a-geek.com/myloader\">http://periklis.is-a-geek.com/myloader</a><br>
                <a href=\"http://ammarkov.ath.cx/uploads/\">http://ammarkov.ath.cx/uploads/</a><br>
                <hr>
          </body>
        </html>
       ";

  } else

  {
     echo "
         <html>   
          <body>
            <h2>Mirroring is disabled!</h2><br>
            <a href=\"index.php\">Click here to go to the main site</a> 
          </body>
        </html>
       ";
  
  }
?>
