<?php 

function header_bar()
{
  echo "<table width=192 height=128 style=\"position: absolute; top: 0px; left: 0px;\" >
          <tr>
            <td>
              <h2>MyLoader</h2>
              <a href=\"index.php\"><img src=\"images/link.png\"></a>
             </td> 
          </tr>
         </table>"; 
}

function keyboardjs()
{
    echo "<script>\n   
                       function goRandomMyLoader() 
                        {
                         var randomnumber=Math.floor(Math.random()*100000);
                         window.location.href = \"random.php?t=\"+randomnumber; 
    }\n 


  document.onkeypress = function (e)\n 
  {\n
    e = e || window.event;\n
    
    var keypressed=(e.keyCode || e.which);\n
    if (  keypressed == 114  ) //r
     {
      goRandomMyLoader();  
     }\n
  };\n
</script>\n"; 

}

?>
