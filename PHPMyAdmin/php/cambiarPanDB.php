<?php
/**
 * Created by PhpStorm.
 * User: Oscar
 * Date: 29/10/2018
 * Time: 00:33
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
    $sentencia = $conexion->prepare("UPDATE Panes 
                                            SET Nombre = ?, Crujenticidad = ?, Integral = ?, Precio = ?
                                            WHERE ID = ?");
    $sentencia->bind_param('siidi', $nombre, $crujenticidad, $integral, $precio, $id);

    $nombre = $_POST["nombre"];
    $crujenticidad = $_POST["crujenticidad"];
    $integral = $_POST["integral"];
    $precio = $_POST["precio"];
    $id = $_POST["id"];

    if($sentencia->execute())
    {
        echo "¡El pan '".$nombre."' se ha cambiado con éxito!";
    }
    else
    {
        echo "Ha habido algún error :(";
    }

}

echo "<br><br>";
echo "<a href='../index.html'>Ir a la página inicial</a>";