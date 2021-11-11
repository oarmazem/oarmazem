const MAIN_IMAGE = document.getElementById("main_image");

const MORE_IMAGES = document.getElementById("more_images");

const CPF_CNPJ = document.getElementById("cpf_cnpj");

const OCILATOR = document.getElementById("ocilator");

const BAR = document.getElementById("bar"); 

const BUTTON_ACTION = document.querySelectorAll(".button_action");

const CPF_PATTERN = new RegExp("^(\\s*(\\d{3}\\.){2}(\\d{3}[-/])\\d{2}\\s*)$");

/*----------------------------------------------------------------------------------------------
                                  Pausa por ms milisegundos
-----------------------------------------------------------------------------------------------*/ 
function sleep(ms) {

  return new Promise(resolve => setTimeout(resolve, ms));

}//sleep()

/*----------------------------------------------------------------------------------------------
                            Exibe uma animacao de espera de upload
-----------------------------------------------------------------------------------------------*/
async function waitForTheUpload() {

  for (let i = 0, length = BUTTON_ACTION.length; i < length; i++) {

    BUTTON_ACTION[i].style.display = "none";

  }

  BAR.style.display = "block";

  document.body.style.cursor = "progress";

  while (true) {
    for (let i = 0; i < 90 ; i++) {        
        await sleep(40);
        OCILATOR.style.left = i + "%";
    }
    for (let i = 90; i > 0 ; i--) {        
        await sleep(40);
        OCILATOR.style.left = i + "%";
    }
  }
}//waitForTheUpload()

/*----------------------------------------------------------------------------------------------
                  Obtem uma string apenas com os digitos de um CPF ou CNPF
-----------------------------------------------------------------------------------------------*/
function getDigits(str) {

  let result = "";//Concatena em result apenas os digitos de str

  for (let i = 0, length = str.length; i < length; i++) {

    let charCode = str.charCodeAt(i);
    if ((charCode > 47) && (charCode < 58)) result += str.charAt(i);

  }

  return result;

}//getDigits()

/*----------------------------------------------------------------------------------------------
                             Testa digitos verificadores de CPF
-----------------------------------------------------------------------------------------------*/
function cpfOk(digits) {
  
  for (let j = 0; j < 2; j++) {

    let sum = 0;

    for (let i = 0, end = (9 + j); i < end; i++) { sum += parseInt(digits.charAt(i)) * (10 + j - i); }//for i

    let resto = (sum * 10) % 11; if (resto > 9) resto = 0;

    if (resto !== parseInt(digits.charAt(9 + j))) return false;

  }//for j

  return true;

}//cpfOk()

/*----------------------------------------------------------------------------------------------
                             Testa digitos verificadores de CNPJ
-----------------------------------------------------------------------------------------------*/
function cnpjOk(digits) {

  for (let j = 0; j < 2; j++) {
  
    let sum = 0, start = 5 + j, change = 4 + j;

    for (let i = 0, end = (12 + j); i < end; i++) {

      if (i === change) start = 13 + j;

      sum += parseInt(digits.charAt(i)) * (start - i); 

    }//for i

    let resto = sum % 11; resto = (resto < 2) ? 0 : resto = (11 - resto);

    if (resto !== parseInt(digits.charAt(12 + j))) return false;

  }//for j

  return true;

}//cnpjOk()

/*----------------------------------------------------------------------------------------------
                                    Valida CPF ou CNPJ
-----------------------------------------------------------------------------------------------*/
function cpfCnpjOk(cpfCnpj) {

  let digits = getDigits(cpfCnpj);//Exclui do numero tudo que nao for digito

  if (digits === "") return true;//Campo nao preenchido eh valido

  if (CPF_PATTERN.test(cpfCnpj)) {

    if (cpfOk(digits)) {

      return true;

    }
    else {

      alert(cpfCnpj + " é um número de CPF inválido!");
      return false;

    }

  }else {

    if (cnpjOk(digits)) {

      return true;

    }
    else {

      alert(cpfCnpj + " é um número de CNPJ inválido!");
      return false;

    }

  }//if-else

}//cpfCnpjOk()

/*----------------------------------------------------------------------------------------------
                        Formata o num. de bytes com pontos de milhares
-----------------------------------------------------------------------------------------------*/ 
function formatNumberOfBytes(numberOfBytes) {

  let result = "", count = 0;

  for (let i = numberOfBytes.length - 1; i >= 0; i--) {

    count++;

    result = numberOfBytes.charAt(i) + result;

    if (((count % 3) === 0) && (i > 0)) result = "." + result;

  }

  return result + " bytes";

}//formatNumberOfBytes()

/*----------------------------------------------------------------------------------------------
     Valida os arquivos para upload. Apenas arquivos jpg ateh MAX_FILE_SIZE sao permitidos
-----------------------------------------------------------------------------------------------*/

let elementTemp = document.getElementById("MAX_FILE_SIZE");

let MAX_FILE_SIZE_STR;

let MAX_FILE_SIZE;

//update.php carrega validation.js mas nao possui elemento HTML com id = MAX_FILE_SIZE
if (elementTemp !== null) {

  MAX_FILE_SIZE_STR = formatNumberOfBytes(elementTemp.value);

  MAX_FILE_SIZE = parseInt(elementTemp.value);

}

function jpgFilesOk() {

  jpgErrorMsg = " \u2190 Tipo de arquivo inválido!\n\nSelecione apenas arquivos JPEG.\n\n(Extensão .jpg ou .jpeg)";

  sizeErrorMsg = 
    " \u2190 Arquivo excede limite!\n\n\Selecione apenas arquivos menores que " + MAX_FILE_SIZE_STR + ".";

  //MAIN_IMAGE eh required em preview.php e complete.php mas nao existe este input em upload.php
  if (MAIN_IMAGE !== null) { 

    if (MAIN_IMAGE.files[0].type !== "image/jpeg") {

      alert(MAIN_IMAGE.files[0].name + jpgErrorMsg);
      return false;

    }else if (MAIN_IMAGE.files[0].size >= MAX_FILE_SIZE) {

      let filesize = formatNumberOfBytes(MAIN_IMAGE.files[0].size + "");

      alert(MAIN_IMAGE.files[0].name + " = " + filesize + sizeErrorMsg);
      return false;

    }//if-else

  }//if (MAIN_IMAGE !== null)

  if (MORE_IMAGES !== null) {
  
    if (typeof(MORE_IMAGES.files[0]) === "undefined") return true;

    for (let i = 0, length = MORE_IMAGES.files.length; i < length; i++) {

      if (MORE_IMAGES.files[i].type !== "image/jpeg") {

        alert(MORE_IMAGES.files[i].name + jpgErrorMsg);
        return false;
    
      }else if (MORE_IMAGES.files[i].size >= MAX_FILE_SIZE) {

        let filesize = formatNumberOfBytes(MORE_IMAGES.files[0].size + "");

        alert(MORE_IMAGES.files[i].name + " = " + filesize + sizeErrorMsg);
        return false;
    
      }//if-else

    }//for

  }//if (MORE_IMAGES !== null)
  
  return true;

}//jpgFilesOk()

/*----------------------------------------------------------------------------------------------
                           Valida os dados do formulario em complete.php
-----------------------------------------------------------------------------------------------*/
function validate_jpg_cpfcnpj() {

  if (jpgFilesOk() && cpfCnpjOk(CPF_CNPJ.value)) { 
    
    waitForTheUpload();
    return true; 

  }
  else { 

    return false;
  }

}//validateF_jpg_cpfcnpj()

/*----------------------------------------------------------------------------------------------
                           Valida os dados do formulario em update.php
-----------------------------------------------------------------------------------------------*/
function validate_cpfcnpj() {

  if (cpfCnpjOk(CPF_CNPJ.value)) { 
    
    waitForTheUpload();
    return true; 

  }
  else { 

    return false;
  }

}//validate_cpfcnpj()

/*----------------------------------------------------------------------------------------------
                           Valida os dados do formulario preview.php
-----------------------------------------------------------------------------------------------*/
function validate_jpg() {

  if (jpgFilesOk()) { 

    waitForTheUpload();
    return true; 

  }
  else { 

    return false;
  }

}//validate_jpg()