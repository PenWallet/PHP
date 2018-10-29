<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cambia los datos del pan</title>
</head>
<body>
<h1>Cambia sus datos:</h1>
<form action="cambiarPanDB.php" method="post">
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
        $sentencia = $conexion->prepare("SELECT * FROM Panes WHERE ID = ?");
        $sentencia->bind_param('i', $_POST["pan"]);
        $sentencia->execute();
        $fila = $sentencia->get_result()->fetch_assoc();

        echo "ID: <input type=\"text\" name=\"id\" value=\"".$fila["ID"]."\" readonly=\"readonly\"/><br>";
        echo "Nombre: <input type=\"text\" name=\"nombre\" value=\"".$fila["Nombre"]."\"/><br>";
        echo "Crujenticidad:<br>";
        if($fila["Crujenticidad"] == 0)
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"0\" checked=\"true\">Como pan de molde<br>";
        else
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"0\">Como pan de molde<br>";

        if($fila["Crujenticidad"] == 1)
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"1\" checked=\"true\">Meh<br>";
        else
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"1\">Meh<br>";

        if($fila["Crujenticidad"] == 2)
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"2\" checked=\"true\">Arena de playa<br>";
        else
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"2\">Arena de playa<br>";

        if($fila["Crujenticidad"] == 3)
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"3\" checked=\"true\">*crunch crunch*<br>";
        else
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"3\">*crunch crunch*<br>";

        if($fila["Crujenticidad"] == 4)
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"4\" checked=\"true\">Igual que si pisaras un caracol<br>";
        else
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"4\">Igual que si pisaras un caracol<br>";

        if($fila["Crujenticidad"] == 5)
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"5\" checked=\"true\">El Jesucristo de lo crujiente<br><br>";
        else
            echo "<input type=\"radio\" name=\"crujenticidad\" value=\"5\">El Jesucristo de lo crujiente<br><br>";

        echo "¿Es integral?:<br>";
        if($fila["Integral"] == 0)
        {
            echo "<input type=\"radio\" name=\"integral\" value=\"1\">Sí<br>";
            echo "<input type=\"radio\" name=\"integral\" value=\"0\" checked=\"true\">No<br><br>";
        }
        else
        {
            echo "<input type=\"radio\" name=\"integral\" value=\"1\" checked=\"true\">Sí<br>";
            echo "<input type=\"radio\" name=\"integral\" value=\"0\">No<br><br>";
        }
        echo "Precio: <input type=\"text\" name=\"precio\" value=\"".$fila["Precio"]."\" step=\"0.01\" min=\"0\"/><br>";
    }

    $database->closeConnection();
    ?>
    <input type="submit" value="Cambiar Pan"/>
</form>
</body>
</html>