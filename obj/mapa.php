<?php

require_once 'php/mysql.inc.php';

trace('15');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/mapa.css" rel="stylesheet">

</head>

<body>

<header></header>  

<!----------------------------------------------------------------------------------------------- 
                            INICIO DA SECAO MAIN DA PAGINA   
------------------------------------------------------------------------------------------------>
<main>

  <section class="quadro-de-cortica" style="height: 100rem;">

      <figure style="width: 30%; left: 5%; top: 5rem;">
        <img class="foto" title="INÍCIO" data-color="blue-o" onclick="nav('index.php')" src="images/photos/fachada.jpg" alt="chá">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure>

      <div class="postit yellow-postit" style="width: 35%; left: 5%; top: 23rem; transform: rotate(-2deg);">
      <div class="br" lang="pt-br">
        <p>Estamos localizados à Rodovia Salvador Pacetti Km 64,3</p>
        <p>Cunha - SP</p>
      </div>
      <div class="en" lang="en-us"> 
        <p>We are located at Rodovia Salvador Pacetti Km 64.3</p>
        <p>Cunha - SP - Brazil</p>
      </div>
      <div class="es" lang="es-es">
        <p>Nos encontramos en Rodovia Salvador Pacetti Km 64,3</p>
        <p>Cunha - SP - Brasil</p>
      </div>
      <div class="fr" lang="fr-fr">
        <p>Nous sommes situés à Rodovia Salvador Pacetti Km 64,3</p>
        <p>Cunha - SP - Brésil</p>
      </div>
      <img class="right-pin" src="images/pins/lateral-black-pin.png" alt="pin">    
      </div><!--postit-->

      <div id="map" style="width: 49%; left: 43%; top: 3rem;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1005.5069648625276!2d-44.87624637079542!3d-23.150192099055516!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9d7d6b91c862ff%3A0xcb3f7852868cf5fb!2zTyBBcm1hesOpbSBDYWbDqSBlIFJlbMOtcXVpYXM!5e1!3m2!1spt-BR!2sbr!4v1637394246969!5m2!1spt-BR!2sbr" allowfullscreen="" loading="lazy"></iframe>
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">    
      </div>

      <figure style="width: 29%; left: 5%; top: 33rem;">
        <img class="foto" title="AS RELÍQUIAS" data-color="green-r" onclick="nav('_reliquias.php?type=11')" src="images/photos/lamparina.jpg" alt="Lamparina">
        <img class="center-pin" src="images/pins/center-green-pin.png" alt="pin">
      </figure>      

      <figure style="width: 25%; left: 45%; top: 29em;">
        <img class="foto" title="CONTATO" data-color="green-a" onclick="nav('contato.php')" src="images/photos/telefone-antigo.jpg" alt="telefone antigo">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure>      

      <figure style="width: 20%; left: 75%; top: 31rem;">
        <img class="foto"  title="O CAFÉ" data-color="red-a" onclick="nav('cafes.php')" src="images/photos/cafe-com-bolo2.jpg" alt="cafe com bolo">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure> 

      <figure style="width: 30%; left: 37%; top: 59rem;" > 
        <img class="foto" src="images/photos/cristaleira.jpg" alt="cristaleira">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure>
  
      <figure style="width: 30%; left: 68%; top: 56rem;"> 
        <img class="foto" src="images/photos/antigo-armazem2.jpg" alt="antigo armazém">
        <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      </figure>

      <figure style="width: 24%; left: 75%; top: 76rem;"> 
        <img class="foto" src="images/photos/brinquedo.jpg" alt="brinquedo">
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
<script>initialize("mapa.php");</script>

</body>

</html>