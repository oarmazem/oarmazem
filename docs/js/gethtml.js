/*------------------------------------------------------------------------------------------------
                             Retorna tags para serem inseridas no <head>
-------------------------------------------------------------------------------------------------*/
function getHead() {

  return `
  <meta name="keywords" content="viagem turismo pousada hotel hospedagem antiguidades restaurante travel tourism hotel">
  <meta name="description" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <title>O Armazém Café & Relíquias</title>`;

}//getHead()

/*------------------------------------------------------------------------------------------------
                             Retorna tags para serem inseridas no <header>
-------------------------------------------------------------------------------------------------*/
function getHeader() {

  return `
  <h1><img id="logo" onclick="nav('index.html')" src="images/logos/letters-logo.png" alt="logomarca"></h1>

  <nav id="menu">
    <ul class="br" lang="pt-br">
      <li onclick="nav('index.html')">INÍCIO</li>
      <li class="submenu">
        O CAFÉ
        <ul>
          <li onclick="nav('cafe.html')">Tortas</li>
          <li onclick="nav('cafe.html')">Bolos</li>
          <li onclick="nav('cafe.html')">Cafés</li>
          <li onclick="nav('cafe.html')">Presuntos</li>
        </ul>
      </li>
      <li class="submenu">
        AS RELÍQUIAS
        <ul>
          <li onclick="nav('reliquias.html')">Louças</li>
          <li onclick="nav('reliquias.html')">Talheres</li>
          <li onclick="nav('reliquias.html')">Decoração e Arte</li>
          <li onclick="nav('reliquias.html')">Brinquedos</li>
          <li onclick="nav('reliquias.html')">Máquinas, Ferramentas, Aparelhos</li>
          <li onclick="nav('reliquias.html')">Mais relíquias...</li>          
        </ul>        
      </li>
      <li onclick="nav('mapa.html')">COMO CHEGAR</li>    
      <li onclick="nav('contato.html')">CONTATO</li>
    </ul>      
  
    <ul class="en" lang="en-us">
      <li onclick="nav('index.html')">HOME</li>
      <li class="submenu">
        COFFEE
        <ul>
          <li onclick="nav('cafe.html')">Pies</li>
          <li onclick="nav('cafe.html')">Cakes</li>
          <li onclick="nav('cafe.html')">Coffees</li>
          <li onclick="nav('cafe.html')">Ham</li>
        </ul>        
      </li>
      <li class="submenu">
        RELICS
        <ul>
          <li onclick="nav('reliquias.html')">Crockery</li>
          <li onclick="nav('reliquias.html')">Cutlery</li>
          <li onclick="nav('reliquias.html')">Decoration and Art</li>
          <li onclick="nav('reliquias.html')">Toys</li>
          <li onclick="nav('reliquias.html')">Machines, Tools, Eletronics</li>
          <li onclick="nav('reliquias.html')">More...</li>          
        </ul>           
      </li>
      <li onclick="nav('mapa.html')">MAP</li>    
      <li onclick="nav('contato.html')">CONTACT</li>
    </ul>      

    <ul class="es" lang="es-es">
      <li onclick="nav('index.html')">INICIO</li>
      <li class="submenu">
        EL CAFÉ
        <ul>
          <li onclick="nav('cafe.html')">Tartas</li>
          <li onclick="nav('cafe.html')">Pastelería</li>
          <li onclick="nav('cafe.html')">Cafés</li>
          <li onclick="nav('cafe.html')">Jamones</li>
        </ul>        
      </li>
      <li class="submenu">
        LAS RELIQUIAS
        <ul>
          <li onclick="nav('reliquias.html')">Vajillas</li>
          <li onclick="nav('reliquias.html')">Cubiertos</li>
          <li onclick="nav('reliquias.html')">Decoración y Arte</li>
          <li onclick="nav('reliquias.html')">Juguetes</li>
          <li onclick="nav('reliquias.html')">Máquinas, herramientas, aparatos</li>
          <li onclick="nav('reliquias.html')">Más reliquias...</li>          
        </ul>           
      </li>
      <li onclick="nav('mapa.html')">¿CÓMO SE LLEGA?</li>    
      <li onclick="nav('contato.html')">CONTACTE</li>
    </ul>      

    <ul class="fr" lang="fr-fr">
      <li onclick="nav('index.html')">HOME</li>
      <li class="submenu">
        LE CAFE
        <ul>
          <li onclick="nav('cafe.html')">Tartes</li>
          <li onclick="nav('cafe.html')">Gâteaux</li>
          <li onclick="nav('cafe.html')">Cafés</li>
          <li onclick="nav('cafe.html')">Hams</li>
        </ul>        
      </li>
      <li class="submenu">
        LE RELIEF
        <ul>
          <li onclick="nav('reliquias.html')">Vaisselle</li>
          <li onclick="nav('reliquias.html')">Couverts</li>
          <li onclick="nav('reliquias.html')">Décoration et art</li>
          <li onclick="nav('reliquias.html')">Jouets</li>
          <li onclick="nav('reliquias.html')">Machines, outils, appareils</li>
          <li onclick="nav('reliquias.html')">Plus de reliques...</li>          
        </ul>           
      </li>
      <li onclick="nav('mapa.html')">COMMENT S'Y RENDRE ?</li>    
      <li onclick="nav('contato.html')">CONTACTER</li>
    </ul>      
  </nav>`;

}//getHeader()

/*------------------------------------------------------------------------------------------------
                             Retorna tags para serem inseridas no <footer>
-------------------------------------------------------------------------------------------------*/
function getFooter() {

  return `
<div class="box1">
<a href="https://www.instagram.com/armazem.cafe.reliquias/" target="_blank"><img src="images/social/instagram.png" alt="instagram"></a>
<a href="#" target="_blank"><img src="images/social/whatsapp.png" alt="whatsapp"></a>
<a href="https://www.facebook.com/armazem.cafe.reliquias/" target="_blank"><img src="images/social/facebook.png" alt="facebook"></a>
<a href="mailto:oarmazem.contato@gmail.com" target="_blank"><img src="images/social/email.png" alt="mail"></a>
</div>
<div class="box2">
<address>Rod. Salvador Pacetti Km 64 Cunha-SP (11)98415-6248</address>
</div>
<div class="box3">
<img id="flag" onclick="toggleLanguage()" alt="translate">
</div>`; 

}//getFooter()

document.querySelector("head").innerHTML += getHead(); 

document.querySelector("header").innerHTML = getHeader();

document.querySelector("footer").innerHTML = getFooter();