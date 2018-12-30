<?php

class IngredienteHandlerModel
{
    public static function getListadoIngredientes()
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $listaIngredientes = null;

        $query = "SELECT ID, Nombre, Precio FROM Ingredientes";
        $stmt = sqlsrv_query($db_connection, $query);

        if($stmt != false)
        {
            $listaIngredientes = array();

            while(sqlsrv_fetch($stmt))
            {
                $id = sqlsrv_get_field($stmt, 0);
                $nombre = sqlsrv_get_field($stmt, 1);
                $precio = sqlsrv_get_field($stmt, 2);

                $listaIngredientes[] = new IngredienteModel($id, $nombre, $precio);
            }
        }
        else
            $listaIngredientes = $stmt;

        sqlsrv_free_stmt($stmt);
        $db->closeConnection();

        return $listaIngredientes;
    }

}