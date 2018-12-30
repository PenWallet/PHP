<?php

class ComplementoHandlerModel
{
    public static function getListadoComplementos()
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $listaComplementos = null;

        $query = "SELECT ID, Nombre, Precio FROM Complementos";
        $stmt = sqlsrv_query($db_connection, $query);

        if($stmt != false)
        {
            $listaComplementos = array();

            while(sqlsrv_fetch($stmt))
            {
                $id = sqlsrv_get_field($stmt, 0);
                $nombre = sqlsrv_get_field($stmt, 1);
                $precio = sqlsrv_get_field($stmt, 2);

                $listaComplementos[] = new IngredienteModel($id, $nombre, $precio);
            }
        }
        else
            $listaComplementos = $stmt;

        sqlsrv_free_stmt($stmt);
        $db->closeConnection();

        return $listaComplementos;
    }

}