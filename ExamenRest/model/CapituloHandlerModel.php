<?php

class CapituloHandlerModel
{

    public static function getCapitulo($idLibro, $idCapitulo)
    {
        $lista = null;

        $validLibro = self::isValid($idLibro);
        if($validLibro)
        {
            $existsLibro = self::idLibroExists($idLibro);
            $validCap = self::isValid($idCapitulo);
            if($validCap)
                $existsCap = self::idCapituloExists($idLibro, $idCapitulo);
        }

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        //Si ambas ID son válidas y existen, o si se ha pedido la colección de capítulos de un libro válido y existente
        if (($validLibro && $validCap && $existsCap && $existsLibro) || ($idCapitulo == null && $validLibro && $existsLibro))
        {
            $query = "SELECT ID, titulo, pagPrinc, pagFinal FROM capitulos WHERE IDLibro = ?";

            if ($idCapitulo != null) {
                $query = $query . " AND ID = ?";
            }

            $prep_query = $db_connection->prepare($query);

            if ($idCapitulo == null)
                $prep_query->bind_param('s', $idLibro);
            else
                $prep_query->bind_param('ss', $idLibro, $idCapitulo);

            $prep_query->execute();
            $lista = array();

            //IMPORTANT: IN OUR SERVER, I COULD NOT USE EITHER GET_RESULT OR FETCH_OBJECT,
            // PHP VERSION WAS OK (5.4), AND MYSQLI INSTALLED.
            // PROBABLY THE PROBLEM IS THAT MYSQLND DRIVER IS NEEDED AND WAS NOT AVAILABLE IN THE SERVER:
            // http://stackoverflow.com/questions/10466530/mysqli-prepared-statement-unable-to-get-result

            $prep_query->bind_result($cap, $tit, $pPri, $pFin);
            while ($prep_query->fetch())
            {
                $capitulo = new CapituloModel($cap, $idLibro, $tit, $pPri, $pFin);
                $lista[] = $capitulo;
            }

        }
        $db->closeConnection();

        return sizeof($lista) == 1 ? $lista[0] : $lista;
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

    public static function idLibroExists($id)
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

    public static function idCapituloExists($idLibro, $idCap)
    {
        $res = false;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $query = "SELECT ID FROM capitulos WHERE IDLibro = ? AND ID = ?";
        $prep_query = $db_connection->prepare($query);
        $prep_query->bind_param('ss', $idLibro, $idCap);
        $prep_query->execute();
        $prep_query->bind_result($idComprobar);
        $prep_query->fetch();

        if($idComprobar == $idCap)
            $res = true;

        $db->closeConnection();

        return $res;
    }

}