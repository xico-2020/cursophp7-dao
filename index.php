<?php 

// index.php

require_once("config.php");

/*  ---- Primeiro exemplo DAO - CLASSE Sql - Lista registos ----
$sql = new Sql();  // como ja sabe encontrar as pastas e ficheiros entao crio a variavel $sql que instancia a classe Sql (Sql.php).


$usuarios = $sql->select("SELECT * FROM tb_usuarios");  //  Aqui mando executar um comando da Base de Dados. Crio a variavel $usuarios que recebe os dados do select.

echo json_encode($usuarios); // mostra os dados no ecran.

foreach ($usuarios as $row) { // Para percorrer os dados. Como Key Value do foreach temos $row que é do primeiro array)

    foreach ($row as $key => $value) {  // para obter o Key Value de cada um temos outro foreach ao $row. Key será o nome do campo.

        echo "<strong>".$key.":</strong>".$value."<br/>";

    }

    echo "====================================================<br>";

}
*/




/*  ---- Segundo exemplo DAO - CLASSE Usuario - Lista um registo especifico ----


$root = new Usuario();
$root->loadById(4);

echo $root;
*/
/*  ---- Terceiro exemplo DAO - CLASSE Usuario - Lista todos os registos ----

$lista = Usuario::getList();  // como getList é metodo estatico chamo diretamente sem ser necessario instanciar.

echo json_encode($lista);
*/

/*  ---- Quarto exemplo DAO - CLASSE Usuario - Lista de usuarios com pesquisa por login ----


$search = Usuario::search("Au");
echo json_encode($search);
*/

/*  ---- Quinto exemplo DAO - CLASSE Usuario - Carrega um usuario usando o login e a senha ----
*/

$usuario = new Usuario();
$usuario->login("mario", "panhanhas");

echo $usuario;

?>