<?php declare(strict_types=1);

define('EXEMPLO', '&#10;Exemplos de formatos válidos:&#10;');

define('INTEGER_REGEXP', EXEMPLO . "12&#10;123&#10;1234\" pattern=\"\\s*\\d+\\s*");

define('CURRENCY_REGEXP', EXEMPLO . "12&#10;123&#10;123,45&#10;12345,67\" pattern=\"\\s*\\d+(,\\d{2})?\\s*");

define('DECIMAL_REGEXP', EXEMPLO . "12&#10;123,4&#10;123,45&#10;12,345\" pattern=\"\\s*\\d+(,\\d{1,3})?\\s*");

define('CPF_CNPJ_REGEXP', EXEMPLO . "&#10;001.002.003/12&#10;001.002.003-12&#10;01.002.003/0001-02&#10;01.002.003/0002-02\" pattern=\"\\s*((\\d{3}\\.\\d{3}\\.\\d{3}[/-]\\d{2})|(\\d{2}\\.\\d{3}\\.\\d{3}[/]000[01]-\\d{2}))\\s*");

/*[01]--------------------------------------------------------------------------------------------
*                              Escreve uma mensagem na pagina.
*-----------------------------------------------------------------------------------------------*/
function echoMsg(
  string $msg, 
  string $css = 'text-align: center; font-size: 1.3vw; color: black;'  
) {

  echo '<br><p style="' . $css . '">' . $msg . '</p>';

}//echoMsg()
 
/*[02]--------------------------------------------------------------------------------------------
*          Retorna true se o campo eh string vazia ou so com espacos em branco
*-----------------------------------------------------------------------------------------------*/
function emptyField(string $field) : bool {

  return (trim($_POST[$field]) === '');

}//emptyField()

/*[03]--------------------------------------------------------------------------------------------
*                                  Trunca uma string
*-----------------------------------------------------------------------------------------------*/
function trunc(string $str, int $length) : string {

  if ($length > strlen($str)) return $str;

  return substr($str, 0, $length);

}//trunc()

/*[04]--------------------------------------------------------------------------------------------
*                                  Formata uma data
*-----------------------------------------------------------------------------------------------*/
function dateSqlToDateBr(string $date) : string {

  if (empty($date)) return '';

  return (substr($date, 8, 2) . '-' . substr($date, 5, 3) . substr($date, 0, 4));

}//dateSqlToDateBr()

/*[05]--------------------------------------------------------------------------------------------
*                                  Formata uma data
*-----------------------------------------------------------------------------------------------*/
function datetimeSqlToDatetimeBr(string $datetime) : string {

  if (empty($datetime)) return '';

  return (dateSqlToDateBr(substr($datetime, 0, 10)) . substr($datetime, 10, 9));

}//datetimeSqlToDatetimeBr()

/*[06]--------------------------------------------------------------------------------------------
*                     Encerra um script com msg de erro e tags de fechamento
*-----------------------------------------------------------------------------------------------*/
function kill(
  string $errMsg,
  string $extraMsg = '', 
  string $html = '', 
  string $openTags = '<html><body>',
  string $closeTags = '</body></html>'
) {

  if (!empty($openTags)) echo "$openTags\n";
  echo echoMsg($errMsg) . "\n";
  if (!empty($extraMsg)) echo echoMsg($extraMsg) . "\n";
  if (!empty($html)) echo "$html\n";
  if (!empty($closeTags)) echo "$closeTags";

  exit(1);

}//kill()

/*[07]--------------------------------------------------------------------------------------------
*           Aborta o script que chamou o metodo de redireciona a pagina indicada
*-----------------------------------------------------------------------------------------------*/
function redirectTo(string $url) {

  header("Location: $url");
  exit(0);

}//redirect()

?>