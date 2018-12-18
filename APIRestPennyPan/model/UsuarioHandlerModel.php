<?php

require_once "ConsLibrosModel.php";


class UsuarioHandlerModel
{

    public static function getUsuario($username)
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();


        //If the $id is valid or the client asks for the collection ($id is null)
        if ($username != null) {
            $query = "SELECT dbo.ValidarUsernameUsuario(?) AS ret";
            $prep_query = $db_connection->prepare($query);
            $prep_query->bind_param('s', $username);
            $prep_query->execute();
            $prep_query->bind_result($ret);

            if($ret == 1)
            {
                $query = "SELECT * FROM Usuarios WHERE Username = ?";
            }


            $prep_query = $db_connection->prepare($query);

            //IMPORTANT: If we do not want to expose our primary keys in the URIS,
            //we can use a function to transform them.
            //For example, we can use hash_hmac:
            //http://php.net/manual/es/function.hash-hmac.php
            //In this example we expose primary keys considering pedagogical reasons

            if ($id != null) {
                $prep_query->bind_param('s', $id);
            }

            $prep_query->execute();
            $listaLibros = array();

            //IMPORTANT: IN OUR SERVER, I COULD NOT USE EITHER GET_RESULT OR FETCH_OBJECT,
            // PHP VERSION WAS OK (5.4), AND MYSQLI INSTALLED.
            // PROBABLY THE PROBLEM IS THAT MYSQLND DRIVER IS NEEDED AND WAS NOT AVAILABLE IN THE SERVER:
            // http://stackoverflow.com/questions/10466530/mysqli-prepared-statement-unable-to-get-result

            $prep_query->bind_result($cod, $tit, $pag);
            while ($prep_query->fetch()) {
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

        return $listaLibros;
    }

}