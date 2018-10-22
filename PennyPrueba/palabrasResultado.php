<html>
<head>
    <title>Tenemos tus palabras</title>
</head>
<body>
    <?php
        require_once "Palabra.php";

        $p1 = new Palabra($_POST["texto"]);

        echo "Ahora vamos a usar tu texto '".$_POST["texto"]."' para hacer operaciones:";echo "<br>";
        echo "<p>La palabra '".$_POST["contar"]."' sale ".$p1->contarPalabra($_POST["contar"])." veces</p>";
        echo "<p>La palabra '".$_POST["posiciones"]."' sale en las posiciones: ".implode(",",$p1->posicionPalabra($_POST["posiciones"]))."</p>";
        echo "<p>El resultado de cambiar las palabras en las posiciones ".$_POST["intPos1"]." por ".$_POST["intPos2"]." es:</p>";
        echo "<p>".$p1->intercambiarPalabras($_POST["intPos1"], $_POST["intPos2"]);
    ?>
</body>
</html>