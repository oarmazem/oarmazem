const PORTUGUESE = 0;

//Siglas dos idiomas do site
const LANGUAGES = [
  "br", //Português do Brasil
  "en", //Inglês britânico
  "es"  //Espanhol da Espanha
];

//Tooltips para cada icone de traducao
const LANGUAGES_TOOLTIPS = [
  "Traduzir para Português",
  "Translate to English",
  "Traducion para Español"
];

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

//prefixo (sem o indice numerico) dos classnames das tags no menu de navegacao
const ITEM_MENU_CLASS_NAME = "navClass";

//Posicao no nome da classe em que se encontra o indice numerico do item de menu
const CLASS_INDEX_POSITION = ITEM_MENU_CLASS_NAME.length;

//Objeto apontando para a tag iframe onde sao carregadas as paginas de secao
const IFRAME = document.getElementById("iframe");

//Objeto apontando para a tag com o icone da traducao
const FLAG = document.getElementById("flag");

//O item do menu que esta selecionado
let navSelected;//A secao do menu que esta selecionada

//O idioma que o site esta exibindo
let currentLanguage;//O idioma corrente exibido no site   

//Um array com todas as tags de textos que podem ser traduzidos
let texts = [];

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
               Retorna quantos idiomas o site pode exibir
----------------------------------------------------------------------------*/
function howManyLanguages() {

  return LANGUAGES.length;

}//howManyLanguages()

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

  return (currentLanguage - 1 + LANGUAGES.length) % howManyLanguages();
  
}//getPreviousLanguage()

/*----------------------------------------------------------------------------
               Retorna o idioma para o qual o site serah traduzido
----------------------------------------------------------------------------*/
function getNextLanguage() {

  return (currentLanguage + 1) % howManyLanguages();
  
}//getNextLanguage()

/*----------------------------------------------------------------------------
             Retorna a sigla de duas letras de um idioma
----------------------------------------------------------------------------*/
function getLanguagesInitials(language) {

  return LANGUAGES[language];

}//getLanguagesInitials()

/*----------------------------------------------------------------------------
     Ajusta o icone do proximo idioma para o qual o site sera traduzido
----------------------------------------------------------------------------*/
function setIcon() {

  let nextLanguage = getNextLanguage();

  FLAG.src = "images/" + getLanguagesInitials(nextLanguage) + ".png";
  FLAG.title = LANGUAGES_TOOLTIPS[nextLanguage];  

}//setIcon()

/*----------------------------------------------------------------------------
             Exibe os textos da pagina no idioma corrente
----------------------------------------------------------------------------*/
function setLanguage() {

  //Oculta os textos do idioma corrente anterior
  let previous = getPreviousLanguage();

  for (i = 0; i < texts[previous].length; i++) {

    texts[previous][i].style.display = "none";

  }//for
  

  //Exibe os textos do dioma corrente
  let current = getLanguage();
  
  //Exibe todas as tags com a nova linguagem corrente
  for (i = 0; i < texts[current].length; i++) { 

    texts[current][i].style.display = "block";

  }//for

  //Exibe o icon referente ao próximo idioma
  setIcon();

}//setLanguage()

/*----------------------------------------------------------------------------
     Troca o idioma corrente do site para o proximo idioma da lista
----------------------------------------------------------------------------*/
function toggleLanguage() {
  
  //Alterna 0, 1, 2, ..., N,  0, 1, 2, ..., N
  currentLanguage = getNextLanguage();

  //Atualiza idioma na pag. principal
  setLanguage();

  //Atualiza idioma do frame
  IFRAME.contentWindow.setLanguage();
  
}//toggleLanguage()

/*----------------------------------------------------------------------------
Inicializa menu principal, registra listeners, obtem dados globais do DOM, 
define o idioma corrente do site
----------------------------------------------------------------------------*/
function initialize() {

  navSelected = null;

  nav();//Configura o menu principal

  //Registra a function nav() como listener de todos os itens de menu
  let itensMenu = document.querySelectorAll("#menu a");

  for (i = 0; i < itensMenu.length; i++) {

    itensMenu[i].addEventListener("click", nav);

  }//for

  let logo = document.querySelector("#logo");

  logo.addEventListener("click", nav);

  currentLanguage = PORTUGUESE;
  
  //Obtem todos os textos na pagina principal que possam ser traduzidos
  for (i = 0; i < LANGUAGES.length; i++) {

    texts[i] = document.getElementsByClassName(getLanguagesInitials(i));

  }//for

  //Exibe os textos que pertencam ao idioma corrente
  for (i = 0; i < texts[currentLanguage].length; i++) { 

    texts[currentLanguage][i].style.display = "block";

  }//for

  //Exibe o icone do idioma para o qual o site sera traduzido ao seu clicar no icon flag
  setIcon();
 
}//initialize()

initialize();
