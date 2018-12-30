<?php

class PanHandlerModel
{
    public static function getListadoPanes()
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $listaPanes = null;

        $query = "SELECT ID, Nombre, Crujenticidad, Integral, Precio FROM Panes";
        $stmt = sqlsrv_query($db_connection, $query);

        if($stmt != false)
        {
            $listaPanes = array();

            while(sqlsrv_fetch($stmt))
            {
                $id = sqlsrv_get_field($stmt, 0);
                $nombre = sqlsrv_get_field($stmt, 1);
                $crujenticidad = sqlsrv_get_field($stmt, 2);
                $integral = sqlsrv_get_field($stmt, 3);
                $precio = sqlsrv_get_field($stmt, 4);

                $listaPanes[] = new PanModel($id, $nombre, $crujenticidad, $integral, $precio);
            }
        }
        else
            $listaPanes = $stmt;

        sqlsrv_free_stmt($stmt);
        $db->closeConnection();

        return $listaPanes;
    }

}