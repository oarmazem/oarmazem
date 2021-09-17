//Array com todos os textos da pagina que podem ser traduzidos
let texts = [];

/*----------------------------------------------------------------------------
     Mostra os textos do idioma corrente exibido na pagina principal
----------------------------------------------------------------------------*/
function setLanguage() {

  //O antigo idioma
  let previous = parent.getPreviousLanguage();

  //Oculta as tags com texto no antigo idioma
  for (i = 0; i < texts[previous].length; i++) {
    texts[previous][i].style.display = "none";

  }//for
  
  //O novo idioma na pag. de secao
  let current = parent.getLanguage();
  
  //Exibe todas as tags com o novo idioma corrente
  for (i = 0; i < texts[current].length; i++) { 

    texts[current][i].style.display = "block";

  }//for

}//setLanguage()

/*----------------------------------------------------------------------------
      Inicializa o frame com o idioma corrente na pagina principal
----------------------------------------------------------------------------*/
function initialize() {

  //Em quantos idiomas o site pode ser exibido
  let howManyLanguages = parent.howManyLanguages();

  /*
                      Inicializa texts[]

   O vetor texts[] recebe as tags com todos os textos traduziveis
   texts[i] aponta, por sua vez, para um vetor com todas as tags do i-esimo idioma do site
   */
  for (i = 0; i < howManyLanguages; i++) {

    texts[i] = document.getElementsByClassName(parent.getLanguagesInitials(i));

  }//for

  //Idioma sendo exibido na pag. principal
  let currentLanguage = parent.getLanguage();
  
  /*
  Exibe todas as tags com texto no mesmo idioma que esteja sendo exibido
  na pagina principal no momento em que esta pagina de secao eh carregada
  na pag. principal
  */
  for (i = 0; i < texts[currentLanguage].length; i++) { 

    texts[currentLanguage][i].style.display = "block";

  }//for

}//initialize()

initialize();