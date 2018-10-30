<?php
/**
 * Created by PhpStorm.
 * User: Oscar
 * Date: 30/10/2018
 * Time: 17:18
 */
require_once "../Database.php";

class Pedidos
{
    public static function cantidadPedidos()
    {
        $database = Database::getInstance();
        $conexion = $database->getConnection();
        $cantidad = 0;

        if ($conexion->connect_error) {
            trigger_error("Error al conectar a MySQL" . $conexion->connect_error, E_USER_ERROR);
        } else {
            //Preparamos la sentencia
            $sentencia = $conexion->prepare("SELECT COUNT(DISTINCT IDCliente) AS Cantidad FROM ClientesPanes");
            $sentencia->execute();

            $result = $sentencia->get_result();
            if ($fila = $result->fetch_assoc())
                $cantidad = $fila["Cantidad"];
        }

        return $cantidad;
    }

    public static function facturaDeCliente($idCliente)
    {
        $database = Database::getInstance();
        $conexion = $database->getConnection();
        $cantidad = 0;

        if ($conexion->connect_error) {
            trigger_error("Error al conectar a MySQL" . $conexion->connect_error, E_USER_ERROR);
        } else {
            //Preparamos la sentencia
            $sentencia = $conexion->prepare("SELECT SUM(CP.Cantidad*P.Precio) AS Factura 
                                                    FROM ClientesPanes AS CP 
                                                      INNER JOIN Panes AS P 
                                                        ON CP.IDPan = P.ID 
                                                    WHERE IDCliente = ?");
            $sentencia->bind_param('i', $id);
            $id = $idCliente;
            $sentencia->execute();

            $result = $sentencia->get_result();
            if ($fila = $result->fetch_assoc())
                $cantidad = $fila["Factura"];
        }

        return $cantidad;
    }
}