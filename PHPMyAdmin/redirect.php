<?php
/**
 * Created by PhpStorm.
 * User: Oscar
 * Date: 28/10/2018
 * Time: 21:52
 */

echo "Redirigiéndote a ";

if(isset($_POST["option"]))
{
    switch ($_POST["option"])
    {
        case "crearCliente":
            echo "creación de un nuevo cliente";
            header("Location: http://pennypan.devel:8080/formularios/formNuevoCliente.html");
            break;

        case "crearPan":
            echo "creación de un nuevo pan";
            header("Location: http://pennypan.devel:8080/formularios/formNuevoPan.html");
            break;

        case "cambiarCliente":
            echo "cambiar un cliente";
            header("Location: http://pennypan.devel:8080/formularios/formCambiarCliente.php");
            break;

        case "cambiarPan":
            echo "cambiar un pan";
            header("Location: http://pennypan.devel:8080/formularios/formCambiarPan.php");
            break;

        case "crearPedido":
            echo "crear un pedido";
            header("Location: http://pennypan.devel:8080/formularios/formCrearPedido.php");
            break;

        case "cambiarPedido":
            echo "cambiar un pedido";
            header("Location: http://pennypan.devel:8080/formularios/formCambiarPedido.php");
            break;
    }
}
else
    echo "la página de inicio";