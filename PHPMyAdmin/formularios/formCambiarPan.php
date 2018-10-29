<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cambiar un pan</title>
</head>
<body>
<h1>Elige qué pan cambiar:</h1>
<form action="../php/cambiarPan.php" method="post">
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
    <input type="submit" value="A cambiarlo"/>
</form>
</body>
</html>