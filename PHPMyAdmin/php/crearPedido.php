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
    $sentencia = $conexion->prepare("INSERT INTO ClientesPanes (IDCliente, IDPan, Cantidad) VALUES (?,?,?)");

    //Vinculamos los parámetros a las variables que vamos a modificar
    $sentencia->bind_param('iii', $idCliente, $idPan, $cantidad);

    //Ahora damos los valores
    $idCliente = $_POST["cliente"];
    $idPan = $_POST["pan"];
    $cantidad = $_POST["cantidad"];
    //Y ejecutamos
    if($sentencia->execute())
        echo "¡Pedido creado correctamente!";
    else
        echo "Algo fue mal :( ".$sentencia->error;

    $database->closeConnection();
}

echo "<br><br>";
echo "<a href='../index.html'>Ir a la página inicial</a>";

