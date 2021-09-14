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
const FRAMES = [
  "inicio.html", 
  "cafe.html",
  "reliquias.html", 
  "mapa.html", 
  "contato.html"
];

//Nomes dos arquivos com os icones de traducao
const LANGUAGES_ICONS = [
  "en.png",
  "es.png",
  "br.png"
];

//Tooltips para cada icone de traducao
const LANGUAGES_TOOLTIPS = [
  "Translate to English",
  "Traducion para Español",
  "Traduzir para Português"
];

const ITEM_MENU_CLASS_NAME = "navClass";

//Posicao no nome da classe em que se encontra o indice numerico do item de menu
const CLASS_INDEX_POSITION = ITEM_MENU_CLASS_NAME.length;

//Objeto apontando para a tag iframe onde sao carregadas as paginas de secao
const IFRAME = document.getElementById("iframe");

//Objeto apontando para a tag com o icone da traducao
const FLAG = document.getElementById("flag");
FLAG.src = "images/en.png";
FLAG.title = "Translate to English";

//Vetores apontando para tags com os textos em cada idioma
const PT = document.getElementsByClassName("pt");
const EN = document.getElementsByClassName("en");
const ES = document.getElementsByClassName("es");

const PORTUGUESE = 0;
const ENGLISH = 1;
const SPANISH = 2;
const THERE_ARE_PREVIOUS_LANGUAGE = true;
const THERE_ARENT_PREVIOUS_LANGUAGE = false;

let navSelected = null;//A secao do menu que esta selecionada

//O site abre em Portugues
let currentLanguage = PORTUGUESE;   

initialize();

/*----------------------------------------------------------------------------
            Listener responsavel pelo menu principal do site
----------------------------------------------------------------------------*/
function nav() {

  let menuItens;//Um vetor para armazenar os itens dos menus que serao manipulados

  let navClass;//Armazena o nome da classe do grupo de itens de menu selecionados

  //O metodo foi chamado na inicializadao
  if (navSelected === null) { 

    navClass = ITEM_MENU_CLASS_NAME + "0";

  } 
  //O metodo foi chamado para tratar o clique do mouse em um item do menu
  else {

    navClass = this.className;
 
    //A secao que era a corrente serah desselecionada no menu principal
    menuItens = document.getElementsByClassName(navSelected);

    for (i = 0; i < menuItens.length; i++) {

      let unselectedItem = menuItens[i];
      unselectedItem.style.textDecoration = "none";
      unselectedItem.style.color = "black";

    }//for

  }//if-else

  navSelected = navClass;//O item clicado passa a ser o item selecionado

  //Obtem o item selecionado em todos os idiomas
  menuItens = document.getElementsByClassName(navSelected);

  //Os itens de menu sao numerados com indices de 0 ao (numero de itens no menu - 1)
  let classIndex = navSelected.substring(CLASS_INDEX_POSITION, navSelected.length);

  //Destaca os itens selecionados em todos os idiomas
  for (i = 0; i < menuItens.length; i++) {

    let selectedItem = menuItens[i]; 
    selectedItem.style.textDecoration = "underline";    
    selectedItem.style.color = COLORS[classIndex];

  }//for
 
  IFRAME.src = FRAMES[classIndex];//Carrega o frame do item selecionado
  
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
  Exibe os textos da pagina no idioma passado pelo parametro "language"

  "thereWasPreviousPage" eh um booleano que indica se antes de chamar esta 
  funcao jah havia algum texto sendo exibido na pagina, ou se a pagina esta
  sendo carregada pela primeira vez
----------------------------------------------------------------------------*/
function setLanguage(language, thereArePreviousLanguage) {
  
  let previous;
  let current;

  switch (language) {

    case PORTUGUESE:
      current = PT;
      previous = ES;
      break;
    case ENGLISH:
      current = EN;
      previous = PT;
      break;
    case SPANISH:
      current = ES;
      previous = EN;   

  }//switch

  //Oculta todas as tags que exibiam texto com o idioma corrente anterior
  if (thereArePreviousLanguage) {
    for (i = 0; i < previous.length; i++) { 

      previous[i].style.display = "none"

    }//for
  }//if

  //Exibe todas as tags com a nova linguagem corrente
  for (i = 0; i < current.length; i++) { 

    current[i].style.display = "block";

  }//for

}//setLanguage()

/*----------------------------------------------------------------------------
     Troca o idioma corrente do site para o proximo idioma da lista

     A lista eh : PORTUGUESE, ENGLISH, SPANISH
----------------------------------------------------------------------------*/
function toggleLanguage() {
  
  currentLanguage = (currentLanguage + 1) % 3;//Alterna 0, 1, 2, 0, 1, 2...
  
  //Atualiza o icone que indica o idioma para o qual a pag. sera traduzida
  FLAG.src = "images/" + LANGUAGES_ICONS[currentLanguage];
  FLAG.title = LANGUAGES_TOOLTIPS[currentLanguage];

  //Atualiza idioma na pag. principal
  setLanguage(currentLanguage, THERE_ARE_PREVIOUS_LANGUAGE);

  //Atualiza idioma do frame
  IFRAME.contentWindow.setLanguage(currentLanguage, THERE_ARE_PREVIOUS_LANGUAGE);
  
}//toggleLanguage()

/*----------------------------------------------------------------------------
Inicializa menu principal, registra listeners, obtem dados globais do DOM, 
define o idioma corrente do site
----------------------------------------------------------------------------*/
function initialize() {

  nav();

  //Registra a function nav() como listener de todos os itens de menu
  let itensMenu = document.querySelectorAll("#menu a");

  for (i = 0; i < itensMenu.length; i++) {

    itensMenu[i].addEventListener("click", nav);

  }//for

  setLanguage(PORTUGUESE, THERE_ARENT_PREVIOUS_LANGUAGE);  
  
}//initialize()