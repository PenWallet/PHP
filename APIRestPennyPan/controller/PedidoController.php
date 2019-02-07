<?php

require_once "Controller.php";
require_once dirname(__DIR__) . "/Authentication.php";

class PedidoController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $response = null;
        $code = null;
        $idPedido = isset($request->getUrlElements()[4]) ? $request->getUrlElements()[4] : null;
        $listaPedidos = null;

        if(isset($request->getUrlElements()[3]) && strtolower($request->getUrlElements()[3]) == "pedido")
        {
            $payload = Authentication::getPayloadFromToken($request->getToken());
            $username = $payload->data->username;

            if($idPedido == null)
            {
                $listaPedidos = PedidoHandlerModel::getListadoPedidos($username); //Obtener todos los pedidos del usuario

                if($listaPedidos == null)
                    $code = '500'; //Internal Server Error
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
            $code = '404'; //Not Found

        $headers = array();
        $headers["Authentication"] = "Bearer ".$request->getToken();

        $response = new Response($code, $headers, $listaPedidos, $request->getAccept());
        $response->generate();

    }

    public function managePostVerb(Request $request)
    {
        $response = null;
        $code = null;
        $listaPedidos = null;
        $pedido = $request->getBodyParameters();
        $pedidoResponse = null;

        if($pedido != null)
        {
            if(isset($request->getUrlElements()[3]) && strtolower($request->getUrlElements()[3]) == "pedido")
            {
                $payload = Authentication::getPayloadFromToken($request->getToken());
                $username = $payload->data->username;

                $pedidoResponse = PedidoHandlerModel::postPedido($pedido, $username);

                if($pedidoResponse == null)
                    $code = '500'; //Server Internal Error
                else
                    $code = '200';
            }
            else
                $code = '404'; //Not Found
        }
        else
            $code = '400'; //Bad Request

        $headers = array();
        $headers["Authentication"] = "Bearer ".$request->getToken();

        $response = new Response($code, $headers, $pedidoResponse, $request->getAccept());
        $response->generate();

    }
}