//Vetores apontando para tags com os textos em cada idioma
const PT = document.getElementsByClassName("pt");
const EN = document.getElementsByClassName("en");
const ES = document.getElementsByClassName("es");

const PORTUGUESE = 0;
const ENGLISH = 1;
const SPANISH = 2;
const THERE_ARENT_PREVIOUS_LANGUAGE = false;

initialize();

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
      Inicializa o frame com o idioma corrente na pagina principal
----------------------------------------------------------------------------*/
function initialize() {

  setLanguage(parent.getLanguage(), THERE_ARENT_PREVIOUS_LANGUAGE);

}//initialize()