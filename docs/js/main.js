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

//Cores dos itens de menu
const COLORS = [
  "#2C459C",
  "#EE3539",
  "#19B060",
  "#F58637",
  "#0FB99B",
  "#4F2C72",
  "#1597D5",
  "#A82F82"
];

//Os arquivos dos frames de cada secao do menu
const PAGES = [
  "index.html", 
  "cafe.html",
  "reliquias.html", 
  "mapa.html", 
  "contato.html"
];

//Referencia apontando para o objeto menu principal
const MENU = document.getElementById("menu");

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

//O numero da secao que esta sendo visualizada no site
let sectionIndex;

//Um array bidimensional com todas as tags de textos que podem ser traduzidos
let texts = [];

//true quando o menu principal se torna fixo no topo da pagina
let menuFixed;

/*----------------------------------------------------------------------------
            Listener responsavel pelo menu principal do site
----------------------------------------------------------------------------*/
function nav(index) {

  if (index === sectionIndex) return;

  window.open(PAGES[index], "_self");//Carrega a pag. do item selecionado
  
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

    MENU.style.position = "fixed";
    MENU.style.top = 0;
    MENU.style.backgroundColor = COLORS[sectionIndex];

    let itemMenu = document.querySelectorAll("#menu li");

    for (let i = 0; i < itemMenu.length; i++) { itemMenu[i].style.color = "#FFFFFF"; }

    document.removeEventListener("scroll", scrollListener);
    
    //As novas margens do logo quando o menu se torna fixo no topo da tela
    LOGO.style.margin = (getVwValue() + 2) + "vw auto 2vw auto";

    menuFixed = true;

    if (QUADRO_DE_CORTICA != null) { QUADRO_DE_CORTICA.style.marginTop = "0"; }

  }//if

}//scrollListener()

/*----------------------------------------------------------------------------
              Listener para redimensionamento da tela
----------------------------------------------------------------------------*/
function resizeListener() {

  let w = getVwValue();
 
  if (menuFixed) { LOGO.style.margin = (w + 2) + "vw auto 2vw auto"; }

  MENU.style.fontSize = w + "vw";

  if (QUADRO_DE_CORTICA != null) { QUADRO_DE_CORTICA.style.marginBottom = (w + 0.2) + "vw"; }

  FOOTER.style.fontSize = w + "vw";

}//resizeListener()

/*----------------------------------------------------------------------------
Inicializa menu principal, registra listeners, obtem dados globais do DOM, 
define o idioma corrente do site
----------------------------------------------------------------------------*/
function initialize(index) {
  
  sectionIndex = index;

  menuFixed = false;

  resizeListener();

  window.addEventListener("resize", resizeListener);

  document.addEventListener("scroll", scrollListener);

  //Destaca os itens de menu da atual section do site
  let menuItens = document.querySelectorAll('li[onclick="nav(' + sectionIndex +')"');

  for (let i = 0; i < menuItens.length; i++) {
    menuItens[i].style.color = COLORS[sectionIndex];
    menuItens[i].style.textDecoration = "underline";
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