<?php

require_once "Controller.php";
require_once dirname(__DIR__) . "/Authentication.php";



class ClienteController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $response = new Response("204", null, null, $request->getAccept());
        $response->generate($request->getToken());
    }

    public function managePostVerb(Request $request)
    {
        $response = null;
        $code = null;
        $usuarioCreado = null;

        $usuario = (object)$request->getBodyParameters();

        $usuarioCreado = ClienteHandlerModel::insertarUsuario($usuario);

        if($usuarioCreado == null)
            $code = '409'; //Conflict
        else
            $code = '201'; //Created

        $response = new Response($code, null, null, $request->getAccept());
        $response->generate($request->getToken());

    }

}