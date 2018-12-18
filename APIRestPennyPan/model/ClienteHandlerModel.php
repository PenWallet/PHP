<?php

class ClienteHandlerModel
{

    public static function getUsuario($authUser, $authPass)
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $cliente = null;

        $query = "SELECT [Password], Nombre, Panadero FROM Clientes WHERE Username = ?";
        $prep_query = sqlsrv_prepare($db_connection, $query, array(&$authUser));

        if(sqlsrv_execute($prep_query))
        {
            sqlsrv_fetch($prep_query);
            if(password_verify($authPass, sqlsrv_get_field($prep_query, 0)))
                $cliente = new ClienteModel($authUser, sqlsrv_get_field($prep_query, 0), sqlsrv_get_field($prep_query, 1), sqlsrv_get_field($prep_query, 2));
        }

        sqlsrv_free_stmt($prep_query);
        $db->closeConnection();
    }

}