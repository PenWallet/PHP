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

    //Devuelve el usuario registrado
    public static function insertarUsuario($usuario)
    {
        $cliente = null;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $contrasenaHashed = password_hash($usuario->contrasena, PASSWORD_BCRYPT);
        $parametros = array($usuario->username, $contrasenaHashed, $usuario->nombre, $usuario->panadero);

        $query = "INSERT INTO Clientes (Username, [Password], Nombre, Panadero) VALUES (?,?,?,?)";
        $stmt = sqlsrv_prepare($db_connection, $query, $parametros);
        $resultado = sqlsrv_execute($stmt);

        sqlsrv_free_stmt($stmt);
        $db->closeConnection();

        if($resultado === true)
        {
            $cliente = self::getUsuario($usuario->username, $usuario->contrasena);
        }

        return $cliente;
    }

}