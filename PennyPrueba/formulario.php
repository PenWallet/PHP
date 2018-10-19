<html>
<head>
    <title>Tenemos tus datos</title>
</head>
<body>
    Bonjour, <?php echo $_POST["nombre"]; ?><br>
    Ton e-mail est <?php echo $_POST["email"]; ?><br>
    Et ton gender est
    <?php
        switch($_POST["genero"])
        {
            case "hombre": echo "Macho ibérico"; echo '<body style="background-color:cornflowerblue">';
            break;

            case "mujer": echo "Macha ibérica"; echo '<body style="background-color:hotpink">';
            break;

            case "apache": echo "Apache ibérico"; echo '<body style="background-color:lightgray">';
            break;

            default: echo "No existes"; echo '<body style="background-color:red">';
        }
    ?><br>
</body>
</html>