let texts = [];

/*----------------------------------------------------------------------------
  Exibe os textos da pagina no idioma passado pelo parametro "language"

  "thereWasPreviousPage" eh um booleano que indica se antes de chamar esta 
  funcao jah havia algum texto sendo exibido na pagina, ou se a pagina esta
  sendo carregada pela primeira vez
----------------------------------------------------------------------------*/
function setLanguage() {

  let previous = parent.getPreviousLanguage();

  for (i = 0; i < texts[previous].length; i++) {
    texts[previous][i].style.display = "none";

  }//for
  
  let current = parent.getLanguage();
  
  //Exibe todas as tags com a nova linguagem corrente
  for (i = 0; i < texts[current].length; i++) { 

    texts[current][i].style.display = "block";

  }//for

}//setLanguage()

/*----------------------------------------------------------------------------
      Inicializa o frame com o idioma corrente na pagina principal
----------------------------------------------------------------------------*/
function initialize() {

  let howManyLanguages = parent.howManyLanguages();

  for (i = 0; i < howManyLanguages; i++) {

    texts[i] = document.getElementsByClassName(parent.getLanguagesInitials(i));

  }//for

  let currentLanguage = parent.getLanguage();
  
  //Exibe todas as tags com a nova linguagem corrente
  for (i = 0; i < texts[currentLanguage].length; i++) { 

    texts[currentLanguage][i].style.display = "block";

  }//for

}//initialize()

initialize();