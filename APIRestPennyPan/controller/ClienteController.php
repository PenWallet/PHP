<?php

require_once "Controller.php";
require_once dirname(__DIR__) . "/Authentication.php";



class ClienteController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $listadoUsuarios = null;

        if(!isset($request->getUrlElements()[2]))
        {
            $listadoUsuarios = ClienteHandlerModel::getListadoUsuarios();

            if ($listadoUsuarios != null)
                $code = '200'; //OK
            else
                $code = '500'; //Internal Server Error
        }
        else
            $code = '204'; //No Content

        $headers = array();
        $headers["Authentication"] = "Bearer ".$request->getToken();

        $response = new Response($code, $headers, $listadoUsuarios, $request->getAccept());
        $response->generate();
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
        {
            $code = '201'; //Created
            $request->setToken(Authentication::generateTokenFromLogin($usuarioCreado));
        }

        $headers = array();
        $headers["Authentication"] = "Bearer ".$request->getToken();

        $response = new Response($code, $headers, null, $request->getAccept());
        $response->generate();

    }

    public function managePatchVerb(Request $request)
    {
        $response = null;
        $code = null;
        $usuarioCreado = null;

        $usuario = (object)$request->getBodyParameters();

        if(isset($usuario->username) && isset($usuario->panadero))
        {
            $success = ClienteHandlerModel::cambiarPanaderoUsuario($usuario);

            if($success === true)
                $code = '204'; //No Content
            else
                $code = '404'; //Not Found
        }
        else
            $code = '400'; //Bad Request

        $headers = array();
        $headers["Authentication"] = "Bearer ".$request->getToken();

        $response = new Response($code, $headers, null, $request->getAccept());
        $response->generate();

    }

}