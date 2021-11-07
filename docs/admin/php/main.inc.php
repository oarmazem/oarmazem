<?php declare(strict_types=1);

define('EXEMPLO', '&#10;Exemplos de formatos válidos:&#10;');

define('INTEGER_REGEXP', EXEMPLO . "12&#10;123&#10;1234\" pattern=\"\\s*\\d+\\s*");

define('CURRENCY_REGEXP', EXEMPLO . "12&#10;123&#10;123,45&#10;12345,67\" pattern=\"\\s*\\d+(,\\d{2})?\\s*");

define('EMPTY_QUERY_RESULT', 'Consulta retornou 0 registros!');

/*[00]--------------------------------------------------------------------------------------------
*         Retorna o primeiro dado encontrado em uma consulta para um unico campo do BD            
*-----------------------------------------------------------------------------------------------*/
function getFirstFieldFounded(string $field, string $table, string $clause) : string {

  try {
    
    $conn = connect();

    //$field deve especificar apenas um campo do banco de dados
    $stmt = $conn->prepare("SELECT $field FROM $table WHERE $clause");
    $stmt->execute();

    $result = $stmt->fetchAll(); 
      
    if (count($result) === 0) throw new PDOException(EMPTY_QUERY_RESULT);

    return ($result[0][$field]);

  }
  finally {

    $conn = null;

  }

}//getFirstFieldFounded()
 
/*[01]--------------------------------------------------------------------------------------------
*          Retorna true se o campo eh string vazia ou so com espacos em branco
*-----------------------------------------------------------------------------------------------*/
function emptyField(string $field) : bool {

  return (trim($_POST[$field]) === '');

}//emptyField()

/*[02]--------------------------------------------------------------------------------------------
*                                  Trunca uma string
*-----------------------------------------------------------------------------------------------*/
function trunc(string $str, int $length) : string {

  if ($length > strlen($str)) return $str;

  return substr($str, 0, $length);

}//trunc()


?>