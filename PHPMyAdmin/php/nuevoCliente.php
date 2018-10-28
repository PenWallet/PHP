<?php
/**
 * Created by PhpStorm.
 * User: Oscar
 * Date: 28/10/2018
 * Time: 22:06
 */

require_once "../Database.php";
$database = Database::getInstance();

$conexion = $database->getConnection();

if($conexion->connect_error)
{
    trigger_error("Error al conectar a MySQL".$conexion->connect_error, E_USER_ERROR);
}
else
{
    //Preparamos la sentencia
    $sentencia = $conexion->prepare("INSERT INTO Clientes (Nombre, Apellidos, FechaNac, Ciudad, Direccion, Telefono) VALUES (?,?,?,?,?,?)");

    //Vinculamos los parámetros a las variables que vamos a modificar
    $sentencia->bind_param('ssssss', $nombre, $apellidos, $fechaNac, $ciudad, $direccion, $telefono);

    //Ahora damos los valores
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $fechaNac = $_POST["fechaNac"];
    $ciudad = $_POST["ciudad"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    //Y ejecutamos
    if($sentencia->execute())
        echo "¡El cliente ".$nombre." ".$apellidos." se ha introducido correctamente!";
    else
        echo "Algo fue mal :(";

    $database->closeConnection();
}

echo "<br><br>";
echo "<a href='../index.html'>Ir a la página inicial</a>";

