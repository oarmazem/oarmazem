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
      <li onclick="nav('cafes.php')">O CAFÉ</li>
      <li class="submenu">
        AS RELÍQUIAS
        <ul>
          <li onclick="nav('_reliquias.php?type=1')">Louças e Porcelanas</li>
          <li onclick="nav('_reliquias.php?type=2')">Jarras, Copos e Taças</li>          
          <li onclick="nav('_reliquias.php?type=3')">Talheres</li>
          <li onclick="nav('_reliquias.php?type=4')">Decoração e Arte</li>
          <li onclick="nav('_reliquias.php?type=5')">Livros</li>  
          <li onclick="nav('_reliquias.php?type=6')">Miniaturas e Coleções</li>                  
          <li onclick="nav('_reliquias.php?type=7')">Brinquedos</li>
          <!--li onclick="nav('_reliquias.php?type=8')">Vestuário e Adereços</li-->          
          <li onclick="nav('_reliquias.php?type=9')">Máquinas, Ferramentas, Aparelhos</li>
          <li onclick="nav('_reliquias.php?type=10')">Curiosidades</li>  
          <!--li onclick="nav('_reliquias.php?type=11')">Do Fundo do Baú</li-->            
          <li onclick="nav('_reliquias.php?type=12')">Mais relíquias...</li>          
        </ul>        
      </li>
      <li onclick="nav('mapa.html')">COMO CHEGAR</li>    
      <li onclick="nav('contato.html')">CONTATO</li>
    </ul>      
  
    <ul class="en" lang="en-us">
      <li onclick="nav('index.html')">HOME</li>
      <li onclick="nav('cafes.php')">COFFEE</li>
      <li class="submenu">
        RELICS
        <ul>
          <li onclick="nav('_reliquias.php?type=1')">Crockery</li>
          <li onclick="nav('_reliquias.php?type=2')">Jugs and Glasses</li>          
          <li onclick="nav('_reliquias.php?type=3')">Cutlery</li>
          <li onclick="nav('_reliquias.php?type=4')">Decoration and Art</li>
          <li onclick="nav('_reliquias.php?type=5')">Books</li>
          <li onclick="nav('_reliquias.php?type=6')">Miniatures and Collections</li>
          <li onclick="nav('_reliquias.php?type=7')">Toys</li>
          <!--li onclick="nav('_reliquias.php?type=8')">Clothing</li-->
          <li onclick="nav('_reliquias.php?type=9')">Machines, Tools, Eletronics</li>
          <li onclick="nav('_reliquias.php?type=10')">Oddities</li>
          <!--li onclick="nav('_reliquias.php?type=11')">Dredge up</li-->   
          <li onclick="nav('_reliquias.php?type=12')">More...</li>          
        </ul>           
      </li>
      <li onclick="nav('mapa.html')">MAP</li>    
      <li onclick="nav('contato.html')">CONTACT</li>
    </ul>      

    <ul class="es" lang="es-es">
      <li onclick="nav('index.html')">INICIO</li>
      <li onclick="nav('cafes.php')">EL CAFÉ</li>
      <li class="submenu">
        LAS RELIQUIAS
        <ul>
          <li onclick="nav('_reliquias.php?type=1')">Vajillas y Porcelanas</li>
          <li onclick="nav('_reliquias.php?type=2')">Jarras, Vasos y Copas</li>          
          <li onclick="nav('_reliquias.php?type=3')">Cubiertos</li>
          <li onclick="nav('_reliquias.php?type=4')">Decoración y Arte</li>
          <li onclick="nav('_reliquias.php?type=5')">Libros</li>  
          <li onclick="nav('_reliquias.php?type=6')">Miniaturas y Coleccionables</li>                  
          <li onclick="nav('_reliquias.php?type=7')">Juguetes</li>
          <!--li onclick="nav('_reliquias.php?type=8')">Ropas</li-->          
          <li onclick="nav('_reliquias.php?type=9')">Máquinas y Herramientas</li>
          <li onclick="nav('_reliquias.php?type=10')">Curiosidades</li>
          <!--li onclick="nav('_reliquias.php?type=11')">¿Te acuerdas de eso?</li-->             
          <li onclick="nav('_reliquias.php?type=12')">Mas reliquias...</li>           
        </ul>           
      </li>
      <li onclick="nav('mapa.html')">¿CÓMO SE LLEGA?</li>    
      <li onclick="nav('contato.html')">CONTACTE</li>
    </ul>      

    <ul class="fr" lang="fr-fr">
      <li onclick="nav('index.html')">HOME</li>
      <li onclick="nav('cafes.php')">LE CAFE</li>
      <li class="submenu">
        LE RELIEF
        <ul>
          <li onclick="nav('_reliquias.php?type=1')">Vaisselle et porcelaine</li>
          <li onclick="nav('_reliquias.php?type=2')">Pichets, tasses et gobelets</li>          
          <li onclick="nav('_reliquias.php?type=3')">Couverts</li>
          <li onclick="nav('_reliquias.php?type=4')">Art et Decor</li>
          <li onclick="nav('_reliquias.php?type=5')">Livres</li>  
          <li onclick="nav('_reliquias.php?type=6')">Miniatures et objets de collection</li>                  
          <li onclick="nav('_reliquias.php?type=7')">Jouets</li>
          <!--li onclick="nav('_reliquias.php?type='8)">Vêtements</li-->          
          <li onclick="nav('_reliquias.php?type=9')">Machines et outils</li>
          <li onclick="nav('_reliquias.php?type=10')">Curiosités</li>  
          <!--li onclick="nav('_reliquias.php?type=11')">Vous vous en souvenez?</li-->          
          <li onclick="nav('_reliquias.php?type=12')">Plus de reliques...</li>           
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