<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cambia los datos del cliente</title>
</head>
<body>
<h1>Cambia sus datos:</h1>
<form action="cambiarClienteDB.php" method="post">
    <?php
    require_once "../Database.php";

    $nombreCompleto = null;
    $database = Database::getInstance();
    $conexion = $database->getConnection();

    if($conexion->connect_error)
    {
        trigger_error("Error al conectar a MySQL".$conexion->connect_error, E_USER_ERROR);
    }
    else
    {
        $sentencia = $conexion->prepare("SELECT * FROM Clientes WHERE ID = ?");
        $sentencia->bind_param('i', $_POST["cliente"]);
        $sentencia->execute();
        $fila = $sentencia->get_result()->fetch_assoc();

        echo "ID: <input type=\"text\" name=\"id\" value=\"".$fila["ID"]."\" readonly=\"readonly\"/><br>";
        echo "Nombre: <input type=\"text\" name=\"nombre\" value=\"".$fila["Nombre"]."\"/><br>";
        echo "Apellidos: <input type=\"text\" name=\"apellidos\" value=\"".$fila["Apellidos"]."\"/><br>";
        echo "Fecha de nacimiento: <input type=\"date\" name=\"fechaNac\" value=\"".$fila["FechaNac"]."\"/><br>";
        echo "Ciudad: <input type=\"text\" name=\"ciudad\" value=\"".$fila["Ciudad"]."\"/><br>";
        echo "Dirección: <input type=\"text\" name=\"direccion\" value=\"".$fila["Direccion"]."\"/><br>";
        echo "Teléfono: <input type=\"text\" name=\"telefono\" value=\"".$fila["Telefono"]."\"/><br>";
    }

    $database->closeConnection();
    ?>
    <input type="submit" value="Cambiar Cliente"/>
</form>
</body>
</html>