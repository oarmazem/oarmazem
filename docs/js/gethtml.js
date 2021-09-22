/*------------------------------------------------------------------------------------------------
                             Retorna tags para serem inseridas no <head>
-------------------------------------------------------------------------------------------------*/
function getHead() {

  return `<meta name="keywords" content="viagem turismo pousada hotel hospedagem antiguidades restaurante travel tourism hotel">
  <meta name="description" content="">`;

}//getHead()

/*------------------------------------------------------------------------------------------------
                             Retorna tags para serem inseridas no <header>
-------------------------------------------------------------------------------------------------*/
function getHeader() {

  return `<img id="logo" class="navClass0" src="images/logos/letters-logo.png" alt="logomarca">

  <nav id="menu">
    <nav class ="br" lang="pt-br">
      <ul>
        <li class="navClass0">INÍCIO</li>
        <li class="navClass1">O CAFÉ</li>
        <li class="navClass2">AS RELÍQUIAS</li>
        <li class="navClass3">COMO CHEGAR</li>    
        <li class="navClass4">CONTATO</li>
      </ul>      
    </nav>

    <nav class ="en" lang="en-us">
      <ul>
        <li class="navClass0">HOME</li>
        <li class="navClass1">COFEE</li>
        <li class="navClass2">RELICS</li>
        <li class="navClass3">MAP</li>    
        <li class="navClass4">CONTACT</li>
      </ul>      
    </nav>

    <nav class ="es" lang="es-es">
      <ul>
        <li class="navClass0">INICIO</li>
        <li class="navClass1">EL CAFÉ</li>
        <li class="navClass2">LAS RELIQUIAS</li>
        <li class="navClass3">¿CÓMO SE LLEGA?</li>    
        <li class="navClass4">CONTACTE</li>
      </ul>      
    </nav>

    <nav class ="fr" lang="fr-fr">
      <ul>
        <li class="navClass0">HOME</li>
        <li class="navClass1">LE CAFE</li>
        <li class="navClass2">LE RELIEF</li>
        <li class="navClass3">COMMENT S'Y RENDRE ?</li>    
        <li class="navClass4">CONTACTER</li>
      </ul>      
    </nav>
  </nav>`;

}//getHeader()

/*------------------------------------------------------------------------------------------------
                             Retorna tags para serem inseridas no <footer>
-------------------------------------------------------------------------------------------------*/
function getFooter() {

  return `<a href="https://www.instagram.com/armazem.cafe.reliquias/" target="_blank">
  <img src="images/social/instagram.png" alt="instagram">
</a>
<a href="#" target="_blank"> 
  <img src="images/social/whatsapp.png" alt="whatsapp">
</a>
<a href="https://www.facebook.com/armazem.cafe.reliquias/" target="_blank">
  <img src="images/social/facebook.png" alt="facebook">
</a>
<a href="mailto:cafereliquia@gmail.com" target="_blank">
  <img src="images/social/email.png" alt="mail">
</a>
<address>Rod. Salvador Pacetti 0000 Cunha-SP (21)97923-5720</address>
<img id="flag" onclick="toggleLanguage()" alt="translate">`; 

}//getFooter()

document.querySelector("header").innerHTML = getHeader();

document.querySelector("footer").innerHTML = getFooter();