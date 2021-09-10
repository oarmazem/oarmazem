/*----------------------------------------------------------------------------
            Listener responsavel pelo menu principal do site
----------------------------------------------------------------------------*/
//Cores dos itens de menu
const colors = [
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
const frames = [
  "inicio.html", 
  "cafe.html",
  "reliquias.html", 
  "mapa.html", 
  "contato.html"
];

var navSelected = null;//A secao do menu que esta selecionada

//Posicao no nome da classe em que se encontra o indice numerico do item de menu
var classIndexPosition;

var iframe;//O iframe onde sao carregadas as secoes na pag. principal

function nav() {

  var menuItens;//Um vetor para armazenar os itens que serao manipulados

  var navClass;//Armazena o nome da classe do grupo de itens de menu selecionados

  //O metodo foi chamado na inicializadao por index.html
  if (navSelected === null) { 

    navClass = "navClass0";
    classIndexPosition = navClass.length - 1;
    iframe = document.getElementById("iframe");

  } 
  //O metodo foi chamado para tratar o clique do mouse em um item do menu
  else {

    navClass = this.className;

    //A secao que era a corrente serah desselecionada no menu principal
    menuItens = document.getElementsByClassName(navSelected);

    for (i = 0; i < menuItens.length; i++) {

      var unselectedItem = menuItens[i];
      unselectedItem.style.textDecoration = "none";
      unselectedItem.style.color = "black";

    }//for

  }//if-else

  navSelected = navClass;//O item clicado passa a ser o item selecionado

  //Obtem o item selecionado em todos os idiomas
  menuItens = document.getElementsByClassName(navSelected);

  //Os itens de menu sao numerados com indices de 0 ao (numero de itens no menu - 1)
  var classIndex = navSelected.charAt(classIndexPosition);

  //Destaca os itens selecionados em todos os idiomas
  for (i = 0; i < menuItens.length; i++) {

    var selectedItem = menuItens[i]; 
    selectedItem.style.textDecoration = "underline";    
    selectedItem.style.color = colors[classIndex];

  }//for
 
  iframe.src = frames[classIndex];//Carrega o frame do item selecionado
  
}//nav()

/*----------------------------------------------------------------------------
 Obtem elementos do DOM que serao acessados enquanto o site estiver carregado
 no navegador
----------------------------------------------------------------------------*/
function getDOMData() {

  flag = document.getElementById("flag");

  pt = document.getElementsByClassName("pt");
  en = document.getElementsByClassName("en");
  es = document.getElementsByClassName("es");

}//getDOMData()

/*----------------------------------------------------------------------------
Inicializa menu principal, registra listeners, obtem dados globais do DOM, 
define o idioma corrente do site
----------------------------------------------------------------------------*/
const PORTUGUESE = 0;
const ENGLISH = 1;
const SPANISH = 2;
const THERE_ARE_PREVIOUS_LANGUAGE = true;
const THERE_ARENT_PREVIOUS_LANGUAGE = false;

function initialize() {

  nav();

  //Registra a function nav() como listener de todos os itens de menu
  for (i = 0; i <= 4; i++) {

    var itensMenu = document.getElementsByClassName("navClass" + i);

    for (j = 0; j < itensMenu.length; j++) {

      itensMenu[j].addEventListener("click", nav);

    }//for

  }//for

  getDOMData();

  currentLanguage = PORTUGUESE;   

  flag.src = "images/en.png";
  flag.title = "Translate to English";

  setLanguage(PORTUGUESE, THERE_ARENT_PREVIOUS_LANGUAGE);   

}//initialize()

/*----------------------------------------------------------------------------
   Retorna o idioma corrente que estah sendo exibido na pag. principal para
   que o Iframe, ao carregar sua pagina, utilize o mesmo idioma

   A pagina do Iframe consulta esta funcao ao carregar
----------------------------------------------------------------------------*/
function getLanguage() {

  return currentLanguage;
  
}//getLanguage()

/*----------------------------------------------------------------------------
     Troca o idioma corrente do site para o proximo idioma da lista

     A lista eh : PORTUGUESE, ENGLISH, SPANISH
----------------------------------------------------------------------------*/
function toggleLanguage() {
  
  currentLanguage = (currentLanguage + 1) % 3;//Alterna 0, 1, 2, 0, 1, 2...

  //Troca para icone do prox. idioma
  switch (currentLanguage) { 

    case PORTUGUESE:
      flag.src = "images/en.png";
      flag.title = "Translate to English";
      break;
    case ENGLISH:
      flag.src = "images/es.png";  
      flag.title = "Traducion para Español";
      break;
    case SPANISH:
      flag.src = "images/br.png";
      flag.title = "Traduza para Português"  

  }//switch

  setLanguage(currentLanguage, THERE_ARE_PREVIOUS_LANGUAGE);//Atualiza idioma na pag. principal

  //Atualiza idioma do frame
  document.getElementById('iframe').
    contentWindow.setLanguage(currentLanguage, THERE_ARE_PREVIOUS_LANGUAGE);
  
}//toggleLanguage()

/*----------------------------------------------------------------------------
  Funcao chamada quando eh carregada a pagina do iframe

  O parametro "language" eh o idioma sendo usado na pag. principal quando o
  iframe eh carregado. E este dado eh obtido chamando a funcao 
  parent.getCurrentLanguage() que retorna o idioma corrente na pagina principal
----------------------------------------------------------------------------*/
function setIFrameLanguage(language) {

  getDOMData();//Inicializa vetores com dados do DOM
  setLanguage(language, THERE_ARENT_PREVIOUS_LANGUAGE);//Exibe os textos da pag. no idioma corrente 

}//setIFrameLanguage()

/*----------------------------------------------------------------------------
  Exibe os textos da pagina no idioma passado pelo parametro "language"

  "thereWasPreviousPage" eh um booleano que indica se antes de chamar esta 
  funcao jah havia algum texto sendo exibido na pagina, ou se a pagina esta
  sendo carregada pela primeira vez
----------------------------------------------------------------------------*/
function setLanguage(language, thereArePreviousLanguage) {
  
  var previous;
  var current;

  switch (language) {

    case PORTUGUESE:
      current = pt;
      previous = es;
      break;
    case ENGLISH:
      current = en;
      previous = pt;
      break;
    case SPANISH:
      current = es;
      previous = en;   

  }//switch

  for (i = 0; i < current.length; i++) { 

    current[i].style.display = "block";

  }//for
  
  if (thereArePreviousLanguage) {
    for (i = 0; i < previous.length; i++) { 

      previous[i].style.display = "none"

    }//for
  }//if

}//setLanguage()