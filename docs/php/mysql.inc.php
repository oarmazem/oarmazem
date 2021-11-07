<?php declare(strict_types=1);

define('DB_SERVERNAME', 'localhost');
define('DB_NAME', '305936');
//define('DB_USERNAME', '305936');
//define('DB_PASSWORD', 'phedrophedroca');

define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'eratostenes');


/*[01]--------------------------------------------------------------------------------------------
*                           Retorna uma conexao com o banco de dados
*-----------------------------------------------------------------------------------------------*/
function connect(

  string $dbServerName = DB_SERVERNAME,
  string $dbUserName = DB_USERNAME,
  string $dbPassword = DB_PASSWORD,
  string $dbName = DB_NAME

):PDO {

  $conn = new PDO("mysql:host=$dbServerName;dbname=$dbName", $dbUserName, $dbPassword);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  return $conn;

}//connect()

?>