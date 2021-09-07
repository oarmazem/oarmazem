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
function setCurrentLanguage() {

  currentLanguage = "pt";
  
}

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function getCurrentLanguage() {

  return currentLanguage;
  
}//getCurrentLanguage()

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function toggleLanguage() {

  if (currentLanguage == "pt") {

    currentLanguage = "en"; 
  } 
  else { 

    currentLanguage = "pt"; 
  }

  setLanguage();

}//toggleLanguage()

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function setLanguage() {

  document.getElementById('iframe').contentWindow.setIFrameLanguage(currentLanguage);

  ptDisplay = "none"; enDisplay = "none";

  flag = document.getElementById("flag");

  if (currentLanguage == "pt") { 
    flag.src = "images/en.png";
    flag.title = "Translate to English";
    ptDisplay = "inline";
    
  } else { 
    flag.src = "images/br.png";
    flag.title = "Traduza para Português";
    enDisplay = "inline";
  }
 
  updateSpans(ptDisplay, enDisplay);

}//setLanguage()

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function setIFrameLanguage(language) {

  ptDisplay = "none"; enDisplay = "none";

  if (language == "pt") { ptDisplay = "inline"; } else { enDisplay = "inline"; }

  updateSpans(ptDisplay, enDisplay);
}//setIFrameLanguage()

/*----------------------------------------------------------------------------

----------------------------------------------------------------------------*/
function updateSpans(ptDisplay, enDisplay) {

  pt = document.getElementsByClassName("pt");
  en = document.getElementsByClassName("en");

  for (i = 0; i < pt.length; i++) { pt[i].style.display = ptDisplay }
  for (i = 0; i < en.length; i++) { en[i].style.display = enDisplay }

}//updateSpans()