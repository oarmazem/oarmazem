<?php declare(strict_types=1);

define('EXEMPLO', '&#10;Exemplos de formatos válidos:&#10;');

define('INTEGER_REGEXP', EXEMPLO . "12&#10;123&#10;1234\" pattern=\"\\s*\\d+\\s*");

define('CURRENCY_REGEXP', EXEMPLO . "12&#10;123&#10;123,45&#10;12345,67\" pattern=\"\\s*\\d+(,\\d{2})?\\s*");

define('DECIMAL_REGEXP', EXEMPLO . "12&#10;123,4&#10;123,45&#10;12,345\" pattern=\"\\s*\\d+(,\\d{1,3})?\\s*");

define('CPF_CNPJ_REGEXP', EXEMPLO . "&#10;001.002.003/12&#10;001.002.003-12&#10;01.002.003/0001-02&#10;01.002.003/0002-02\" pattern=\"\\s*((\\d{3}\\.\\d{3}\\.\\d{3}[/-]\\d{2})|(\\d{2}\\.\\d{3}\\.\\d{3}[/]000[01]-\\d{2}))\\s*");

define('LOG', true);

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
  string $openTags = '<!DOCTYPE html><html><body>',
  string $closeTags = '</body></html>'
) {

  if (!empty($openTags)) echo "$openTags\n";
  echo echoMsg($errMsg) . "\n";
  if (!empty($extraMsg)) echo echoMsg($extraMsg) . "\n";
  if (!empty($html)) echo "$html\n";
  if (!empty($closeTags)) echo "$closeTags";

  insertLog("ERRO: $errMsg");

  exit(1);

}//kill()

/*[07]--------------------------------------------------------------------------------------------
*           Aborta o script que chamou o metodo de redireciona a pagina indicada
*-----------------------------------------------------------------------------------------------*/
function redirectTo(string $url) {

  header("Location: $url");
  exit(0);

}//redirect()

/*[08]--------------------------------------------------------------------------------------------
*                                      Funcao de log
*-----------------------------------------------------------------------------------------------*/
function insertLog(string $msg) {

  if (!LOG) return;

  if (isset($_SERVER['REMOTE_ADDR'])) $ip = 'IP: '. $_SERVER['REMOTE_ADDR'] . "\n"; else $ip = "IP:\n";

  $date = date('d/m/Y h:i:sa') . "\n";
  
  $pointer = fopen(LOG_DIR . 'log.txt', 'a');
  flock($pointer, LOCK_EX);
  fwrite($pointer, "$ip$date$msg\n\n");
  flock($pointer, LOCK_UN);
  fclose($pointer);

}//insertLog()

/*[09]--------------------------------------------------------------------------------------------
*                        Retorna a string passada como parametro sem os acentos
*-----------------------------------------------------------------------------------------------*/
function remove_accents($string) {
  
  if ( !preg_match('/[\x80-\xff]/', $string) ) return strtolower($string);

  $chars = array(
  // Decompositions for Latin-1 Supplement
  chr(195).chr(128) => 'a', chr(195).chr(129) => 'a',
  chr(195).chr(130) => 'a', chr(195).chr(131) => 'a',
  chr(195).chr(132) => 'a', chr(195).chr(133) => 'a',
  chr(195).chr(135) => 'c', chr(195).chr(136) => 'e',
  chr(195).chr(137) => 'e', chr(195).chr(138) => 'e',
  chr(195).chr(139) => 'e', chr(195).chr(140) => 'i',
  chr(195).chr(141) => 'i', chr(195).chr(142) => 'i',
  chr(195).chr(143) => 'i', chr(195).chr(145) => 'n',
  chr(195).chr(146) => 'o', chr(195).chr(147) => 'o',
  chr(195).chr(148) => 'o', chr(195).chr(149) => 'o',
  chr(195).chr(150) => 'o', chr(195).chr(153) => 'u',
  chr(195).chr(154) => 'u', chr(195).chr(155) => 'u',
  chr(195).chr(156) => 'u', chr(195).chr(157) => 'y',
  chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
  chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
  chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
  chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
  chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
  chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
  chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
  chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
  chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
  chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
  chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
  chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
  chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
  chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
  chr(195).chr(191) => 'y',
  // Decompositions for Latin Extended-A
  chr(196).chr(128) => 'a', chr(196).chr(129) => 'a',
  chr(196).chr(130) => 'a', chr(196).chr(131) => 'a',
  chr(196).chr(132) => 'a', chr(196).chr(133) => 'a',
  chr(196).chr(134) => 'c', chr(196).chr(135) => 'c',
  chr(196).chr(136) => 'c', chr(196).chr(137) => 'c',
  chr(196).chr(138) => 'c', chr(196).chr(139) => 'c',
  chr(196).chr(140) => 'c', chr(196).chr(141) => 'c',
  chr(196).chr(142) => 'd', chr(196).chr(143) => 'd',
  chr(196).chr(144) => 'd', chr(196).chr(145) => 'd',
  chr(196).chr(146) => 'e', chr(196).chr(147) => 'e',
  chr(196).chr(148) => 'e', chr(196).chr(149) => 'e',
  chr(196).chr(150) => 'e', chr(196).chr(151) => 'e',
  chr(196).chr(152) => 'e', chr(196).chr(153) => 'e',
  chr(196).chr(154) => 'e', chr(196).chr(155) => 'e',
  chr(196).chr(156) => 'g', chr(196).chr(157) => 'g',
  chr(196).chr(158) => 'g', chr(196).chr(159) => 'g',
  chr(196).chr(160) => 'g', chr(196).chr(161) => 'g',
  chr(196).chr(162) => 'g', chr(196).chr(163) => 'g',
  chr(196).chr(164) => 'h', chr(196).chr(165) => 'h',
  chr(196).chr(166) => 'h', chr(196).chr(167) => 'h',
  chr(196).chr(168) => 'i', chr(196).chr(169) => 'i',
  chr(196).chr(170) => 'i', chr(196).chr(171) => 'i',
  chr(196).chr(172) => 'i', chr(196).chr(173) => 'i',
  chr(196).chr(174) => 'i', chr(196).chr(175) => 'i',
  chr(196).chr(176) => 'i', chr(196).chr(177) => 'i',
  chr(196).chr(178) => 'ij',chr(196).chr(179) => 'ij',
  chr(196).chr(180) => 'j', chr(196).chr(181) => 'j',
  chr(196).chr(182) => 'k', chr(196).chr(183) => 'k',
  chr(196).chr(184) => 'k', chr(196).chr(185) => 'l',
  chr(196).chr(186) => 'l', chr(196).chr(187) => 'l',
  chr(196).chr(188) => 'l', chr(196).chr(189) => 'l',
  chr(196).chr(190) => 'l', chr(196).chr(191) => 'l',
  chr(197).chr(128) => 'l', chr(197).chr(129) => 'l',
  chr(197).chr(130) => 'l', chr(197).chr(131) => 'n',
  chr(197).chr(132) => 'n', chr(197).chr(133) => 'n',
  chr(197).chr(134) => 'n', chr(197).chr(135) => 'n',
  chr(197).chr(136) => 'n', chr(197).chr(137) => 'n',
  chr(197).chr(138) => 'n', chr(197).chr(139) => 'n',
  chr(197).chr(140) => 'o', chr(197).chr(141) => 'o',
  chr(197).chr(142) => 'o', chr(197).chr(143) => 'o',
  chr(197).chr(144) => 'o', chr(197).chr(145) => 'o',
  chr(197).chr(146) => 'oe',chr(197).chr(147) => 'oe',
  chr(197).chr(148) => 'r',chr(197).chr(149) => 'r',
  chr(197).chr(150) => 'r',chr(197).chr(151) => 'r',
  chr(197).chr(152) => 'r',chr(197).chr(153) => 'r',
  chr(197).chr(154) => 's',chr(197).chr(155) => 's',
  chr(197).chr(156) => 's',chr(197).chr(157) => 's',
  chr(197).chr(158) => 's',chr(197).chr(159) => 's',
  chr(197).chr(160) => 's', chr(197).chr(161) => 's',
  chr(197).chr(162) => 't', chr(197).chr(163) => 't',
  chr(197).chr(164) => 't', chr(197).chr(165) => 't',
  chr(197).chr(166) => 't', chr(197).chr(167) => 't',
  chr(197).chr(168) => 'u', chr(197).chr(169) => 'u',
  chr(197).chr(170) => 'u', chr(197).chr(171) => 'u',
  chr(197).chr(172) => 'u', chr(197).chr(173) => 'u',
  chr(197).chr(174) => 'u', chr(197).chr(175) => 'u',
  chr(197).chr(176) => 'u', chr(197).chr(177) => 'u',
  chr(197).chr(178) => 'u', chr(197).chr(179) => 'u',
  chr(197).chr(180) => 'w', chr(197).chr(181) => 'w',
  chr(197).chr(182) => 'y', chr(197).chr(183) => 'y',
  chr(197).chr(184) => 'y', chr(197).chr(185) => 'z',
  chr(197).chr(186) => 'z', chr(197).chr(187) => 'z',
  chr(197).chr(188) => 'z', chr(197).chr(189) => 'z',
  chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
  );

  return strtr(strtolower($string), $chars);

}//remove_accents()

?>