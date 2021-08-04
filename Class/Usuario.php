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

		$this->setIdusuario($row['idusuario']);  // envia os dados para os seters. (preenchimento dos atributos, ou seja, carregar os dados da BD no objeto).
		$this->setDeslogin($row['deslogin']);
		$this->setDessenha($row['dessenha']);
		$this->setDtcadastro(new DateTime($row['dtcadastro']));  // instanciacao da classe DateTime para colocar no padrao dataHora.

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

		$this->setIdusuario($row['idusuario']);  // envia os dados para os seters. (preenchimento dos atributos, ou seja, carregar os dados da BD no objeto).
		$this->setDeslogin($row['deslogin']);
		$this->setDessenha($row['dessenha']);
		$this->setDtcadastro(new DateTime($row['dtcadastro']));  // instanciacao da classe DateTime para colocar no padrao dataHora.

	} else {

		throw new Exception("Login e/ou senha inválidos!");


	}




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