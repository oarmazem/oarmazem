<?php declare(strict_types=1);

/*[01]--------------------------------------------------------------------------------------------
*                             Obtem a senha administrativa do site
*-----------------------------------------------------------------------------------------------*/
function getAdminPassword() : string {

  try {
    
    return getFirstFieldFounded('pass', 'authentic', 'TRUE');

  }
  catch (PDOException $e) {

    $errMsg = $e->getMessage();

    if ($errMsg === EMPTY_QUERY_RESULT) 

      echoMsg('Não há senha registrada no banco de dados!');

    else

      echoMsg($errMsg);  

    exit(1);

  }

}//getAdminPassword()

/*[02]--------------------------------------------------------------------------------------------
*     Se encontrou o cookie e a senha confere, retorna TRUE. Caso contrario retorna FALSE
*-----------------------------------------------------------------------------------------------*/
function adminPasswordOk() {

  if (isset($_COOKIE['login_armazem'])) {

    return ($_COOKIE['login_armazem'] === getAdminPassword()); 

  }

  return false;

}//adminPasswordOk()

?>