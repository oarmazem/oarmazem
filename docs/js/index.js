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

//Referencia apontando para a tag iframe onde sao carregadas as paginas de secao
const IFRAME = document.getElementById("iframe");

//Os arquivos dos frames de cada secao do menu
const FRAMES = [
  "inicio.html", 
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

  let menuItens;//Um vetor para armazenar os itens dos menus que serao manipulados

  //A secao e item de menu que era corrente serah desselecionada no menu principal
  menuItens = document.querySelectorAll("#menu ." + navClassSelected);

  for (i = 0; i < menuItens.length; i++) {

    let unselectedItem = menuItens[i];
    unselectedItem.style.textDecoration = "none";
    unselectedItem.style.color = "black";

  }//for

  navClassSelected = this.className;//O item clicado passa a ser o item selecionado

  //Obtem o item selecionado em todos os idiomas
  menuItens = document.querySelectorAll("#menu ." + navClassSelected);

  //Os itens de menu sao numerados com indices de 0 ao (numero de itens no menu - 1)
  let navClassSelectedIndex = 
    navClassSelected.substring(CLASS_INDEX_POSITION, navClassSelected.length);

  //Destaca os itens selecionados em todos os idiomas
  for (i = 0; i < menuItens.length; i++) {

    let selectedItem = menuItens[i]; 
    selectedItem.style.textDecoration = "underline";    
    selectedItem.style.color = COLORS[navClassSelectedIndex];

  }//for
 
  IFRAME.src = FRAMES[navClassSelectedIndex];//Carrega o frame do item selecionado
  
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

  return LANGUAGES[language].initials;//sigla de 2 digitos do idioma

}//getLanguagesInitials()

/*----------------------------------------------------------------------------
     Ajusta o icone do proximo idioma para o qual o site sera traduzido
----------------------------------------------------------------------------*/
function setIcon() {

  let nextLanguage = getNextLanguage();

  FLAG.src = "images/" + getLanguagesInitials(nextLanguage) + ".png";
  FLAG.title = LANGUAGES[nextLanguage].tooltips;   

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

  navClassSelected = ITEM_MENU_CLASSNAME_PREFIX + "0";//navClass0

  //Obtem o primeiro item do menu principal em todos os idiomas
  let menuFirstItens = document.querySelectorAll("#menu ." + navClassSelected);  

  //Destaca os primeiros itens em todos os idiomas
  for (i = 0; i < menuFirstItens.length; i++) {

    let selectedItem = menuFirstItens[i]; 
    selectedItem.style.textDecoration = "underline";    
    selectedItem.style.color = COLORS[0];

  }//for
 
  IFRAME.src = FRAMES[0];//Carrega o frame do item selecionado  

  //Registra a function nav() como listener de todos os itens de menu
  let itensMenu = document.querySelectorAll("#menu li");

  for (i = 0; i < itensMenu.length; i++) {

    itensMenu[i].addEventListener("click", nav);

  }//for

  /*
    Registra a function nav() como listener da img da logomarca
    Clicar na logo tem a mesma funcao que clicar no 1o item do menu
  */
  document.querySelector("#logo").addEventListener("click", nav);
  
  //Obtem todos os textos na pagina principal que possam ser traduzidos
  for (i = 0; i < LANGUAGES.length; i++) {

    texts[i] = document.getElementsByClassName(getLanguagesInitials(i));

  }//for

  currentLanguage = PORTUGUESE;

  //Exibe os textos que pertencam ao idioma corrente
  for (i = 0; i < texts[currentLanguage].length; i++) { 

    texts[currentLanguage][i].style.display = "block";

  }//for

  //Exibe o icone do idioma para o qual o site sera traduzido ao seu clicar no icon flag
  setIcon();
 
}//initialize()

initialize();