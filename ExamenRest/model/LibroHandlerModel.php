<?php

require_once "ConsLibrosModel.php";


class LibroHandlerModel
{

    public static function getLibro($id)
    {
        $listaLibros = null;
        $exists = false;

        $valid = self::isValid($id);
        if($valid)
            $exists = self::idExists($id);

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        //If the $id is valid or the client asks for the collection ($id is null)
        if (($valid === true && $exists) || $id == null)
        {
            $queryLibros = "SELECT L.codigo, L.titulo, L.numpag, C.ID FROM libros AS L INNER JOIN capitulos AS C ON L.codigo = C.IDLibro";

            if ($id != null) {
                $queryLibros = $queryLibros . "  WHERE L.codigo = ?";
            }

            $queryLibros = $queryLibros."  ORDER BY L.codigo";

            $prep_queryLibros = $db_connection->prepare($queryLibros);

            if ($id != null) {
                $prep_queryLibros->bind_param('s', $id);
            }

            $prep_queryLibros->execute();
            $listaLibros = array();

            //IMPORTANT: IN OUR SERVER, I COULD NOT USE EITHER GET_RESULT OR FETCH_OBJECT,
            // PHP VERSION WAS OK (5.4), AND MYSQLI INSTALLED.
            // PROBABLY THE PROBLEM IS THAT MYSQLND DRIVER IS NEEDED AND WAS NOT AVAILABLE IN THE SERVER:
            // http://stackoverflow.com/questions/10466530/mysqli-prepared-statement-unable-to-get-result

            $prep_queryLibros->bind_result($cod, $tit, $pag, $idCap);
            $codigoAnterior = null;
            while ($prep_queryLibros->fetch())
            {
                //Para distinguir si es un nuevo libro o no
                if($codigoAnterior == null)
                {
                    $codigoAnterior = $cod;
                    $arrayCapsURI = array();
                }

                //Si ha pasado a una nueva fila de un libro distinto, créame un array limpio de URIs de capítulos
                if($codigoAnterior != $cod)
                {
                    $arrayCapsURIParaGuardar = $arrayCapsURI;
                    $arrayCapsURI = array();
                }

                //Se mete en el array de URIs una nueva URI
                $arrayCapsURI[] = "/libro/".$cod."/capitulo/".$idCap;

                if($codigoAnterior != $cod)
                {
                    $tit = utf8_encode($tit);
                    $libro = new LibroModel($cod, $tit, $pag, $arrayCapsURIParaGuardar);
                    $listaLibros[] = $libro;
                }

                $codigoAnterior = $cod;
            }
            $libro = new LibroModel($cod, $tit, $pag, $arrayCapsURI);
            $listaLibros[] = $libro;

        }
        $db->closeConnection();

        return sizeof($listaLibros) == 1 ? $listaLibros[0] : $listaLibros;
    }

    //returns true if $id is a valid id for a book
    //In this case, it will be valid if it only contains
    //numeric characters, even if this $id does not exist in
    // the table of books
    public static function isValid($id)
    {
        $res = false;

        if (ctype_digit($id))
            $res = true;

        return $res;
    }

    public static function idExists($id)
    {
        $res = false;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $query = "SELECT codigo FROM libros WHERE codigo = ?";
        $prep_query = $db_connection->prepare($query);
        $prep_query->bind_param('s', $id);
        $prep_query->execute();
        $prep_query->bind_result($idComprobar);
        $prep_query->fetch();

        if($idComprobar == $id)
            $res = true;

        $db->closeConnection();

        return $res;
    }

}