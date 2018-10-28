<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cambiar un cliente</title>
</head>
<body>
    <h1>Elige qué cliente cambiar:</h1>
    <form action="../php/cambiarCliente.php" method="post" name="clienteForm">
        <select name="cliente">
            <?php
            require_once "../clases/Cliente.php";
            $resultado = Cliente::listaClientes();

            foreach($resultado as $id => $nombre)
            {
                echo "<option value=\"".$id."\">".$nombre."</option>";
            }
            ?>
        </select> <br>
        <input type="submit" value="A cambiarlo"/>
    </form>
</body>
</html>