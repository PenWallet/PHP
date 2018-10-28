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
    $sentencia = $conexion->prepare("UPDATE Clientes 
                                            SET Nombre = ?, Apellidos = ?, FechaNac = ?, Ciudad = ?, Direccion = ?, Telefono = ? 
                                            WHERE ID = ?");
    $sentencia->bind_param('ssssssi', $nombre, $apellidos, $fechaNac, $ciudad, $direccion, $telefono, $id);

    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $fechaNac = $_POST["fechaNac"];
    $ciudad = $_POST["ciudad"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $id = $_POST["id"];

    if($sentencia->execute())
    {
        echo "¡El cliente ".$nombre." ".$apellidos." se ha cambiado con éxito!";
    }
    else
    {
        echo "Ha habido algún error :(";
    }

}

echo "<br><br>";
echo "<a href='../index.html'>Ir a la página inicial</a>";