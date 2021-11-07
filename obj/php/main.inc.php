<?php declare(strict_types=1);

/*[01]--------------------------------------------------------------------------------------------
*                              Escreve uma mensagem na pagina.
*-----------------------------------------------------------------------------------------------*/
function echoMsg(
  string $msg, 
  string $css = 'text-align: center; font-size: 1.3vw; color: black;'  
) {

  echo '<br><p style="' . $css . '">' . $msg . '</p>';

}//echoMsg()

?>