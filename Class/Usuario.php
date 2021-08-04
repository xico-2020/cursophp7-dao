<?php 

class Usuario {

	// ----- Colunas dos dados da BD -----

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	// ------ GET -----

	public function getIdusuario(){
		return $this->idusuario;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}

	public function getDessenha(){
		return $this->dessenha;
	}

	public function getDtcadastro(){
		return $this->dtcadastro;
	}


// ------ SET -----

	public function setIdusuario($value){
		$this->idusuario = $value;
	}

	public function setDeslogin($value){
		$this->deslogin = $value;
	}

	public function setDessenha($value){
		$this->dessenha = $value;
	}

	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	}


public function loadById($id){  // metodo que recebe o $id.

	$sql = new Sql();  // usar a classe Sql

	$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));  //  coloca na variavel $results o valor do registo correspondente ao ID. array corresponde aos parametros (parameters da classe Sql). :ID (identificação do parametro) e o valor é o da variavel $id .

	// if (isset($results[0]))  // uma forma de validar se existe pelo menos um registo.

	if (count($results) > 0){

		$row = $results[0];  // Como é um array de arrays, coloca-se na posicao 0.

		/* Instrucoes substituidas pela linha abaixo, usa o metodo setData dado que o codigo é usado varias vezes.

		$this->setIdusuario($row['idusuario']);  // envia os dados para os seters. (preenchimento dos atributos, ou seja, carregar os dados da BD no objeto).
		$this->setDeslogin($row['deslogin']);
		$this->setDessenha($row['dessenha']);
		$this->setDtcadastro(new DateTime($row['dtcadastro']));  // instanciacao da classe DateTime para colocar no padrao dataHora.
		*/

		$this->setData($results[0]);

	}

}


public static function getList(){   // metodo estatico, nao precisa ser instanciado. Nao é usado o this-> . O this-> é usado quando atribuo valores a atributos, a chamar métodos, fico amarrado à classe (objeto). Nao usando posso usar o metodo dentro da classe mas tambem fora dela.

	$sql = new Sql();

	return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");

}


public static function search($login){

	$sql = new Sql();

	return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(':SEARCH'=>"%".$login."%"));
}


public function login($login, $password){

	$sql = new Sql();  

	$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
		":LOGIN"=>$login,
		"PASSWORD"=>$password
		 ));  //  coloca na variavel $results o valor do registo correspondente ao ID. array corresponde aos parametros (parameters da classe Sql). :ID (identificação do parametro) e o valor é o da variavel $id .

	// if (isset($results[0]))  // uma forma de validar se existe pelo menos um registo.

	if (count($results) > 0){

		$row = $results[0];  // Como é um array de arrays, coloca-se na posicao 0.

		/* Instrucoes substituidas pela linha abaixo, usa o metodo setData dado que o codigo é usado varias vezes.

		$this->setIdusuario($row['idusuario']);  // envia os dados para os seters. (preenchimento dos atributos, ou seja, carregar os dados da BD no objeto).
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			$this->setDtcadastro(new DateTime($row['dtcadastro']));  // instanciacao da classe DateTime para colocar no padrao dataHora.
		*/

		$this->setData($results[0]);

	} else {

		throw new Exception("Login e/ou senha inválidos!");


	}

}


public function setData($data){

	$this->setIdusuario($data['idusuario']);  // envia os dados para os seters. (preenchimento dos atributos, ou seja, carregar os dados da BD no objeto).
	$this->setDeslogin($data['deslogin']);
	$this->setDessenha($data['dessenha']);
	$this->setDtcadastro(new DateTime($data['dtcadastro']));  // instanciacao da classe DateTime para colocar no padrao dataHora.

}



public function insert(){

	$sql = new Sql();
	$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(  // Procedure dentro do select. Só passo dois parametros pois o ID é gerado automaticamente e a data vai buscar a do sistema. CALL no mySql, EXECUTE no SqlServer.
		':LOGIN'=>$this->getDeslogin(),
		':PASSWORD'=>$this->getDessenha()
	));  // Procedure com o select porque quando a procedure for executada no fim ela chama uma funcao que retorna o ID gerado na tabela. Esta procedure tem que ser criada na BD nas Stored Procedures com o mesmo nome.

	if (count($results) > 0) {

		$this->setData($results[0]);
	}


}


public function update($login, $password){

	$this->setDeslogin($login);
	$this->setDessenha($password);

	$sql = new Sql();

	$sql->execQuery("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
		':LOGIN'=>$this->getDeslogin(), 
		':PASSWORD'=>$this->getDessenha(),
		':ID'=>$this->getIdusuario()
	));

}


public function delete(){
	$sql = new Sql();
	$sql->execQuery("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
		':ID'=>$this->getIdusuario()
	));

	$this->setIdusuario(0);  // Se apagamos da BD vamos por a zero no objeto,
	$this->setDeslogin("");
	$this->setDessenha("");
	$this->setDtcadastro(new DateTime());

}

public function __construct($login = "", $password = ""){  // como é um metodo construtor, sempre que chamo a funcao usuario tenho que passar o login e a senha. Por forma a nao ser obrigatorio coloco = "" , e se nao passar os parametros é assumido vazio e nao da erro. 
	$this->setDeslogin($login);
	$this->setDessenha($password);
}



public function __toString()  // __toString -> metodo mágico que envia (faz um echo) dos dados para um json e mostra no ecran.
{
	return json_encode(array(
		"idusuario"=>$this->getIdusuario(),
		"deslogin"=>$this->getDeslogin(),
		"dessenha"=>$this->getDessenha(),
		"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
	));
}

}



 ?>