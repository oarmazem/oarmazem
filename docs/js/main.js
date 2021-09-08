/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
var currentOption = 'id1';

function nav(id) {

  menuOption = document.getElementById(currentOption);
  menuOption.style.textDecoration = 'none';
  menuOption.style.color = 'black';
  currentOption = id;

  menuOption = document.getElementById(id);
  menuOption.style.textDecoration = 'underline';

  switch (id) {
    case 'id1': 
      menuOption.style.color = "#2C459C";
      break;
    case 'id2':
      menuOption.style.color = "#EE3539";
      break;
    case 'id3':
      menuOption.style.color = "#19B060";
      break; 
    case 'id4':
      menuOption.style.color = "#F58637";
      break;
    case 'id5':
      menuOption.style.color = "#0FB99B";
      break;
    case 'id6':
      menuOption.style.color = "#4F2C72";
      break;    
    case 'id7':
      menuOption.style.color = "#1597D5";
      break;  
    case 'id8':
      menuOption.style.color = "#A82F82";
      break;        
  }//switch
  
}//nav()

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function setPortugueseAsCurrentLanguage() {

  currentLanguage = 0; //0 -> PT-BR   1 -> EN-US

  flag = document.getElementById("flag");
  flag.src = "images/en.png";
  flag.title = "Translate to English";

  showPortuguese(true); 
  
}//setPortugueseAsCurrenteLanguage()

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function getCurrentLanguage() {

  return currentLanguage;
  
}//getCurrentLanguage()

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function toggleLanguage() {

  currentLanguage = 1 - currentLanguage;

  setLanguage();

}//toggleLanguage()

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function setLanguage() {

  document.getElementById('iframe').contentWindow.setIFrameLanguage(currentLanguage);

  flag = document.getElementById("flag");

  if (currentLanguage == 0) { 
    flag.src = "images/en.png";
    flag.title = "Translate to English";
    showPortuguese(true);
    
  } else { 
    flag.src = "images/br.png";
    flag.title = "Traduza para Português";
    showPortuguese(false);
  }

}//setLanguage()

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function setIFrameLanguage(language) {

  if (language == 0) { 
    showPortuguese(true)
  } 
  else { 
    showPortuguese(false) 
  }

}//setIFrameLanguage()

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function showPortuguese(showPt) {

  pt = document.getElementsByClassName("pt");
  en = document.getElementsByClassName("en");

  if (showPt) {

    for (i = 0; i < pt.length; i++) { 

      switch (pt[i].tagName) {
        case "span":
          pt[i].style.display = "inline";
        default:
          pt[i].style.display = "block";
      }//switch

    }//for

    for (i = 0; i < en.length; i++) { en[i].style.display = "none" }
  }
  else {

    for (i = 0; i < en.length; i++) { 

      switch (en[i].tagName) {
        case "span":
          en[i].style.display = "inline";
        default:
          en[i].style.display = "block";
      }//switch

    }//for

    for (i = 0; i < pt.length; i++) { pt[i].style.display = "none" }

  }//if-else

}//showPortuguese()