//O site abre em Portugues
const PORTUGUESE = 0;

/*
  Siglas dos idiomas do site

  Cada sigla destas corresponde ao class da tag que exibe texto neste idioma.
  Uma div, por exemplo, contendo todos os paragrafos em Portugues, teria class="br"                      
*/
const LANGUAGES = [
  { initials: "br", tooltips: "Traduzir para Português" },
  { initials: "en", tooltips: "Translate to English" },
  { initials: "es", tooltips: "Traducion para Español" },
  { initials: "fr", tooltips: "Traduire en Français" }
];

//Referencia apontando para a tag img que carrega icone de traducao
const FLAG = document.getElementById("flag");

/*
Cores das secoes associadas as cores do letreiro
  "#2C459C",
  "#EE3539",
  "#19B060",
  "#F58637",
  "#0FB99B",
  "#4F2C72",
  "#1597D5",
  "#A82F82"
*/

//Os arquivos dos frames de cada secao do menu e as respectivas cores
const SECTIONS_COLORS = {
  "index.php" : "#2C459C",
  "cafes.php" :  "#EE3539" ,
  "mapa.php" : "#F58637",
  "contato.php" : "#0FB99B",
  "_reliquias.php?type=1" : "#19B060",
  "_reliquias.php?type=2" : "#19B060",
  "_reliquias.php?type=3" : "#19B060",
  "_reliquias.php?type=4" : "#19B060",
  "_reliquias.php?type=5" : "#19B060",
  "_reliquias.php?type=6" : "#19B060",
  "_reliquias.php?type=7" : "#19B060",
  "_reliquias.php?type=8" : "#19B060",
  "_reliquias.php?type=9" : "#19B060",
  "_reliquias.php?type=10" : "#19B060",
  "_reliquias.php?type=11" : "#19B060",
  "_reliquias.php?type=12" : "#19B060",
  "show-details.php" : "#4F2C72"
};

//Referencia apontando para o objeto menu principal
const MENU = document.querySelector("#menu");

//Referencia apontando para o Logo no header da pagina
const LOGO = document.querySelector("#logo");

//Referencia para o quadro de cortica
const QUADRO_DE_CORTICA = document.querySelector(".quadro-de-cortica");

//Referencia para o elemento body da pagina
const BODY = document.querySelector("body");

//Referencia para o elemento footer da pagina
const FOOTER =  document.querySelector("footer");

/******************************************************************************
 *              Variaveis inicializadas no metodo initialize()
 ******************************************************************************/
//O idioma que o site esta exibindo
let currentLanguage;

//O nome do arquivo da secao que esta sendo visualizada no site
let section;

//A cor da secao que esta sendo visualizada
let sectionColor;

//Um array bidimensional com todas as tags de textos que podem ser traduzidos
let texts = [];

//true quando o menu principal se torna fixo no topo da pagina
let menuFixed;

/*----------------------------------------------------------------------------
            Listener responsavel pelo menu principal do site
----------------------------------------------------------------------------*/
function nav(newSection) {

  if (newSection === section) return;

  window.open(newSection, "_self");//Carrega a pag. do item selecionado
  
}//nav()

/*----------------------------------------------------------------------------
   Retorna o idioma corrente que estah sendo exibido na pag. principal para
   que o Iframe, ao carregar sua pagina, utilize o mesmo idioma

   A pagina do Iframe consulta esta funcao ao carregar
----------------------------------------------------------------------------*/
function getLanguage() {

  return currentLanguage;
  
}//getLanguage()

/*----------------------------------------------------------------------------
             Retorna o idioma anterior ao idioma corrente no site
----------------------------------------------------------------------------*/
function getPreviousLanguage() {

  return (currentLanguage - 1 + LANGUAGES.length) % LANGUAGES.length;
  
}//getPreviousLanguage()

/*----------------------------------------------------------------------------
               Retorna o idioma para o qual o site serah traduzido
----------------------------------------------------------------------------*/
function getNextLanguage() {

  return (currentLanguage + 1) % LANGUAGES.length;

}//getNextLanguage()

/*----------------------------------------------------------------------------
             Retorna a sigla de duas letras de um idioma
----------------------------------------------------------------------------*/
function getLanguagesInitials(language) {

  return LANGUAGES[language].initials;//sigla de 2 digitos do idioma

}//getLanguagesInitials()

/*----------------------------------------------------------------------------
     Ajusta o icone do proximo idioma para o qual o site sera traduzido
----------------------------------------------------------------------------*/
function setIcon() {

  let nextLanguage = getNextLanguage();

  FLAG.src = "images/flags/" + getLanguagesInitials(nextLanguage) + ".png";
  FLAG.title = LANGUAGES[nextLanguage].tooltips;   

}//setIcon()

/*----------------------------------------------------------------------------
     Troca o idioma corrente do site para o proximo idioma da lista
----------------------------------------------------------------------------*/
function toggleLanguage() {

  //Alterna 0, 1, 2, ..., N,  0, 1, 2, ..., N
  currentLanguage = getNextLanguage();

  sessionStorage.setItem("currentLanguage", currentLanguage);

  //Oculta os textos do idioma corrente anterior
  let previous = getPreviousLanguage();

  for (let i = 0; i < texts[previous].length; i++) {

    texts[previous][i].style.display = "none";

  }//for
  
  //Exibe os textos do dioma corrente
  let current = getLanguage();
  
  //Exibe todas as tags com a nova linguagem corrente
  for (let i = 0; i < texts[current].length; i++) { 

    texts[current][i].style.display = "block";

  }//for

  //Exibe o icon referente ao próximo idioma
  setIcon();

}//toggleLanguage()

/*----------------------------------------------------------------------------
  Quando a janela eh redimensionada em sua largura, o menu e o footer devem  
  ser redimensionados em suas alturas. A nova altura serah um percentual da
  largura da janela do navegador. Porem, quanto menor esta largura, maior 
  sera o percentual atribuidos as alturas de menu principal e footer

  Esta funcao calcula o valor que sera atribuidos aos vw de menu e footer.
----------------------------------------------------------------------------*/
function getVwValue() {

  let w = parseInt(window.getComputedStyle(BODY).getPropertyValue("width"));
  return ((360000 / (w * w)) + 2);

}//getVwValue()

/*----------------------------------------------------------------------------
                 Monitora a posicao do menu principal
----------------------------------------------------------------------------*/
function scrollListener() {

  let menuTopPosition = MENU.getBoundingClientRect().top;
  
  //fixa o menu principal no topo da tela 
  if (menuTopPosition <= 0) {

    //Com o menu fixado este listener nao eh mais necessario
    document.removeEventListener("scroll", scrollListener);    
   
    //Fixa o menu principal no topo da pagina
    MENU.style.position = "fixed";
    MENU.style.top = 0;

    menuFixed = true;

    //As novas margens do logo e quadro quando o menu se torna fixo no topo da tela
    LOGO.style.margin = (getVwValue() + 2) + "vw auto 2vw auto";

    if (QUADRO_DE_CORTICA != null) { QUADRO_DE_CORTICA.style.marginTop = "0"; }

    //Troca a cor de fundo do menu pai (principal) para a cor da secao corrente
    MENU.style.backgroundColor = sectionColor;

    //A cor do texto do menu principal e seus submenus quando menu principal fica fixo
    let color = "white";

    //Troca a cor do texto dos itens do menu pai (principal)
    let supermenu_li = document.querySelectorAll("#menu > ul > li");

    for (let i = 0; i < supermenu_li.length; i++) { 

      supermenu_li[i].style.color = color;

    }//for
  
    //Troca a cor dos submenus
    let submenu_ul = document.querySelectorAll(".submenu ul");

    for (let i = 0; i < submenu_ul.length; i++) { 

      submenu_ul[i].style.backgroundColor = sectionColor;     
      submenu_ul[i].style.color = color;

    }//for
  
  }//if

}//scrollListener()

/*----------------------------------------------------------------------------
              Listener para redimensionamento da tela
----------------------------------------------------------------------------*/
function resizeListener() {

  let p = getVwValue();
 
  if (menuFixed) { LOGO.style.margin = (p + 2) + "vw auto 2vw auto"; }

  MENU.style.fontSize = p + "vw";

  if (QUADRO_DE_CORTICA != null) { QUADRO_DE_CORTICA.style.marginBottom = (p + 0.2) + "vw"; }

  FOOTER.style.fontSize = p + "vw";

}//resizeListener()

/*----------------------------------------------------------------------------
              Listener para ocultar o banner do FreeWHA
----------------------------------------------------------------------------*/
function eraseFreewhaBanner() {

  document.querySelector("body > div").style.display = "none";
 
}//eraseFreewhaBanner()

/*----------------------------------------------------------------------------
Inicializa menu principal, registra listeners, obtem dados globais do DOM, 
define o idioma corrente do site
----------------------------------------------------------------------------*/
function initialize(newSection) {

  document.addEventListener("DOMContentLoaded", eraseFreewhaBanner);

  section = newSection;

  if (section ===  "_reliquias.php?type=11") {

    let chestImage = document.querySelector("#chest");
    chestImage.src = "images/open-chest.png";
    chestImage.setAttribute( "onClick", "nav('index.html')" );

  }

  //Obtem a cor da nova secao
  sectionColor = SECTIONS_COLORS[section];

  menuFixed = false;

  resizeListener();

  window.addEventListener("resize", resizeListener);

  document.addEventListener("scroll", scrollListener);

  //Destaca os itens de menu da atual section do site
  let menuItens = document.querySelectorAll('li[onclick="nav(\'' + section + '\')"');

  let isSubmenu = (section.charAt(0) === "_");

  for (let i = 0; i < menuItens.length; i++) {

    menuItens[i].style.color = sectionColor;
    menuItens[i].style.textDecoration = "underline";
    if (isSubmenu) menuItens[i].style.backgroundColor = "lightgrey";

  }
  
  //Obtem todos os textos na pagina que possam ser traduzidos
  for (let i = 0; i < LANGUAGES.length; i++) {

    texts[i] = document.getElementsByClassName(getLanguagesInitials(i));

  }//for

  currentLanguage = parseInt(sessionStorage.getItem("currentLanguage"));

  if (Number.isNaN(currentLanguage)) {

    currentLanguage = PORTUGUESE; 

  }
 
  //Exibe os textos que pertencam ao idioma corrente
  for (let i = 0; i < texts[currentLanguage].length; i++) { 

    texts[currentLanguage][i].style.display = "block";

  }//for

  //Exibe o icone do idioma para o qual o site sera traduzido ao clicar no icon flag
  setIcon();
 
}//initialize()