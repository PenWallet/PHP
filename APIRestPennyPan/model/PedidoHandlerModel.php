<?php

class PedidoHandlerModel
{
    public static function getPedido($username, $idPedido)
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $pedido = null;
        $pan = null;
        $panBocata = null;
        $complemento = null;
        $bocata = null;

        $query = "SELECT FechaCompra, ImporteTotal FROM Pedidos WHERE ClienteUsername = ? AND ID = ?";
        $queryPanes = "SELECT ID, Nombre, Crujenticidad, Integral, Precio, Cantidad FROM Panes AS P INNER JOIN PedidosPanes AS PP ON P.ID = PP.IDPan WHERE PP.IDPedido = ?";
        $queryComplementos = "SELECT ID, Nombre, Precio, Cantidad FROM Complementos AS C INNER JOIN PedidosComplementos AS PC ON C.ID = PC.IDComplemento WHERE PC.IDPedido = ?";
        $queryBocatas = "SELECT B.ID AS IDBocata, P.ID, Nombre, Crujenticidad, Integral, Precio FROM Bocatas AS B INNER JOIN Panes AS P ON B.IDPan = P.ID WHERE IDPedido = ?";
        $queryBocataIngredientes = "SELECT ID, Nombre, Precio, Cantidad FROM Ingredientes AS I INNER JOIN BocatasIngredientes AS BI ON I.ID = BI.IDIngrediente WHERE BI.IDBocata = ?";
        $stmtPedido = sqlsrv_prepare($db_connection, $query, array($username, $idPedido));

        //Se puede ejecutar
        if(sqlsrv_execute($stmtPedido))
        {
            //Existe un pedido así
            while(sqlsrv_fetch($stmtPedido))
            {
                $arrayPanes = array();
                $arrayComplementos = array();
                $arrayBocatas = array();
                $arrayIngredientes = array();
                $idBocata = null;
                $stmtPanes = sqlsrv_prepare($db_connection, $queryPanes, array($idPedido));
                $stmtComplementos = sqlsrv_prepare($db_connection, $queryComplementos, array($idPedido));
                $stmtBocatas = sqlsrv_prepare($db_connection, $queryBocatas, array($idPedido));
                $stmtBocataIngredientes = sqlsrv_prepare($db_connection, $queryBocataIngredientes, array(&$idBocata));

                $fechaCompra = sqlsrv_get_field($stmtPedido, 0)->format('Y/m/d');
                $importeTotal = sqlsrv_get_field($stmtPedido, 1);

                if(sqlsrv_execute($stmtPanes))
                {
                    while(sqlsrv_fetch($stmtPanes))
                    {
                        $idPan = sqlsrv_get_field($stmtPanes, 0);
                        $nombrePan = sqlsrv_get_field($stmtPanes, 1);
                        $crujenticidadPan = sqlsrv_get_field($stmtPanes, 2);
                        $integralPan = sqlsrv_get_field($stmtPanes, 3);
                        $precioPan = sqlsrv_get_field($stmtPanes, 4);
                        $cantidadPan = sqlsrv_get_field($stmtPanes, 5);

                        $arrayPanes[] = new PanPedidoModel($idPan, $nombrePan, $crujenticidadPan, $integralPan, $precioPan, $cantidadPan);
                    }
                }

                if(sqlsrv_execute($stmtComplementos))
                {
                    while(sqlsrv_fetch($stmtComplementos))
                    {
                        $idComp = sqlsrv_get_field($stmtComplementos, 0);
                        $nombreComp = sqlsrv_get_field($stmtComplementos, 1);
                        $precioComp = sqlsrv_get_field($stmtComplementos, 2);
                        $cantidadComp = sqlsrv_get_field($stmtComplementos, 3);

                        $complemento = new ComplementoPedidoModel($idComp, $nombreComp, $precioComp, $cantidadComp);

                        $arrayComplementos[] = $complemento;
                    }
                }

                if(sqlsrv_execute($stmtBocatas))
                {
                    while(sqlsrv_fetch($stmtBocatas))
                    {
                        $idBocata = sqlsrv_get_field($stmtBocatas, 0);

                        $idPan = sqlsrv_get_field($stmtBocatas, 1);
                        $nombrePan = sqlsrv_get_field($stmtBocatas, 2);
                        $crujenticidadPan = sqlsrv_get_field($stmtBocatas, 3);
                        $integralPan = sqlsrv_get_field($stmtBocatas, 4);
                        $precioPan = sqlsrv_get_field($stmtBocatas, 5);

                        $panBocata = new PanModel($idPan, $nombrePan, $crujenticidadPan, $integralPan, $precioPan);

                        if(sqlsrv_execute($stmtBocataIngredientes))
                        {
                            while(sqlsrv_fetch($stmtBocataIngredientes))
                            {
                                $idIngr = sqlsrv_get_field($stmtBocataIngredientes, 0);
                                $nombreIngr = sqlsrv_get_field($stmtBocataIngredientes, 1);
                                $precioIngr = sqlsrv_get_field($stmtBocataIngredientes, 2);
                                $cantidadIngr = sqlsrv_get_field($stmtBocataIngredientes, 3);

                                $arrayIngredientes[] = new IngredienteBocataModel($idIngr, $nombreIngr, $precioIngr, $cantidadIngr);
                            }
                        }

                        $arrayBocatas[] = new BocataModel($panBocata, $arrayIngredientes);
                    }
                }

                $pedido = new PedidoModel($idPedido, $fechaCompra, $importeTotal, $arrayBocatas, $arrayPanes, $arrayComplementos);

            }
        }

        sqlsrv_free_stmt($stmtPedido);
        $db->closeConnection();

        return $pedido;
    }

    public static function getListadoPedidos($username)
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $pedido = null;
        $pan = null;
        $panBocata = null;
        $complemento = null;
        $bocata = null;
        $arrayPedidos = array();

        $query = "SELECT ID, FechaCompra, ImporteTotal FROM Pedidos WHERE ClienteUsername = ?";
        $queryPanes = "SELECT ID, Nombre, Crujenticidad, Integral, Precio, Cantidad FROM Panes AS P INNER JOIN PedidosPanes AS PP ON P.ID = PP.IDPan WHERE PP.IDPedido = ?";
        $queryComplementos = "SELECT ID, Nombre, Precio, Cantidad FROM Complementos AS C INNER JOIN PedidosComplementos AS PC ON C.ID = PC.IDComplemento WHERE PC.IDPedido = ?";
        $queryBocatas = "SELECT B.ID AS IDBocata, P.ID, Nombre, Crujenticidad, Integral, Precio FROM Bocatas AS B INNER JOIN Panes AS P ON B.IDPan = P.ID WHERE IDPedido = ?";
        $queryBocataIngredientes = "SELECT ID, Nombre, Precio, Cantidad FROM Ingredientes AS I INNER JOIN BocatasIngredientes AS BI ON I.ID = BI.IDIngrediente WHERE BI.IDBocata = ?";
        $stmtPedido = sqlsrv_prepare($db_connection, $query, array($username));


        //Se puede ejecutar
        if(sqlsrv_execute($stmtPedido))
        {
            $esPrimerPedido = true;
            //Existe un pedido así
            while(sqlsrv_fetch($stmtPedido))
            {
                $idPedido = sqlsrv_get_field($stmtPedido, 0);
                $fechaCompra = sqlsrv_get_field($stmtPedido, 1)->format('Y/m/d');
                $importeTotal = sqlsrv_get_field($stmtPedido, 2);

                $arrayPanes = array();
                $arrayComplementos = array();
                $arrayBocatas = array();
                $arrayIngredientes = array();
                $idBocata = null;

                if($esPrimerPedido)
                {
                    $stmtPanes = sqlsrv_prepare($db_connection, $queryPanes, array(&$idPedido));
                    $stmtComplementos = sqlsrv_prepare($db_connection, $queryComplementos, array(&$idPedido));
                    $stmtBocatas = sqlsrv_prepare($db_connection, $queryBocatas, array(&$idPedido));
                    $stmtBocataIngredientes = sqlsrv_prepare($db_connection, $queryBocataIngredientes, array(&$idBocata));
                    $arrayPedidos = array();
                    $esPrimerPedido = false;
                }

                if(sqlsrv_execute($stmtPanes))
                {
                    while(sqlsrv_fetch($stmtPanes))
                    {
                        $idPan = sqlsrv_get_field($stmtPanes, 0);
                        $nombrePan = sqlsrv_get_field($stmtPanes, 1);
                        $crujenticidadPan = sqlsrv_get_field($stmtPanes, 2);
                        $integralPan = sqlsrv_get_field($stmtPanes, 3);
                        $precioPan = sqlsrv_get_field($stmtPanes, 4);
                        $cantidadPan = sqlsrv_get_field($stmtPanes, 5);

                        $arrayPanes[] = new PanPedidoModel($idPan, $nombrePan, $crujenticidadPan, $integralPan, $precioPan, $cantidadPan);
                    }
                }

                if(sqlsrv_execute($stmtComplementos))
                {
                    while(sqlsrv_fetch($stmtComplementos))
                    {
                        $idComp = sqlsrv_get_field($stmtComplementos, 0);
                        $nombreComp = sqlsrv_get_field($stmtComplementos, 1);
                        $precioComp = sqlsrv_get_field($stmtComplementos, 2);
                        $cantidadComp = sqlsrv_get_field($stmtComplementos, 3);

                        $complemento = new ComplementoPedidoModel($idComp, $nombreComp, $precioComp, $cantidadComp);

                        $arrayComplementos[] = $complemento;
                    }
                }

                if(sqlsrv_execute($stmtBocatas))
                {
                    while(sqlsrv_fetch($stmtBocatas))
                    {
                        $idBocata = sqlsrv_get_field($stmtBocatas, 0);

                        $idPan = sqlsrv_get_field($stmtBocatas, 1);
                        $nombrePan = sqlsrv_get_field($stmtBocatas, 2);
                        $crujenticidadPan = sqlsrv_get_field($stmtBocatas, 3);
                        $integralPan = sqlsrv_get_field($stmtBocatas, 4);
                        $precioPan = sqlsrv_get_field($stmtBocatas, 5);

                        $panBocata = new PanModel($idPan, $nombrePan, $crujenticidadPan, $integralPan, $precioPan);

                        if(sqlsrv_execute($stmtBocataIngredientes))
                        {
                            while(sqlsrv_fetch($stmtBocataIngredientes))
                            {
                                $idIngr = sqlsrv_get_field($stmtBocataIngredientes, 0);
                                $nombreIngr = sqlsrv_get_field($stmtBocataIngredientes, 1);
                                $precioIngr = sqlsrv_get_field($stmtBocataIngredientes, 2);
                                $cantidadIngr = sqlsrv_get_field($stmtBocataIngredientes, 3);

                                $arrayIngredientes[] = new IngredienteBocataModel($idIngr, $nombreIngr, $precioIngr, $cantidadIngr);
                            }
                        }

                        $arrayBocatas[] = new BocataModel($panBocata, $arrayIngredientes);
                    }
                }

                $arrayPedidos[] = new PedidoModel($idPedido, $fechaCompra, $importeTotal, $arrayBocatas, $arrayPanes, $arrayComplementos);

            }
        }

        sqlsrv_free_stmt($stmtPedido);
        $db->closeConnection();

        return $arrayPedidos;
    }

}