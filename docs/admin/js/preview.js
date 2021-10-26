/*----------------------------------------------------------------------------------------------
                                Valida os dados do formulario
-----------------------------------------------------------------------------------------------*/
function validateFormPreview(htmlForm) {

  if (jpgFilesOk()) { 

    waitForTheUpload();
    return true; 

  }
  else { 

    return false;
  }

}//validateFormPreview()


