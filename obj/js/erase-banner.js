/*----------------------------------------------------------------------------
              Listener para ocultar o banner do FreeWHA
----------------------------------------------------------------------------*/
function eraseFreewhaBanner() {

  document.querySelector("body > div").style.display = "none";
 
}//eraseFreewhaBanner()

document.addEventListener("DOMContentLoaded", eraseFreewhaBanner);

