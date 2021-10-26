const MORE_IMAGES = document.getElementById("more_images");

const CPF_CNPJ = document.getElementById("cpf_cnpj");

/*----------------------------------------------------------------------------------------------
                                Valida os dados do formulario
-----------------------------------------------------------------------------------------------*/
function validateFormIndex(htmlForm) {

  if (jpgFilesOk() && cpfCnpjOk(CPF_CNPJ.value)) { 

    waitForTheUpload();
    return true; 

  }
  else { 

    return false;
  }

}//validateFormIndex()

