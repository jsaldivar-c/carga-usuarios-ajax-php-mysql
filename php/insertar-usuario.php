<?php

error_reporting(0);
header('Content-type: application/json; charset=utf-8');
// Recibe esta informacion del main js 
$nombre = $_POST['nombre'];
$edad   = $_POST['edad'];
$pais   = $_POST['pais'];
$correo = $_POST['correo'];

function validarDatos($nombre, $edad, $pais, $correo){
	if($nombre == ''){
		return false;
	} elseif($edad == '' || is_int($edad)){
		return false;
	} elseif($pais == ''){
		return false;
	} elseif($correo == ''){
		return false;
	}
	return true;
}

if(validarDatos($nombre, $edad, $pais, $correo)){
	$conexion = new mysqli('localhost', 'root', 'root', 'ajax', '8889');
	$conexion->set_charset('utf8');

	if($conexion->connect_errno){
		$respuesta = ['error' => true];
	} else {
		$statement = $conexion->prepare("INSERT INTO usuarios(nombre, edad, pais, correo) VALUES(?,?,?,?)");
		//SISS (StringIntStringString)
		$statement->bind_param("siss", $nombre, $edad, $pais, $correo);
		$statement->execute();
		//Revisamos si las filas son menores o iguales a cero.
		if($conexion->affected_rows <= 0){
			$respuesta = ['error' => true];
		}
		// En caso de que todo este correcto creamos un arreglo vacio.
		$respuesta = [];
	}
} else {
	$respuesta = ['error' => true];
}

echo json_encode($respuesta);