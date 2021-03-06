<?php

require_once 'php/mysql.inc.php';

trace('1');

?>
<!DOCTYPE html>
<html lang="pt-br">
  
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/index.css" rel="stylesheet">

</head>

<body>

<header></header>

<!----------------------------------------------------------------------------------------------- 
                            INICIO DA SECAO MAIN DA PAGINA   
------------------------------------------------------------------------------------------------>
<main>
  
  <section class="quadro-de-cortica" style="height: 237rem;">
 
    <figure style="width: 80%; left: 3%; top: 2rem;">
      <img class="foto" src="images/photos/fachada.jpg" alt="fachada">
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
    </figure>

    <figure style="width: 30%; right: 3%; top: 4rem;">
      <img class="foto" src="images/photos/antigo-armazem2.jpg" alt="antigo armazém">
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
    </figure>

    <div class="postit brown-postit" style="width: 30%; right: 0; top: 21rem; transform: rotate(0deg);">
      <div class="br" lang="pt-br">
        <h2>Como tudo começou</h2>
        <p>Dois amigos: ele carioca, ela paulista.</p>
        <p>Ele já não queria mais morar no Rio.</p>
        <p>Ela não queria mais viver em São Paulo.</p>
        <p>Ele queria o mar e ela a montanha.</p>
        <p>Entre o Rio e São Paulo,</p>
        <p>Na montanha perto do mar.</p>
        <p>O lugar perfeito para viver. Para ser feliz.</p>
        <p>E para te receber.</p>
      </div>
      <div class="en" lang="en-us">
        <h2>How it came about</h2>
        <p>Two friends: he from Rio de Janeiro,</p>
        <p>she from São Paulo.</p>
        <p>He didn't want to live in Rio anymore.</p>
        <p>She didn't want to live in São Paulo anymore.</p>
        <p>He wanted the sea and she wanted the mountain.</p>
        <p>Between Rio and São Paulo,</p>
        <p>In the mountain near the sea.</p>
        <p>The perfect place to live. To be happy.</p>
        <p>And to welcome you.</p>
      </div>
      <div class="es" lang="es-es">
        <h2>Cómo empezó todo</h2>
        <p>Dos amigos: él de Río de Janeiro,</p>
        <p>ella de São Paulo.</p>
        <p>No quería seguir viviendo en Río.</p>
        <p>No quería seguir viviendo en São Paulo.</p>
        <p>Él quería el mar y ella la montaña.</p>
        <p>Entre Río y São Paulo,</p>
        <p>En la montaña junto al mar.</p>
        <p>El lugar perfecto para vivir. Para ser feliz.</p>
        <p>Y para darle la bienvenida.</p>
      </div>
      <div class="fr" lang="fr-fr">
        <h2>Comment tout a commencé</h2>
        <p>Deux amis : lui de Rio de Janeiro,</p>
        <p>elle de São Paulo.</p>
        <p>Il ne voulait plus vivre à Rio.</p>
        <p>Elle ne voulait plus vivre à São Paulo.</p>
        <p>Il voulait la mer et elle voulait la montagne.</p>
        <p>Entre Rio et São Paulo,</p>
        <p>Dans la montagne au bord de la mer.</p>
        <p>L'endroit idéal pour vivre. Pour être heureux.</p>
        <p>Et pour vous souhaiter la bienvenue.</p>
      </div>
      <img style="width: 60%; height: auto;" src="images/logos/brown-letters-logo.png" alt="logomarca">
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
    </div><!--postit-->   

    <figure style="width: 40%; left: 8%; top: 54rem;" >
      <img class="foto" src="images/photos/salao-oarmazem.jpg" alt="salão do armazém">
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">  
    </figure>

    <figure style="width: 40%; left: 55%; top: 63rem; transform: rotate(2deg);">
      <img class="foto" src="images/photos/mesas.jpg" alt="mesas de refeição"> 
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      <figcaption>
        <p class="br" lang="pt-br">No Armazém, sua memória afetiva experimenta uma viagem sensorial</p>
        <p class="en" lang="en-us">At Armazém, your affective memory experiences a sensorial journey</p>
        <p class="es" lang="es-es">En el Armazém, tu memoria afectiva experimenta un viaje sensorial</p>
        <p class="fr" lang="fr-fr">Dans Armazém, votre mémoire affective fait l'expérience d'un voyage sensoriel</p>
      </figcaption>          
    </figure>    

    <figure style="width: 30%; left: 6%; top: 86rem;">
      <img class="foto" title="O CAFÉ" data-color="red-a" onclick="nav('cafes.php')" src="images/photos/cafe-com-bolo.jpg" alt="café com bolo">
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      <figcaption onclick="nav('cafes.php')">
        <p class="br" lang="pt-br">Isso é café de verdade!</p>
        <p class="en" lang="en-us">This is real coffee!</p>
        <p class="es" lang="es-es">Este és café de verdad!</p>
        <p class="fr" lang="fr-fr">C'est un vrai café!</p>
      </figcaption>
    </figure>

    <div class="postit orange-postit" style="width: 30%; left: 5%; top: 118rem; transform: rotate(1deg);">
      <div class="br" lang="pt-br">
        <p>No fim de tarde...</p>
        <p>Café feito na hora e bolo de vó para acompanhar uma boa prosa.</p>
      </div>
      <div class="en" lang="en-us">
        <p>In the late afternoon...</p>
        <p>Freshly brewed coffee and grandma's cake to accompany a good conversation.</p>
      </div>
      <div class="es" lang="es-es">
        <p>Al final de la tarde...</p>
        <p>Café recién hecho y pastel de la abuela para acompañar una buena prosa.</p>
      </div>
      <div class="fr" lang="fr-fr">
        <p>En fin d'après-midi...</p>
        <p>Café fraîchement préparé et gâteau de grand-mère pour accompagner une bonne conversation.</p>
      </div>
      <img class="left-pin" src="images/pins/lateral-black-pin.png" alt="pin">
    </div><!--postit-->

    <div class="postit blue-postit" style="width: 45%; left: 45%; top: 91rem;">
      <div lang="es">
        <h2>Reliquias</h2>
        <p>
          El hemisferio austral. Bajo su álgebra
          de estrellas ignoradas por Ulises,
          un hombre busca y seguirá buscando
          las reliquias de aquella epifanía
          que le fue dada, hace ya tantos años,
          del otro lado de una numerada puerta de hotel,
          junto al perpetuo Támesis,
          que fluye como fluye ese otro río,
          el tenue tiempo elemental. La carne
          olvida sus pesares y sus dichas.
          El hombre espera y sueña. Vagamente
          rescata unas triviales circunstancias.
          Un nombre de mujer, una blancura,
          un cuerpo ya sin cara, la penumbra
          de una tarde sin fecha, la llovizna,
          unas flores de cera sobre un mármol
          y las paredes, color rosa pálido.
        </p>
        <pre>
          J.L.Borges
        </pre>
      </div>
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
    </div><!--postit--> 

    <figure style="width: 30%; left: 5%; top: 136rem;">
      <img class="foto" title="AS RELÍQUIAS" data-color="green-r" onclick="nav('_reliquias.php?type=11')" src="images/photos/cha.jpg" alt="chá">
      <img class="center-pin" src="images/pins/center-green-pin.png" alt="pin">
    </figure>

    <figure style="width: 30%; left: 37%; top: 138rem;">
      <img class="foto" title="CONTATO" data-color="green-a" class="foto" onclick="nav('contato.php')" src="images/photos/telefone.jpg" alt="telefone"> 
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
    </figure>   

    <figure style="width: 30%; left: 69%; top: 138rem;">
      <img class="foto" src="images/photos/carrinho.jpg" alt="porsche"> 
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
      <figcaption>
        <p class="br" lang="pt-br">É um porsche!</p>
        <p class="en" lang="en-us">It's a porsche!</p>
        <p class="es" lang="es-es">Es un porsche!</p>
        <p class="fr" lang="fr-fr">C'est une Porsche!</p>
      </figcaption>
    </figure>

    <figure style="width: 30%; left: 69%; top: 158rem;">
      <img class="foto" src="images/photos/triciclo.jpg" alt="triciclo"> 
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
    </figure>   

    <figure style="width: 49%; left: 8%; top: 172rem;">
      <img class="foto" src="images/photos/vaso.jpg" alt="vaso"> 
      <img class="center-pin" src="images/pins/center-green-pin.png" alt="pin">
    </figure>    
  
    <figure style="width: 30%; left: 63%; top: 192rem;"> 
      <img class="foto" title="COMO CHEGAR" data-color="orange-m" onclick="nav('mapa.php')" src="images/photos/placa.jpg" alt="letreiro">
      <img class="center-pin" src="images/pins/center-black-pin.png" alt="pin">
    </figure>

    <div class="postit orange-postit" style="width: 30%; right: 7%; top: 224rem; transform: rotate(2deg);">
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
<script>initialize("index.php");</script>

</body>

</html>