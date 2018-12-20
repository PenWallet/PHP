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

            $query = "SELECT Username, Nombre, Panadero FROM Clientes WHERE Panadero = 0";
            $stmt = sqlsrv_query($db_connection, $query);
            $listado = array();

            while(sqlsrv_fetch($stmt) != false)
            {
                $usuario = sqlsrv_get_field($stmt, 0);
                $usuario = trim($usuario, " ");
                $nombre = sqlsrv_get_field($stmt, 1);
                $pan = sqlsrv_get_field($stmt, 2);
                $listado[] = new ClienteModel($usuario, "", $nombre, $pan);
            }

            sqlsrv_free_stmt($stmt);
            $db->closeConnection();
        }

        return $listado;
    }

    //Devuelve:
    // -2 si no se ha podido ejecutar nada
    // -1 si se han actualizado más de 1 filas
    // 0 si ha ido todo bien
    public static function insertarUsuario($usuario)
    {
        $listado = null;
        $creado = -2;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $contrasenaHashed = password_hash($usuario->contrasena, PASSWORD_BCRYPT);
        $parametros = array($usuario->username, $contrasenaHashed, $usuario->nombre, $usuario->panadero);

        $query = "INSERT INTO Clientes (Username, [Password], Nombre, Panadero) VALUES (?,?,?,?)";
        $stmt = sqlsrv_prepare($db_connection, $query, $parametros);
        $resultado = sqlsrv_execute($stmt);

        if($resultado == -2)
        {
            if(sqlsrv_rows_affected($stmt) == 1)
                $creado = 0;
            else
                $creado = -1;
        }

        sqlsrv_free_stmt($stmt);
        $db->closeConnection();

        return $creado;
    }

}