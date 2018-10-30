<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cambiar un cliente</title>
</head>
<body>
<h1>Introduce los datos que se piden:</h1><br>
    <form action="../php/crearPedido.php" method="post">
        <h2>Cliente que va a pedir:</h2><br>
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
        <h2>Pan que va a pedir</h2><br>
        <select name="pan">
            <?php
            require_once "../clases/Pan.php";
            $resultado = Pan::listaPanes();

            foreach($resultado as $id => $nombre)
            {
                echo "<option value=\"".$id."\">".$nombre."</option>";
            }
            ?>
        </select> <br>
        <h2>Introduce la cantidad:</h2>
        <input type="number" name="cantidad" step="1" min="0" value="0"/>
        <input type="submit" value="A cambiarlo"/>
    </form>

</body>
</html>