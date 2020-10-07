<?php

error_reporting(0);
header('Content-type: application/json; charset=utf-8');

$conexion = new mysqli('localhost', 'root', 'root', 'ajax', '8889');

if($conexion->connect_errno){
	$respuesta = 
	['error'   => true];
	
} else {
	$conexion->set_charset("utf8");
	$stmt = $conexion->prepare("SELECT * FROM usuarios");
	$stmt->execute();
	$stmt->store_result();
    $stmt->bind_result($id, $nombre, $edad, $pais, $correo);
    // Si no hay error se inicializa un arreglo
    $respuesta = [];

	while($fila = $stmt->fetch()){
    	$usuario = [
            'id'     => $id,
            'nombre' => $nombre,
            'edad'   => $edad,
            'pais'   => $pais,
            'correo' => $correo
           ];
           // Se agrega al arreglo el usuario
       array_push($respuesta, $usuario);
    }
}
// Se genera un archivo JSON que viene con los valores de la BD
echo json_encode($respuesta);

?>