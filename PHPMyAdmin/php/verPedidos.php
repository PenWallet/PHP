<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cambiar un cliente</title>
</head>
<body>
<?php
require_once "../clases/Pedidos.php";
require_once "../Database.php";

$cantidad = Pedidos::cantidadPedidos();

if($cantidad != 0)
{
    echo"<h1>Estos son los pedidos que hay en la base de datos:</h1>";

    $database = Database::getInstance();
    $conexion = $database->getConnection();

    if ($conexion->connect_error)
            trigger_error("Error al conectar a MySQL" . $conexion->connect_error, E_USER_ERROR);
    else
    {
        $sentencia = $conexion->prepare("SELECT C.ID AS IDPersona, C.Nombre AS NombrePersona, C.Apellidos, P.ID AS IDPan, P.Nombre AS NombrePan, CP.Cantidad, P.Precio 
                                    FROM `ClientesPanes` AS CP 
                                      INNER JOIN Panes AS P 
                                        ON CP.IDPan = P.ID 
                                      INNER JOIN Clientes AS C 
                                        ON CP.IDCliente = C.ID
                                    ORDER BY C.ID");
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $idPersona = 0;

        while($fila = $resultado->fetch_assoc())
        {
            if($idPersona != $fila["IDPersona"])
            {
                if($idPersona != 0)
                {
                    $total = Pedidos::facturaDeCliente($idPersona);
                    echo "....................<br>";
                    echo "TOTAL: ".$total."€<br><br>";
                }
                $idPersona = $fila["IDPersona"];

                echo "<h2>El cliente ".$fila["NombrePersona"]." ".$fila["Apellidos"]." ha pedido:</h2>";
            }

            echo $fila["Cantidad"]."x ".$fila["NombrePan"]."......................".$fila["Precio"]*$fila["Cantidad"]."€ (p/u: ".$fila["Precio"]."€)<br>";
        }

        $total = Pedidos::facturaDeCliente($idPersona);
        echo "....................<br>";
        echo "TOTAL: ".$total."€<br><br>";

        $database->closeConnection();
    }
}
else
    echo "¡No hay ningún pedido en la base de datos!";

?>

<br><br>
<a href='../index.html'>Ir a la página inicial</a>
</body>
</html>
