<?php

require_once "Controller.php";
require_once dirname(__DIR__)."/Tokens.php";



class ClienteController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $response = null;
        $code = null;
        $authUser = $request->getAuthUser();
        $authPass = $request->getAuthPass();
        $username = null;
        $listadoUsuarios = null;

        //Si
        if(isset($request->getUrlElements()[2]))
        {
            $username = $request->getUrlElements()[2];

            if($authUser != null && $authPass != null && $authUser == $username) {

                $listadoUsuarios = ClienteHandlerModel::getUsuario($authUser, $authPass);

                if($listadoUsuarios == null)
                    $code = '401'; //Unauthorized
                else
                {
                    $code = '200'; //OK
                    Tokens::generateTokenFromLogin($listadoUsuarios);
                }


            }
            else if($authPass == null || $authUser == null)
                $code = '400'; //Bad Request
            else
                $code = '401';
        }
        else
        {
            if ($authUser != null && $authPass != null) {

                $panadero = ClienteHandlerModel::getUsuario($authUser, $authPass);

                if($panadero != null)
                {
                    $listadoUsuarios = ClienteHandlerModel::getListadoUsuarios($panadero);

                    if ($listadoUsuarios != null)
                        $code = '200'; //OK
                    else
                        $code = '401'; //Unauthorized
                }
                else
                    $code = '400'; //Bad Request
            }
        }



        $response = new Response($code, null, $listadoUsuarios, $request->getAccept());
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
            $code = '201'; //Created

        $response = new Response($code, null, $usuarioCreado, $request->getAccept());
        $response->generate();

    }

}