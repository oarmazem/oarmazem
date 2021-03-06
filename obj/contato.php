<?php

require_once 'php/mysql.inc.php';

trace('16');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/contato.css" rel="stylesheet">
  
</head>

<body>

<header></header> 
  
<!----------------------------------------------------------------------------------------------- 
                            INICIO DA SECAO MAIN DA PAGINA   
------------------------------------------------------------------------------------------------>
<main>  
  
  <section class="quadro-de-cortica" style="height: 150rem;">

   
      <div class="postit yellow-postit" style="width: 40%; left: 5%; top: 5rem; transform: rotate(-1deg);">
        <div class="br" lang="pt-br">
          <p>Há muitas formas de entrar em contato.</p>
          <p>Fale com a gente:</p>
        </div>
        <div class="en" lang="en-us">
          <p>There are many ways to get in touch</p>
          <p>Talk to us:</p>
        </div>       
        <div class="es" lang="es-es">
          <p>Hay muchas maneras de ponerse en contacto</p>
          <p>Hable con nosostros:</p>
        </div>    
        <div class="fr" lang="fr-fr">
          <p>Il y a plusieurs façons de prendre contact.</p>
          <p>Parlez-nous:</p>
        </div>                   
        <p>&#x2709; oarmazem.contato@gmail.com</p>
        <p>&#x260F; +55 (11) 9 8415 6248</p>
        <p><a href="https://www.instagram.com/armazem.cafe.reliquias/" target="_blank"><img src="images/social/instagram.png" width="10%" alt="instagram"> Instagram </a></p>
        <p><a href="#" target="_blank"><img src="images/social/whatsapp.png" width="10%" alt="whatsapp"> Whatsapp</a></p>
        <p><a href="https://www.facebook.com/armazem.cafe.reliquias/" target="_blank"><img src="images/social/facebook.png" width="10%" alt="facebook"> Facebook </a></p>        
        <img class="right-pin" src="images/pins/lateral-black-pin.png" alt="pin">    
      </div>

      <figure style="width: 40%; left: 55%; top: 5rem;">
        <img class="foto" title="INÍCIO" data-color="blue-o" onclick="nav('index.php')" src="images/photos/fachada.jpg" alt="fachada">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure>

      <figure style="width: 40%; left: 5%; top: 35rem;"> 
        <img class="foto" title="COMO CHEGAR" data-color="orange-m" onclick="nav('mapa.php')" src="images/photos/placa.jpg" alt="letreiro">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure>

      <div class="postit orange-postit" style="width: 30%; left: 55%; top: 25rem; transform: rotate(3deg);">
        <div class="br" lang="pt-br">
          <p>Aberto de 9hs às 18hs</p>
          <p>&#x260F; (11)98415 6248</p>
          <p>Cunha - SP</p>
        </div>
        <div class="en" lang="en-us">
          <p>Open from 9am to 6pm</p>
          <p>&#x260F; +55 (11)98415 6248</p>
          <p>Cunha - SP - Brazil</p>
        </div>
        <div class="es" lang="es-es">
          <p>Abierto desde 9h a 18h</p>
          <p>&#x260F; +55 (11)98415 6248</p>
          <p>Cunha - SP - Brasil</p>
        </div>
        <div class="fr" lang="fr-fr">
          <p>Ouvert du 9 h à 18 h</p>
          <p>&#x260F; +55 (11)98415 6248</p>
          <p>Cunha - SP - Brésil</p>          
        </div>
        <img class="left-pin" src="images/pins/lateral-black-pin.png" alt="pin">
      </div><!--postii-->
 
      <figure style="width: 30%; left: 55%; top: 36rem; transform: rotate(-1deg);">
        <img class="foto" title="AS RELÍQUIAS" data-color="green-r" onclick="nav('_reliquias.php?type=11')" src="images/photos/lamparina.jpg" alt="Lamparina">
        <img class="center-pin" src="images/pins/center-green-pin.png" alt="pin">
      </figure>      

      <figure style="width: 35%; left: 10%; top: 80rem;">
        <img class="foto"  title="O CAFÉ" data-color="red-a" onclick="nav('cafes.php')" src="images/photos/cafe-com-bolo2.jpg" alt="cafe com bolo">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure> 

      <div class="postit brown-postit" style="width: 30%; left: 55%; top: 86rem; transform: rotate(3deg);">
        <div class="br" lang="pt-br">
        <h2>Dizeres</h2>
        <p>Um espaço para Márcia dizer dizeres que aqui ficarão ditos.</p>
        </div>
        <div class="en" lang="en-us">
        <h2>Some Words</h2>
        <p>Spot for Marcia to say things that will be said here.</p>
        </div>       
        <div class="es" lang="es-es">
        <h2>Algunas palabras</h2>
        <p>Espacio para que Marcia diga cosas que acá estarán dichas.</p>
        </div>    
        <div class="fr" lang="fr-fr">
        <h2>Dictons</h2>
        <p>Espace pour que Marcia puisse dire des choses seront dites ici.</p>
        </div>  
        <img class="right-pin" src="images/pins/lateral-black-pin.png" alt="pin">                            
      </div><!--postit-->  
 
      <figure style="width: 40%; left: 5%; top: 116rem;"> 
        <img class="foto" src="images/photos/antigo-armazem.jpg" alt="antigo armazém">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure>      
  
      <figure style="width: 20%; left: 45%; top: 96rem;"> 
        <img class="foto" src="images/photos/fachada2.jpg" alt="fachada">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure>      

      <figure style="width: 30%; left: 68%; top: 98rem;"> 
        <img class="foto" src="images/photos/cachorro.jpg" alt="cachorro">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
        <figcaption>
          <p class="br" lang="pt-br">Eu sou o Banzé.</p>
          <p class="en" lang="en-us">I am Banzé.</p>    
          <p class="es" lang="es-es">Yo soy Banzé.</p>   
          <p class="fr" lang="fr-fr">Je suis Banzé.</p>                      
        </figcaption>        
      </figure>
  
      <div class="postit blue-postit" style="width: 30%; left: 12%; top: 136rem; transform: rotate(3deg);">
        <div class="br" lang="pt-br">
          <h2>O "antes" de O Armazém</h2>  
          <p>Era assim quando alugamos. Uma vendinha que foi fechada em 1998.</p>
        </div>
        <div class="en" lang="en-us">
          <h2>The "before" of the O Armazém</h2>
          <p>It was like this when we rented it. A little shop that was closed in 1998.</p>
        </div>       
        <div class="es" lang="es-es">
          <h2>El "antes" del O Armazém</h2>
          <p>Estaba así cuando lo alquilamos. Una pequeña tienda que se cerró en 1998.</p>
        </div>    
        <div class="fr" lang="fr-fr">
          <h2>Le "avant" de O Armazém</h2>
          <p>C'était comme ça quand on l'a loué. Une petite boutique qui a été fermée en 1998.</p>
        </div>  
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">                            
      </div><!--postit-->   

      <figure style="width: 30%; left: 55%; top: 126rem;" > 
        <img class="foto" src="images/photos/pinoquio.jpg" alt="pinóquio">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure>     
    
  </section><!--quadro-de-cortica-->

</main>
<!----------------------------------------------------------------------------------------------- 
                              FIM DA SECAO MAIN DA PAGINA   
------------------------------------------------------------------------------------------------>  

<img id="chest" src="images/close-chest.png" onclick="nav('_reliquias.php?type=11')"> 

<a href="#logo"><img id="upward" title="" src="images/upward-arrow.png"></a> 

<footer></footer>

<script src="js/gethtml.js"></script>
<script src="js/erase-banner.js"></script>
<script src="js/main.js"></script>
<script>initialize("contato.php");</script>

</body>

</html>