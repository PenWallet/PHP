<?php

require_once "ConsLibrosModel.php";


class LibroHandlerModel
{

    public static function getLibro($id, $queryStrings)
    {
        $listaLibros = null;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();


        //IMPORTANT: we have to be very careful about automatic data type conversions in MySQL.
        //For example, if we have a column named "cod", whose type is int, and execute this query:
        //SELECT * FROM table WHERE cod = "3yrtdf"
        //it will be converted into:
        //SELECT * FROM table WHERE cod = 3
        //That's the reason why I decided to create isValid method,
        //I had problems when the URI was like libro/2jfdsyfsd

        $valid = self::isValid($id);

        //If the $id is valid or the client asks for the collection ($id is null)
        if ($valid === true || $id == null)
        {
            $query = "SELECT " . \ConstantesDB\ConsLibrosModel::COD . ","
                . \ConstantesDB\ConsLibrosModel::TITULO . ","
                . \ConstantesDB\ConsLibrosModel::PAGS . " FROM " . \ConstantesDB\ConsLibrosModel::TABLE_NAME;


            if ($id != null)
                $query = $query . " WHERE " . \ConstantesDB\ConsLibrosModel::COD . " = ?";
            else if($queryStrings != null && (self::areGetQueryStringsValid($queryStrings)))
            {
                if(count($queryStrings) == 1)
                {
                    if(key($queryStrings) == "minpag")
                        $query = $query." WHERE numpag >= ?";
                    else
                        $query = $query." WHERE numpag <= ?";
                }
                else
                    $query = $query." WHERE numpag >= ? AND numpag <= ?";
            }

            $prep_query = $db_connection->prepare($query);

            //IMPORTANT: If we do not want to expose our primary keys in the URIS,
            //we can use a function to transform them.
            //For example, we can use hash_hmac:
            //http://php.net/manual/es/function.hash-hmac.php
            //In this example we expose primary keys considering pedagogical reasons

            if ($id != null)
                $prep_query->bind_param('s', $id);
            else if($queryStrings != null && self::areGetQueryStringsValid($queryStrings))
            {
                if(count($queryStrings) == 1)
                {
                    if(key($queryStrings) == "minpag")
                        $prep_query->bind_param('i', $queryStrings["minpag"]);
                    else
                        $prep_query->bind_param('i', $queryStrings["maxpag"]);
                }
                else
                    $prep_query->bind_param('ii', $queryStrings["minpag"], $queryStrings["maxpag"]);
            }

            $prep_query->execute();
            $listaLibros = array();

            //IMPORTANT: IN OUR SERVER, I COULD NOT USE EITHER GET_RESULT OR FETCH_OBJECT,
            // PHP VERSION WAS OK (5.4), AND MYSQLI INSTALLED.
            // PROBABLY THE PROBLEM IS THAT MYSQLND DRIVER IS NEEDED AND WAS NOT AVAILABLE IN THE SERVER:
            // http://stackoverflow.com/questions/10466530/mysqli-prepared-statement-unable-to-get-result

            $prep_query->bind_result($cod, $tit, $pag);
            while ($prep_query->fetch())
            {
                $tit = utf8_encode($tit);
                $libro = new LibroModel($cod, $tit, $pag);
                $listaLibros[] = $libro;
            }

//            $result = $prep_query->get_result();
//            for ($i = 0; $row = $result->fetch_object(LibroModel::class); $i++) {
//
//                $listaLibros[$i] = $row;
//            }
        }
        $db_connection->close();

        return sizeof($listaLibros) == 1 ? $listaLibros[0] : $listaLibros;
    }

    public static function deleteLibro($id)
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $filasAfectadas = -2;

        //IMPORTANT: we have to be very careful about automatic data type conversions in MySQL.

        $valid = self::isValid($id);

        //If the $id is valid or the client asks for the collection ($id is null)
        if ($valid === true && $id != null)
        {
            $query = "DELETE FROM libros WHERE codigo = ?";

            $prep_query = $db_connection->prepare($query);

            //IMPORTANT: If we do not want to expose our primary keys in the URIS,
            //we can use a function to transform them.
            //For example, we can use hash_hmac:
            //http://php.net/manual/es/function.hash-hmac.php
            //In this example we expose primary keys considering pedagogical reasons

            if ($id != null)
            {
                $prep_query->bind_param('i', $id);
            }

            $filasAfectadas = $prep_query->execute();

        }
        $db_connection->close();

        return $filasAfectadas;
    }

    public static function insertLibro($libro)
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $insertado = false;
        $filasAfectadas = 0;

        $query = "INSERT INTO libros (titulo, numpag) VALUES (?,?)";

        $prep_query = $db_connection->prepare($query);

        //IMPORTANT: If we do not want to expose our primary keys in the URIS,
        //we can use a function to transform them.
        //For example, we can use hash_hmac:
        //http://php.net/manual/es/function.hash-hmac.php
        //In this example we expose primary keys considering pedagogical reasons

        $prep_query->bind_param('si', $libro->titulo, $libro->numpag);

        $filasAfectadas = $prep_query->execute();

        if($filasAfectadas == 1)
            $insertado = true;
        else
            $insertado = false;

        $db_connection->close();

        return $insertado;
    }

    public static function updateLibro($libro)
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $actualizado = false;
        $filasAfectadas = 0;

        $query = "UPDATE libros SET titulo = ?, numpag = ? WHERE codigo = ?";

        $prep_query = $db_connection->prepare($query);

        //IMPORTANT: If we do not want to expose our primary keys in the URIS,
        //we can use a function to transform them.
        //For example, we can use hash_hmac:
        //http://php.net/manual/es/function.hash-hmac.php
        //In this example we expose primary keys considering pedagogical reasons

        $prep_query->bind_param('sii', $libro->titulo, $libro->numpag, $libro->codigo);

        $filasAfectadas = $prep_query->execute();

        if($filasAfectadas == 1)
            $actualizado = true;
        else
            $actualizado = false;

        $db_connection->close();

        return $actualizado;
    }

    //returns true if $id is a valid id for a book
    //In this case, it will be valid if it only contains
    //numeric characters, even if this $id does not exist in
    // the table of books
    public static function isValid($id)
    {
        $res = false;

        if (ctype_digit($id)) {
            $res = true;
        }
        return $res;
    }

    public static function areGetQueryStringsValid($queryStrings)
    {
        $validQueryNames = array("minpag", "maxpag");
        $valid = true;
        //$size = count($queryStrings);

        foreach($queryStrings as $clave => $valor)
        {
            if($valid)
            {
                if (!in_array($clave, $validQueryNames))
                    $valid = false;

                //Comprobamos que sean del tipo correcto
                if((($clave == "minpag" || $clave == "maxpag") && !is_numeric($valor)))
                    $valid = false;
            }
        }

        return $valid;

        /*
        foreach($queryStrings as $clave => $valor)
        {
            if($clave != "minpag" || $clave != "maxpag")
                $valid = false;

            //Separado por legibilidad
            if((($clave == "minpag" || $clave == "maxpag") && !is_numeric($valor)))
                $valid = false;
        }


        for($i = 0; $i < $size; $i++)
        {
            if(in_array())
                $valid = false;

            //Separado por legibilidad
            if((($clave == "minpag" || $clave == "maxpag") && !is_numeric($valor)))
                $valid = false;
        }*/
    }

}