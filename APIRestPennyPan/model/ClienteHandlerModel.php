<?php

class ClienteHandlerModel
{

    public static function getUsuario($authUser, $authPass)
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $cliente = null;

        $query = "SELECT [Password], Nombre, Panadero FROM Clientes WHERE Username = ?";
        $prep_query = sqlsrv_prepare($db_connection, $query, array($authUser));

        if(sqlsrv_execute($prep_query))
        {
            sqlsrv_fetch($prep_query);
            $contrasena = sqlsrv_get_field($prep_query, 0);
            $contrasena = trim($contrasena, " ");
            if(password_verify($authPass, $contrasena))
                $cliente = new ClienteModel($authUser, $contrasena, sqlsrv_get_field($prep_query, 1), sqlsrv_get_field($prep_query, 2));
        }

        sqlsrv_free_stmt($prep_query);
        $db->closeConnection();

        return $cliente;
    }

    public static function getListadoUsuarios($panadero)
    {
        $listado = null;

        if($panadero->getPanadero() == 1)
        {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "SELECT Username, Nombre, Panadero FROM Clientes";
            $query = sqlsrv_query($db_connection, $query);

            if(sqlsrv_execute($query))
            {
                $listado = array();

                while(sqlsrv_fetch($query))
                {
                    if (sqlsrv_get_field($query, 2) == 0) //Si no es un panadero
                    {
                        $listado[] = new ClienteModel(sqlsrv_get_field($query, 0), "", sqlsrv_get_field($query, 1), sqlsrv_get_field($query, 2));
                    }
                }
            }

            sqlsrv_free_stmt($query);
            $db->closeConnection();
        }

        return $listado;
    }

}