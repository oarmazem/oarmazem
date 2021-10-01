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
  <h1><img id="logo" onclick="nav(0)" src="images/logos/letters-logo.png" alt="logomarca"></h1>

  <nav id="menu">
    <nav class="br" lang="pt-br">
      <ul>
        <li onclick="nav(0)">INÍCIO</li>
        <li onclick="nav(1)">O CAFÉ</li>
        <li onclick="nav(2)">AS RELÍQUIAS</li>
        <li onclick="nav(3)">COMO CHEGAR</li>    
        <li onclick="nav(4)">CONTATO</li>
      </ul>      
    </nav>

    <nav class="en" lang="en-us">
      <ul>
        <li onclick="nav(0)">HOME</li>
        <li onclick="nav(1)">COFFEE</li>
        <li onclick="nav(2)">RELICS</li>
        <li onclick="nav(3)">MAP</li>    
        <li onclick="nav(4)">CONTACT</li>
      </ul>      
    </nav>

    <nav class="es" lang="es-es">
      <ul>
        <li onclick="nav(0)">INICIO</li>
        <li onclick="nav(1)">EL CAFÉ</li>
        <li onclick="nav(2)">LAS RELIQUIAS</li>
        <li onclick="nav(3)">¿CÓMO SE LLEGA?</li>    
        <li onclick="nav(4)">CONTACTE</li>
      </ul>      
    </nav>

    <nav class="fr" lang="fr-fr">
      <ul>
        <li onclick="nav(0)">HOME</li>
        <li onclick="nav(1)">LE CAFE</li>
        <li onclick="nav(2)">LE RELIEF</li>
        <li onclick="nav(3)">COMMENT S'Y RENDRE ?</li>    
        <li onclick="nav(4)">CONTACTER</li>
      </ul>      
    </nav>
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