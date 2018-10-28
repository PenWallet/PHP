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
    $sentencia = $conexion->prepare("INSERT INTO Panes (Nombre, Crujenticidad, Integral, Precio) VALUES (?,?,?,?)");

    //Vinculamos los parámetros a las variables que vamos a modificar
    $sentencia->bind_param('siid', $nombre, $crujenticidad, $integral, $precio);

    //Ahora damos los valores
    $nombre = $_POST["nombre"];
    $crujenticidad = $_POST["crujenticidad"];
    $integral = $_POST["integral"];
    $precio = $_POST["precio"];
    //Y ejecutamos
    if($sentencia->execute())
        echo "¡El pan '".$nombre."' se ha introducido correctamente!";
    else
        echo "Algo fue mal :(";

    $database->closeConnection();
}

echo "<br><br>";
echo "<a href='../index.html'>Ir a la página inicial</a>";