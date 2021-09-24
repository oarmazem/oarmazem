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

/*
  Prefixo (sem o indice numerico) dos classnames das tags no menu de navegacao

  O primeiro item (em qualquer idioma) do menu principal tem class="navClass0",
  o segundo tem class="navClass1", e assim por diante...
*/  
const ITEM_MENU_CLASSNAME_PREFIX = "navClass";

//Posicao no nome da classe em que se encontra o indice numerico do item de menu
const CLASS_INDEX_POSITION = ITEM_MENU_CLASSNAME_PREFIX.length;

//Referencia apontando para o objeto menu principal
const MENU = document.getElementById("menu");

//regexp para localizar "navClass" em um nome de classe
const REG_EXP = new RegExp(ITEM_MENU_CLASSNAME_PREFIX + "\\d+");

/******************************************************************************
 *              Variaveis inicializadas no metodo initialize()
 ******************************************************************************/
//A classe dos itens de menu que estao selecionados
let navClassSelected;

//O idioma que o site esta exibindo
let currentLanguage;

//Um array bidimensional com todas as tags de textos que podem ser traduzidos
let texts = [];

/*----------------------------------------------------------------------------
            Listener responsavel pelo menu principal do site
----------------------------------------------------------------------------*/
function nav() {

  if (this.className === navClassSelected) return;
  
  //O item clicado passa a ser o item selecionado
  navClassSelected = ((this.className).match(REG_EXP))[0];

  //Os itens de menu sao numerados com indices de 0 ao (numero de itens no menu - 1)
  let navClassSelectedIndex = 
    navClassSelected.substring(CLASS_INDEX_POSITION, navClassSelected.length);

  sessionStorage.setItem("navClassSelectedIndex", navClassSelectedIndex);  

  window.open(PAGES[navClassSelectedIndex], "_self");//Carrega a pag. do item selecionado
  
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
                 Monitora a posicao do menu principal
----------------------------------------------------------------------------*/
function scrollListener() {

  let menuTopPosition = MENU.getBoundingClientRect().top;
   
  if (menuTopPosition <= 0) {

    MENU.style.position = "fixed";
    MENU.style.top = 0;
    MENU.style.backgroundColor = "#DDDDDD";
    MENU.style.opacity = "0.9";
    document.removeEventListener("scroll", scrollListener);
    document.querySelector("#logo").style.margin = "5vw auto 0vw auto";

  }

}//scrollListener()

/*----------------------------------------------------------------------------
Inicializa menu principal, registra listeners, obtem dados globais do DOM, 
define o idioma corrente do site
----------------------------------------------------------------------------*/
function initialize() {

  document.addEventListener("scroll", scrollListener);

  let navClassSelectedIndex = sessionStorage.getItem("navClassSelectedIndex");

  if (navClassSelectedIndex === null) navClassSelectedIndex = "0";

  navClassSelected = ITEM_MENU_CLASSNAME_PREFIX + navClassSelectedIndex;//O item do menu

  //Obtem o item selecionado do menu principal em todos os idiomas
  let menuSelectedItens = document.querySelectorAll("#menu ." + navClassSelected);  

  //Destaca os primeiros itens em todos os idiomas
  for (let i = 0; i < menuSelectedItens.length; i++) {

    let selectedItem = menuSelectedItens[i]; 
    selectedItem.style.textDecoration = "underline";    
    selectedItem.style.color = COLORS[navClassSelectedIndex];

  }//for
  
  //Registra a function nav() como listener de todos os elementos navClass
  for (let i = 0; i < PAGES.length; i++) {

    let linksToSections = document.querySelectorAll("." + ITEM_MENU_CLASSNAME_PREFIX + i);

    for (let j = 0; j < linksToSections.length; j++) {

      linksToSections[j].addEventListener("click", nav);

    }//for j

  }//for i
  
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

  //Exibe o icone do idioma para o qual o site sera traduzido ao seu clicar no icon flag
  setIcon();
 
}//initialize()

initialize();