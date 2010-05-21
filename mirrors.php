<?php
  require("configuration.php");
  if 
  ( $ENABLE_MIRROR_LINK == 1 ) 
   
  {
 
  echo "
         <html>  
          <head>
             <title>MyLoader mirrors</title>
          </head>
          <body>
            <h2>MyLoader other servers : </h2><br><hr>
                <a href=\"http://periklis.is-a-geek.com/myloader\">http://periklis.is-a-geek.com/myloader</a><br>
                <a href=\"http://ammarkov.ath.cx/myloader/\">http://ammarkov.ath.cx/myloader/</a><br>
                <a href=\"http://c00kiemon5ter.ath.cx/myloader/\">http://c00kiemon5ter.ath.cx/myloader/</a><br>
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
            <a href=\"index.php\">Click here to go to MyLoader</a> 
          </body>
        </html>
       ";
  
  }
?>
