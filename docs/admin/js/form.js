  let main_image = document.getElementById("id_main_image");

  let ocilator = document.getElementById("ocilator");

  let bar = document.getElementById("bar"); 

  let buttons_action = document.querySelectorAll(".button_action"); 

  /*----------------------------------------------------------------------------------------------
                                  Exibe uma previa da imagem
  -----------------------------------------------------------------------------------------------*/ 
  function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }//sleep)()

  /*----------------------------------------------------------------------------------------------
                                  Exibe uma previa da imagem
  -----------------------------------------------------------------------------------------------*/
  async function wait() {

    if (typeof(main_image.files[0]) == "undefined") return;

    for (let i = 0; i < buttons_action.length; i++) {

      buttons_action[i].style.display = "none";

    }
 
    bar.style.display = "block";

    while (true) {
      for (let i = 0; i < 90 ; i++) {        
         await sleep(40);
         ocilator.style.left = i + "%";
      }
      for (let i = 90; i > 0 ; i--) {        
         await sleep(40);
         ocilator.style.left = i + "%";
      }
    }
  }//wait()