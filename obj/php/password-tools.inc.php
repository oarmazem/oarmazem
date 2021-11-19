<?php declare(strict_types=1);

/*[01]--------------------------------------------------------------------------------------------
*                             Obtem a senha administrativa do site
*-----------------------------------------------------------------------------------------------*/
function getAdminPassword() : string {

  $result = sqlSelect('SELECT pass FROM authentic WHERE TRUE'); 
    
  if (count($result) === 0) throw new PDOException('Não há senha de acesso registrada no banco de dados!');

  return $result[0]['pass'];

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