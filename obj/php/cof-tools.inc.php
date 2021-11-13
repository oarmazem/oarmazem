<?php declare(strict_types=1);


/*[01]---------------------------------------------------------------------------------------------
            Lista reliquias de um determinado tipo e nao vendidas em uma pagina
------------------------------------------------------------------------------------------------*/
function listCofs() {

  $conn = connect();

  $stmt = $conn->prepare("SELECT id, product_data, price FROM cofs WHERE (typ = $type AND vendido = 0)");

  $stmt->execute();

  $result = $stmt->fetchAll(); 

  $numberOfLines = count($result); 

  if ($numberOfLines === 0) throw new PDOException("Nenhum artigo ainda nesta seção!");

  for ($i = 0; $i < $numberOfLines; $i++) {

    $cod = $result[$i]['id']; $nome = $result[$i]['product_data']; 
    $preco = $result[$i]['price']; $preco = number_format((float)$preco, 2, ',', '.');

    $pathname = getMainFilename((int)$cod);

    echo 
    "<figure id=\"$cod\">\n" . 
      "\t<a href=\"show-relic.php?type=$type&cod=$cod\">\n" .
        "\t\t<img src=\"$pathname\" alt=\"$cod\">\n" . 
      "\t</a>\n" .
      "\t<figcaption>\n" .
        "\t\t<p>$nome</p><br>\n" . 
        "\t\t<p>R$ $preco</p>\n" .
      "\t</figcaption>\n" . 
    "</figure>\n\n";

  }//for

}//listRelics()

class CofsTableHandler {

  const SQL = [
    
  "UPDATE cofs SET typ = :tipo, product_data = :nome, price = :venda, product_desc = :desc WHERE id = :cod" 
  ,
  "INSERT INTO cofs (typ, product_data, id, price, product_desc, next_img_index)" . 
  " VALUES(:tipo, :nome, :cod, :venda, :desc, :nextImgIndex )"

  ];  

  const UPDATE = 0;
  const INSERTINTO = 1;
  const UPLOAD = 2;

  private $mode; //0 indica que eh um objeto de UPDATE, 1 de INSERT INTO na tabela relics

  //Variaveis para armazenar campos de formulario
  private $uptime;
  public $tipo;
  public $nome;
  public $cod;
  public $venda; 
  public $desc;
  public $nextImgIndex;

  public $arrayTipo = ['', '', '', '', '', '', '', '', '', '', '', ''];

  private $conn;

  /*[01]--------------------------------------------------------------------------------------------
  *                                      Construtor da classe
  *-----------------------------------------------------------------------------------------------*/
  public function __construct(int $mode = self::UPLOAD) {

    $this->mode = $mode;
    $this->conn = connect();

  }//construtor

  /*[02]-------------------------------------------------------------------------------------------
  *                                       Destroi o objeto
  *-----------------------------------------------------------------------------------------------*/
  public function __destruct() {

    $this->conn = null;

  }//destruidor

  /*[03]--------------------------------------------------------------------------------------------
  *       Le os campos do formulario para os campos da classe e os formata de modo apropriado 
  *       para serem inseridas no BD
  *-----------------------------------------------------------------------------------------------*/
  public function readFormFields() {

    $this->tipo = trim($_POST['tipo']);
    $this->nome = trunc($_POST['nome'], 120);
    $this->cod =  trim($_POST['cod']);

    $this->venda = str_replace(',','.',trim($_POST['venda']));

    $this->desc = $_POST['desc'];

  }//readFormFields()

  /*[04]--------------------------------------------------------------------------------------------
  *       Executa uma instrucao SQL INSERT INTO ou UPDATE, fazendo o bind dos parametros com 
  *       campos da classe
  *-----------------------------------------------------------------------------------------------*/
  public function writeOnDatabase() {

    $this->readFormFields();

    $stmt = $this->conn->prepare(self::SQL[$this->mode]);

    $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
    $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
    $stmt->bindParam(':cod', $this->cod, PDO::PARAM_STR);
    $stmt->bindParam(':venda', $this->venda, PDO::PARAM_STR);
    $stmt->bindParam(':desc', $this->desc, PDO::PARAM_STR);

    //No UPDATE este campo nao eh atualizado. Por isso eh verficado se faz parte da instrucao SQL 
    if ($this->mode === self::INSERTINTO) $stmt->bindParam(':nextImgIndex', $this->nextImgIndex, PDO::PARAM_STR); 

    $stmt->execute();

  }//writeOnDatabase()

  /*[05]--------------------------------------------------------------------------------------------
  *                  Retorna colunas de uma linha da tabela relics onde id = $cod
  *-----------------------------------------------------------------------------------------------*/
  private function getColumns(string $columns, string $cod) : array {

    $stmt = $this->conn->prepare("SELECT $columns FROM relics WHERE id = $cod");

    $stmt->execute();

    $result = $stmt->fetchAll(); 

    if (count($result) === 0) throw new PDOException("Não foi encontrado artigo com código $cod!");

    return $result[0];

  }//getColumns()

  /*[06]--------------------------------------------------------------------------------------------
  *   Le os campos de um registro da tabela relics para as variaveis privadas e as formata de 
  *   modo apropriado para serem inseridas no formulario
  *-----------------------------------------------------------------------------------------------*/
  public function readDatabase(string $cod) {

    $line = $this->getColumns('*', $cod);

    $this->uptime = $line['uptime'];
    $this->tipo = $line['typ'];
    $this->nome = $line['product_data'];
    $this->cod = $line['id'];
    $this->venda = $line['price']; $this->venda = str_replace('.',',', $this->venda); 
    $this->desc = $line['product_desc'];

    for ($i = 0; $i < 12; $i++) { if ($i == ($this->tipo - 1)) $this->arrayTipo[$i] = "selected"; }


  }//readDatabase()

  /*[07]--------------------------------------------------------------------------------------------
  *          Obtem o campo next_img_index da tabela relics na linha com id = $cod
  *-----------------------------------------------------------------------------------------------*/ 
  public function getNextImgIndex(string $cod) : int {

    $line = $this->getColumns('next_img_index', $cod);

    return ((int)($line['next_img_index']));

  }//getNextImgIndex()

  /*[08]--------------------------------------------------------------------------------------------
  *          Seta o campo next_img_index da tabela relics na linha com id = $cod
  *-----------------------------------------------------------------------------------------------*/ 
  public function setNextImgIndex(int $nextIndex, string $cod) {

    $stmt = $this->conn->prepare("UPDATE cofs SET next_img_index = $nextIndex WHERE id = $cod");
    $stmt->execute();

  }//setNextImgIndex()
    
  /*[09]--------------------------------------------------------------------------------------------
  *          Deleta um registro da tabela relics e seus arquivos de imagem associados
  *-----------------------------------------------------------------------------------------------*/ 
  public function delete(string $cod) {

    $stmt = $this->conn->prepare("DELETE FROM cofs WHERE id = $cod");

    $stmt->execute();

    $pathnames = getFilesFromCode((int)$cod);

    if (basename($pathnames[0]) === "qmark.png") return;

    foreach($pathnames as $pathname) {

      if (!unlink($pathname)) echoMsg("Falha ao excluir " . basename($pathname));   

    }

  }//delete()

  /*[10]--------------------------------------------------------------------------------------------
  *                                  Escreve os dados do objeto
  *-----------------------------------------------------------------------------------------------*/   
  public function __toString() {

    $str = "<br> Data/hora de registro (horário do servidor) [ " . datetimeSqlToDatetimeBr($this->uptime) . " ]</p>";

    $str .= "<p> Identificação [ $this->nome - código: $this->cod - tipo: $this->tipo ]</p>";

    $str .= "<br><p> $this->desc</p>";

    return $str;

  }//__toString()

}//class RelicsHandler

?>