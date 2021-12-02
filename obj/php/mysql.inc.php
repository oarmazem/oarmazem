<?php declare(strict_types=1);

define('DB_SERVERNAME', 'localhost');
define('DB_NAME', '305936');
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

/*[02]--------------------------------------------------------------------------------------------
*                         Executa uma instrucao SELECT do SQL
*-----------------------------------------------------------------------------------------------*/
function sqlSelect(string $sqlSelect, PDO $c = null) : array {

  try {

    if ($c === null) { 
      $conn = connect();
      $stmt = $conn->prepare($sqlSelect);
    }
    else
     $stmt = $c->prepare($sqlSelect);

    $stmt->execute();

    return $stmt->fetchAll(); 

  }
  finally {

    $conn = null;

  }

}//sqlSelect()

/*[03]--------------------------------------------------------------------------------------------
*                        Registra dados do acesso a uma pagina do site
*-----------------------------------------------------------------------------------------------*/
function trace(string $pg) {
  
  if (isset($_SERVER['REMOTE_ADDR'])) {

    $ip = $_SERVER['REMOTE_ADDR'];

    if (isset($_SERVER['HTTP_USER_AGENT'])) {

      $user_agent = $_SERVER['HTTP_USER_AGENT'];

    }
    else $user_agent = '';

    try {

      $conn = connect();

      $stmt = $conn->prepare("INSERT INTO acess (ip, user_agent, pg) VALUES(:ip, :user_agent, :pg)");

      $stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
      $stmt->bindParam(':user_agent', $user_agent, PDO::PARAM_STR);
      $stmt->bindParam(':pg', $pg, PDO::PARAM_STR);

      $stmt->execute();

    }
    catch (PDOException $e) { }
    
    finally { $conn = null; }

  }//if

}//trace()

?>