<?php 

// config.php

spl_autoload_register(function($class_name){   // funcao anonima que recebe o nome da classe

	$filename = "Class".DIRECTORY_SEPARATOR.$class_name.".php";

	if (file_exists(($filename))) {

		require_once($filename);

	}



})

 ?>