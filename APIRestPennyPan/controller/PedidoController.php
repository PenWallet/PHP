<?php

require_once "Controller.php";


class PedidoController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $response = null;
        $code = null;
        $authUser = $request->getAuthUser();
        $authPass = $request->getAuthPass();
        $username = isset($request->getUrlElements()[2]) ? $request->getUrlElements()[2] : null;
        $idPedido = isset($request->getUrlElements()[4]) ? $request->getUrlElements()[4] : null;
        $listaPedidos = null;

        if(isset($request->getUrlElements()[3]) && strtolower($request->getUrlElements()[3]) == "pedido")
        {
            if(($authUser != null && $authPass != null) && $authUser == $username)
            {
                $cliente = ClienteHandlerModel::getUsuario($authUser, $authPass);
                if($cliente != null)
                {
                    if($idPedido == null)
                    {
                        $listaPedidos = PedidoHandlerModel::getListadoPedidos($username); //Obtener todos los pedidos del usuario

                        if($listaPedidos == null)
                            $code = '204'; //No Content
                        else
                            $code = '200'; //OK
                    }
                    else
                    {
                        $listaPedidos = PedidoHandlerModel::getPedido($username, $idPedido); //Obtener solo ese pedido
                        if($listaPedidos == null)
                            $code = '404'; //Not Found
                        else
                            $code = '200'; //OK
                    }
                }
                else
                    $code = '401'; //Unauthorized
            }
            else
                $code = '401'; //Unauthorized
        }
        else
            $code = '404'; //Not Found


        $response = new Response($code, null, $listaPedidos, $request->getAccept());
        $response->generate();

    }

    public function managePostVerb(Request $request)
    {
        $response = null;
        $code = null;
        $authUser = $request->getAuthUser();
        $authPass = $request->getAuthPass();
        $username = isset($request->getUrlElements()[2]) ? $request->getUrlElements()[2] : null;
        $listaPedidos = null;
        $pedido = $request->getBodyParameters();
        $pedidoResponse = null;

        if($pedido != null)
        {
            if(isset($request->getUrlElements()[3]) && strtolower($request->getUrlElements()[3]) == "pedido")
            {
                if(($authUser != null && $authPass != null) && $authUser == $username)
                {
                    $cliente = ClienteHandlerModel::getUsuario($authUser, $authPass);
                    if($cliente != null)
                    {
                        $pedidoResponse = PedidoHandlerModel::postPedido($pedido, $username);

                        if($pedidoResponse == null)
                            $code = '500'; //Server Internal Error
                        else
                            $code = '200';
                    }
                    else
                        $code = '401'; //Unauthorized
                }
                else
                    $code = '401'; //Unauthorized
            }
            else
                $code = '404'; //Not Found
        }
        else
            $code = '400'; //Bad Request



        $response = new Response($code, null, $pedidoResponse, $request->getAccept());
        $response->generate();

    }
}