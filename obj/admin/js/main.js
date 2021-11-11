const SUBMIT = document.querySelector("input[type='submit']");

const DELETE = document.getElementById("delete");

/*----------------------------------------------------------------------------------------------
                       Vai para a pagina inicial da secao de admnistracao
-----------------------------------------------------------------------------------------------*/
function gotoAdminPage() {

  window.open("admin.php", "_self");

}//gotoAdminPage()

/*----------------------------------------------------------------------------------------------
                Vai para a pagina de busca de artigos por numero de codigo
-----------------------------------------------------------------------------------------------*/
function gotoSearchPage(target) {

  window.open("search.php?target=" + target, "_self");

}//gotoSearchPage()

/*----------------------------------------------------------------------------------------------
                     Marca um registro para ser excluido do banco de dados
-----------------------------------------------------------------------------------------------*/
function del() {

  if (DELETE.checked) {

    alert('CUIDADO! Marcar esta opção permitirá excluir o registro.\n\nSe campos inválidos não permitirem excluir, use o botão REDEFINIR\ne tente novamente.');

    SUBMIT.style.backgroundColor = 'red';
    SUBMIT.value = 'EXCLUIR';

  }
  else {

    SUBMIT.style.backgroundColor = 'lightgreen';
    SUBMIT.value = 'ATUALIZAR';

  }

}//del()

/*----------------------------------------------------------------------------------------------
                                Reseta botão ATUALIZAR (submit)
-----------------------------------------------------------------------------------------------*/
function reset() {

  SUBMIT.style.backgroundColor = 'lightgreen';
  SUBMIT.value = 'ATUALIZAR';

}//reset()