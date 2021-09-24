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

/******************************************************************************
 *              Variaveis inicializadas no metodo initialize()
 ******************************************************************************/
//O idioma que o site esta exibindo
let currentLanguage;

//O numero da secao que esta sendo visualizada no site
let sectionIndex;

//Um array bidimensional com todas as tags de textos que podem ser traduzidos
let texts = [];

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
                 Monitora a posicao do menu principal
----------------------------------------------------------------------------*/
function scrollListener() {

  let menuTopPosition = MENU.getBoundingClientRect().top;
   
  if (menuTopPosition <= 0) {

    MENU.style.position = "fixed";
    MENU.style.top = 0;
    MENU.style.backgroundColor = COLORS[sectionIndex];
    let itemMenu = document.querySelectorAll("#menu li");
    for (let i = 0; i < itemMenu.length; i++) { itemMenu[i].style.color = "#FFFFFF"; }
     document.removeEventListener("scroll", scrollListener);
    document.querySelector("#logo").style.margin = "5vw auto 0vw auto";

  }

}//scrollListener()

/*----------------------------------------------------------------------------
Inicializa menu principal, registra listeners, obtem dados globais do DOM, 
define o idioma corrente do site
----------------------------------------------------------------------------*/
function initialize(index) {
  
  sectionIndex = index;

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

  //Exibe o icone do idioma para o qual o site sera traduzido ao seu clicar no icon flag
  setIcon();
 
}//initialize()